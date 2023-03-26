<?php
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (!empty($_GET['save'])) {
    print('Данные были сохранены');
  }
  include('form.php');
}
else{
    $regex_name="/[a-z,A-Z,а-я,А-Я,-]*$/";
    $regex_email="/[a-z]+\w*@[a-z]+\.[a-z]{2,4}$/";
    $errors = FALSE;
    if (empty($_POST['name']) or !preg_match($regex_name,$_POST['name'])) {
    print('Заполните имя правильно.<br/>');
    $errors = TRUE;
    }
    if (empty($_POST['email']) or !preg_match($regex_name,$_POST['email'])){
    print('Заполните почту правильно.<br/>');
    $errors = TRUE;
    }
    if ($_POST['year']=='Выбрать'){
    print('Выберите год рождения.<br/>');
    $errors = TRUE;
    }
    if (empty($_POST['sex'])){
    print('Выберите пол.<br/>');
    $errors = TRUE;
    }
    if (empty($_POST['limb'])){
    print('Выберите сколько у вас конечностей.<br/>');
    $errors = TRUE;
    }
    if(!isset($_POST['power'])){
        print('Выберите хотя бы одну суперспособность.<br/>');
        $errors=TRUE;
    }
    if ($errors) {
    print_r('Исправьте ошибки');
    exit();
    }

    $user = 'u52821';
    $pass = '8567731';
    $db = new PDO('mysql:host=localhost;dbname=u52821', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

    try {
    $stmt = $db->prepare("INSERT INTO form SET name=?,email=?,year=?,sex=?,limb=?,bio=?,checked=?");
    $stmt -> execute(array($_POST['name'],$_POST['email'],$_POST['year'],$_POST['sex'],$_POST['limb'],$_POST['bio'],$_POST['checked']));
    $id=$db->lastInsertId();
    $pwr=$db->prepare("INSERT INTO form1 SET p_name=?,uid=?");
    foreach($_POST['power'] as $power){ 
        $pwr->execute(array($power,$id));  
    }
    }
    catch(PDOException $e){
    print('Error : ' . $e->getMessage());
    exit();
    }
    header('Location: ?save=1');
}
?>
