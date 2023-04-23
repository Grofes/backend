<?php
header('Content-Type: text/html; charset=UTF-8');
$power = array('1','2','3');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $messages = array();
  if (!empty($_COOKIE['save'])) {
    setcookie('save', '', 100000);
    $messages[] = 'Спасибо, результаты сохранены.';
  }
  $errors = array(
    'name'=>!empty($_COOKIE['name_error']),
    'email'=>!empty($_COOKIE['email_error']),
    'year'=>!empty($_COOKIE['year_error']),
    'sex'=>!empty($_COOKIE['sex_error']),
    'limb'=>!empty($_COOKIE['limb_error']),
    'form1'=>!empty($_COOKIE['form1_error']),
    'check'=>!empty($_COOKIE['check_error']),
  );
  if ($errors['name']) {
    $messages[] = '<div class="error">Заполните или исправьте имя.</div>';
  }
  if ($errors['email']) {
    $messages[] = '<div class="error">Заполните или исправьте почту.</div>';
  }
  if ($errors['year']) {
    $messages[] = '<div class="error">Выберите год рождения.</div>';
  }
  if ($errors['sex']) {
    $messages[] = '<div class="error">Выберите пол.</div>';
  }
  if ($errors['limb']) {
    $messages[] = '<div class="error">Выберите сколько у вас конечностей.</div>';
  }
  if ($errors['form1']) {
    $messages[] = '<div class="error">Выберите хотя бы одну суперспособность.</div>';
  }
  if ($errors['check']) {
    $messages[] = '<div class="error">Необходимо согласиться с политикой конфиденциальности.</div>';
  }

  $values = array();
  $values['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
  $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
  $values['year'] = empty($_COOKIE['year_value']) ? 0 : $_COOKIE['year_value'];
  $values['sex'] = empty($_COOKIE['sex_value']) ? '' : $_COOKIE['sex_value'];
  $values['limb'] = empty($_COOKIE['limb_value']) ? '' : $_COOKIE['limb_value'];
  $values['form1'] = empty($_COOKIE['form1_value']) ? 0 : $_COOKIE['form1_value'];
  $values['bio'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];
  $values['check'] = empty($_COOKIE['check_value']) ? FALSE : $_COOKIE['check_value'];

  include('form.php');
}
else{
$regex_name="/^\w+[\w\s-]*$/";
$regex_email="/^[\w\.-]+@([\w-]+\.)+[\w-]{2,4}$/";
$errors = FALSE;
//проверка имени
if (empty($_POST['name']) or !preg_match($regex_name,$_POST['name'])) {
  setcookie('name_error', '1', time() + 24 * 60 * 60);
  setcookie('name_value', '', 100000);
  $errors = TRUE;
}
else {
  setcookie('name_value', $_POST['name'], time() + 12*30 * 24 * 60 * 60);
  setcookie('name_error','',100000);
}
//проверка почты
if (empty($_POST['email']) or !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)  or !preg_match($regex_email,$_POST['email'])) {
  setcookie('email_error', '1', time() + 24 * 60 * 60);
  setcookie('email_value', '', 100000);
  $errors = TRUE;
}
else {
  setcookie('email_value', $_POST['email'], time() + 12*30 * 24 * 60 * 60);
  setcookie('email_error','',100000);
}
//проверка года
if ($_POST['year']=='Выбрать' or ($_POST['year']<1800 and $_POST['year']>2023)) {
  setcookie('year_error', '1', time() + 24 * 60 * 60);
  setcookie('year_value', '', 100000);
  $errors = TRUE;
}
else {
  setcookie('year_value', intval($_POST['year']), time() + 12*30 * 24 * 60 * 60);
  setcookie('year_error','',100000);
}
//проверка пола
if (!isset($_POST['sex']) or ($_POST['sex']!='1' and $_POST['sex']!='2')) {
  setcookie('sex_error', '1', time() + 24 * 60 * 60);
  setcookie('sex_value', '', 100000);
  $errors = TRUE;
}
else {
  setcookie('sex_value', $_POST['sex'], time() + 12*30 * 24 * 60 * 60);
  setcookie('sex_error','',100000);
}
//проверка конечностей
if (!isset($_POST['limb']) or ($_POST['limb']<1 and $_POST['limb']>4)) {
  setcookie('limb_error', '1', time() + 24 * 60 * 60);
  setcookie('limb_value', '', 100000);
  $errors = TRUE;
}
else {
  setcookie('limb_value', $_POST['limb'], time() + 12*30 * 24 * 60 * 60);
  setcookie('limb_error','',100000);
}
//проверка суперспособностей
if (!isset($_POST['form1'])) {
  setcookie('form1_error', '1', time() + 24 * 60 * 60);
  setcookie('form1_value', '', 100000);
  $errors = TRUE;
}
else {
  setcookie('form1_value', $_POST['form1'], time() + 12*30 * 24 * 60 * 60);
}
//запись куки для биографии
setcookie('bio_value',$_POST['bio'],time()+ 12*30*24*60*60);
//проверка согласия с политикой конфиденциальности
if(!isset($_POST['checked'])){
  setcookie('check_error','1',time()+ 24*60*60);
  setcookie('check_value', '', 100000);
  $errors=TRUE;
}
else{
  setcookie('check_value',TRUE,time()+ 12*30*24*60*60);
  setcookie('check_error','',100000);
}

if ($errors) {
  header('Location: index.php');
  exit();
}
else {
  setcookie('name_error', '', 100000);
  setcookie('email_error', '', 100000);
  setcookie('year_error', '', 100000);
  setcookie('sex_error', '', 100000);
  setcookie('limb_error', '', 100000);
  setcookie('form1_error', '', 100000);
  setcookie('bio_error', '', 100000);
  setcookie('check_error', '', 100000);
}

$name=$_POST['name'];
$email=$_POST['email'];
$year=$_POST['year'];
$sex=$_POST['sex'];
$limb=$_POST['limb'];
$bio=$_POST['bio'];
$powers=$_POST['form1'];
$user = 'u52821';
$pass = '8567731';
$check=$_POST['checked'];
$db = new PDO('mysql:host=localhost;dbname=u52821', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

try {
  $stmt = $db->prepare("INSERT INTO form SET name=?,email=?,year=?,sex=?,limb=?,bio=?,checked=?");
  $stmt -> execute(array($name,$email,$year,$sex,$limb,$bio,$check));
  $pwr=$db->prepare("INSERT INTO form1 SET power_id=:power,person_id=:person");
  $id=$db->lastInsertId();
  $pwr->bindParam(':person', $id);
  foreach($powers as $power){  
    $pwr->bindParam(':power', $power);
        if($pwr->execute()==false){
          print_r($pwr->errorCode());
          print_r($pwr->errorInfo());
          exit();
        }
  }
}
catch(PDOException $e){
  print('Error : ' . $e->getMessage());
  exit();
}

setcookie('save', '1');
header('Location: index.php');
}
