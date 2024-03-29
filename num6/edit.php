<?php
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $messages = array();
  if (!empty($_COOKIE['save'])) {
    setcookie('save', '', 100000);
    $messages[] = 'Спасибо, результаты сохранены.';
    setcookie('name_value', '', 100000);
    setcookie('mail_value', '', 100000);
    setcookie('year_value', '', 100000);
    setcookie('sex_value', '', 100000);
    setcookie('limb_value', '', 100000);
    setcookie('bio_value', '', 100000);
    setcookie('1_value', '', 100000);
    setcookie('2_value', '', 100000);
    setcookie('3_value', '', 100000);
    setcookie('checked_value', '', 100000);
  }
  //Ошибки
  
  $errors = array();
  $error=FALSE;
  $errors['name'] = !empty($_COOKIE['name_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['year'] = !empty($_COOKIE['year_error']);
  $errors['sex'] = !empty($_COOKIE['sex_error']);
  $errors['limb'] = !empty($_COOKIE['limb_error']);
  $errors['form1'] = !empty($_COOKIE['form1_error']);
  $errors['checked'] = !empty($_COOKIE['checked_error']);
  if ($errors['name']) {
    setcookie('name_error', '', 100000);
    $messages[] = '<div class="error">Заполните имя.</div>';
    $error=TRUE;
  }
  if ($errors['email']) {
    setcookie('email_error', '', 100000);
    $messages[] = '<div class="error">Заполните или исправьте почту.</div>';
    $error=TRUE;
  }
  if ($errors['year']) {
    setcookie('year_error', '', 100000);
    $messages[] = '<div class="error">Выберите год рождения.</div>';
    $error=TRUE;
  }
  if ($errors['sex']) {
    setcookie('sex_error', '', 100000);
    $messages[] = '<div class="error">Выберите пол.</div>';
    $error=TRUE;
  }
  if ($errors['limb']) {
    setcookie('limb_error', '', 100000);
    $messages[] = '<div class="error">Выберите сколько у вас конечностей.</div>';
    $error=TRUE;
  }
  if ($errors['form1']) {
    setcookie('form1_error', '', 100000);
    $messages[] = '<div class="error">Выберите хотя бы одну суперспособность.</div>';
    $error=TRUE;
  }
  if ($errors['checked']) {
    setcookie('checked_error', '', 100000);
    $messages[] = '<div class="error">Необходимо согласиться с политикой конфиденциальности.</div>';
    $error=TRUE;
  }
  $values = array();
  $values['1']=0;
  $values['2']=0;
  $values['3']=0;
  include('connect.php');
  try{
      $id=$_GET['edit_id'];
      $get=$db->prepare("select * from form where id=?");
      $get->execute(array($id));
      $user=$get->fetchALL();
      $values['name']=$user[0]['name'];
      $values['email']=$user[0]['email'];
      $values['year']=$user[0]['year'];
      $values['sex']=$user[0]['sex'];
      $values['limb']=$user[0]['limb'];
      $values['bio']=$user[0]['bio'];
      $get2=$db->prepare("select power_id from form1 where person_id=?");
      $get2->execute(array($id));
      $pwrs=$get2->fetchALL();
      for($i=0;$i<count($pwrs);$i++){
        if($pwrs[$i]['power_id']=='1'){
          $values['1']=1;
        }
        if($pwrs[$i]['power_id']=='2'){
          $values['2']=1;
        }
        if($pwrs[$i]['power_id']=='3'){
          $values['3']=1;
        }
      }
  }
  catch(PDOException $e){
      print('Error: '.$e->getMessage());
      exit();
  }
  include('form.php');
}
else {
  if(!empty($_POST['edit'])){
    $regex_name='/[a-z,A-Z,а-я,А-Я,-]*$/';
    $regex_email='/[a-z]+\w*@[a-z]+\.[a-z]{2,4}$/';
    $id=$_POST['id'];
    $name=$_POST['name'];
    $email=$_POST['email'];
    $year=$_POST['year'];
    $sex=$_POST['sex'];
    $limb=$_POST['limb'];
    $pwrs=$_POST['form1'];
    $bio=$_POST['bio'];
    if(empty($_SESSION['login'])){
      $check=$_POST['checked'];
    }
    $errors = FALSE;
    if (empty($name) or !preg_match($regex_name,$name)) {
      setcookie('name_error', '1', time() + 24*60 * 60);
      setcookie('name_value', '', 100000);
      $errors = TRUE;
    }
    else {
      setcookie('name_value', $name, time() + 60 * 60);
      setcookie('name_error','',100000);
    }
    //проверка почты
    if (empty($email) or !preg_match($regex_email,$email)) {
      setcookie('email_error', '1', time() + 24*60 * 60);
      setcookie('email_value', '', 100000);
      $errors = TRUE;
    }
    else {
      setcookie('email_value', $email, time() + 60 * 60);
      setcookie('email_error','',100000);
    }
    //проверка года
    if ($year=='Выбрать' or ($year<1800 and $year>2022)) {
      setcookie('year_error', '1', time() + 24 * 60 * 60);
      setcookie('year_value', '', 100000);
      $errors = TRUE;
    }
    else {
      setcookie('year_value', intval($year), time() + 60 * 60);
      setcookie('year_error','',100000);
    }
    //проверка пола
    if (!isset($sex)  or ($sex!='1' and $sex!='2')) {
      setcookie('sex_error', '1', time() + 24 * 60 * 60);
      setcookie('sex_value', '', 100000);
      $errors = TRUE;
    }
    else {
      setcookie('sex_value', $sex, time() + 60 * 60);
      setcookie('sex_error','',100000);
    }
    //проверка конечностей
    if (!isset($limb)) {
      setcookie('limb_error', '1', time() + 24 * 60 * 60);
      setcookie('limb_value', '', 100000);
      $errors = TRUE;
    }
    else {
      setcookie('limb_value', $limb, time() + 60 * 60);
      setcookie('limb_error','',100000);
    }
    //проверка суперспособностей
    if (!isset($pwrs)) {
      setcookie('form1_error', '1', time() + 24 * 60 * 60);
      setcookie('1_value', '', 100000);
      setcookie('2_value', '', 100000);
      setcookie('3_value', '', 100000);
      $errors = TRUE;
    }
    else {
      $a=array(
        "1_value"=>0,
        "2_value"=>0,
        "3_value"=>0
      );
      foreach($pwrs as $pwr){
        if($pwr=='1'){setcookie('1_value', 1, time() + 60 * 60); $a['1_value']=1;} 
        if($pwr=='2'){setcookie('2_value', 1, time() + 60 * 60);$a['2_value']=1;} 
        if($pwr=='3'){setcookie('3_value', 1, time() + 60 * 60);$a['3_value']=1;} 
      }
      foreach($a as $c=>$val){
        if($val==0){
          setcookie($c,'',100000);
        }
      }
    }
    
    //запись куки для биографии
    setcookie('bio_value',$bio,time()+ 60*60);
  
    if ($errors) {
      setcookie('save','',100000);
      header('Location: login.php');
    }
    else {
      setcookie('name_error', '', 100000);
      setcookie('email_error', '', 100000);
      setcookie('year_error', '', 100000);
      setcookie('sex_error', '', 100000);
      setcookie('limb_error', '', 100000);
      setcookie('form1_error', '', 100000);
    }
    include('connect.php');
    if(!$errors){
        $upd=$db->prepare("update form set name=?,email=?,year=?,sex=?,limb=?,bio=? where id=?");
        $upd->execute(array($name,$email,$year,$sex,$limb,$bio,$id));
        $del=$db->prepare("delete from form1 where person_id=?");
        $del->execute(array($id));
        $upd=$db->prepare("insert into form1 set power_id=?,person_id=?");
        foreach($pwrs as $pwr){
          $upd->execute(array($pwr,$id));
        }
    }
    
    if(!$errors){
      setcookie('save', '1');
    }
    header('Location: edit.php?edit_id='.$id);
  }
  elseif(!empty($_POST['del'])) {
    $id=$_POST['id'];
    include('connect.php');
    try {
      $del=$db->prepare("delete from form1 where person_id=?");
      $del->execute(array($id));
      $stmt = $db->prepare("delete from form where id=?");
      $stmt -> execute(array($id));
    }
    catch(PDOException $e){
      print('Error : ' . $e->getMessage());
    exit();
    }
    setcookie('del','1');
    setcookie('del_user',$id);
    header('Location: admin.php');
  }
  else{
    header('Loction: admin.php');
  }
}
