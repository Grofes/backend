<?php
header('Content-Type: text/html; charset=UTF-8');
$bioreg = "/^\s*\w+[\w\s\.,-]*$/";
$reg = "/^\w+[\w\s-]*$/";
$mailreg = "/^[\w\.-]+@([\w-]+\.)+[\w-]{2,4}$/";
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $messages = array();
  if (!empty($_COOKIE['save'])) {
    setcookie('save', '', 100000);
    $messages[] = 'Спасибо, результаты сохранены.';
  }
  $errors = array();
  $errors['name'] = !empty($_COOKIE['name_error']);
  $errors['year'] = !empty($_COOKIE['year_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['sex'] = !empty($_COOKIE['sex_error']);
  $errors['limb'] = !empty($_COOKIE['limb_error']);
  $errors['bio'] = !empty($_COOKIE['bio_error']);
  $errors['checked'] = !empty($_COOKIE['checked_error']);
  $errors['form1'] = !empty($_COOKIE['form1_error']);
	
  if ($errors['name']) {
    setcookie('name_error', '', 100000);
    $messages[] = '<div class="error">Неправильная форма имени</div>';
  }
	if ($errors['year']) {
    setcookie('year_error', '', 100000);
    $messages[] = '<div class="error">Неправильная форма года</div>';
  }
	if ($errors['email']) {
    setcookie('email_error', '', 100000);
    $messages[] = '<div class="error">Неправильная форма email</div>';
  }
	if ($errors['sex']) {
    setcookie('sex_error', '', 100000);
    $messages[] = '<div class="error">Выберите пол</div>';
  }
	if ($errors['limb']) {
    setcookie('limb_error', '', 100000);
    $messages[] = '<div class="error">Выберите кол-во конечностей</div>';
  }
	if ($errors['bio']) {
    setcookie('bio_error', '', 100000);
    $messages[] = '<div class="error">Неправильная форма биографии</div>';
  }
	if ($errors['checked']) {
    setcookie('checked_error', '', 100000);
    $messages[] = '<div class="error">Примите согласие</div>';
  }
	if ($errors['form1']) {
    setcookie('form1_error', '', 100000);
    $messages[] = '<div class="error">Выберите суперсилу</div>';
  }
	
  $values = array();
  $values['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
  $values['year'] = empty($_COOKIE['year_value']) ? '' : $_COOKIE['year_value'];
  $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
  $values['sex'] = empty($_COOKIE['sex_value']) ? '' : $_COOKIE['sex_value'];
  $values['limb'] = empty($_COOKIE['limb_value']) ? '' : $_COOKIE['limb_value'];
  $values['bio'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];
  $values['checked'] = empty($_COOKIE['checked_value']) ? '' : $_COOKIE['checked_value'];
  $values['form1'] = empty($_COOKIE['form1_value']) ? '' : $_COOKIE['form1_value'];

  include('form.php');
}
else {
  $errors = FALSE;
  if (empty($_POST['name']) || !preg_match($reg,$_POST['name'])) {
    setcookie('name_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('name_value', $_POST['name'], time() + 30 * 24 * 60 * 60 * 12);
  }
	
if (empty($_POST['email']) || !preg_match($mailreg,$_POST['email'])) {
    setcookie('email_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60 * 12);
  }
if (empty($_POST['year']) || !is_numeric($_POST['year']) || !preg_match('/^\d+$/', $_POST['year'])) {
    setcookie('year_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('year_value', $_POST['year'], time() + 30 * 24 * 60 * 60 * 12);
  }
if (empty($_POST['bio']) || !preg_match($bioreg,$_POST['bio'])) {
    setcookie('bio_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('bio_value', $_POST['bio'], time() + 30 * 24 * 60 * 60 * 12);
  }
if (empty($_POST['sex'])) {
    setcookie('sex_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('sex_value', $_POST['sex'], time() + 30 * 24 * 60 * 60 * 12);
  }
if (empty($_POST['limb'])) {
    setcookie('limb_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('limb_value', $_POST['limb'], time() + 30 * 24 * 60 * 60 * 12);
  }
if (empty($_POST['checked'])) {
    setcookie('checked_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('checked_value', $_POST['checked'], time() + 30 * 24 * 60 * 60 * 12);
  }

if(empty($_POST['form1'])){
	setcookie('form1_error', '1', time() + 24 * 60 * 60);
	$errors = TRUE;
}
else {
    	setcookie('form1_value', $_POST['form1'], time() + 30 * 24 * 60 * 60 * 12);
 }

  if ($errors) {
    header('Location: index.php');
    exit();
  }

  $user = 'u52821';
  $pass = '8567731';
  $db = new PDO('mysql:host=localhost;dbname=u52821', $user, $pass,
  [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
  try {
	  $stmt = $db->prepare("INSERT INTO form SET name = ?,email= ?, year= ?, sex= ?, limb= ?, bio= ?,checked= ?");
	  $stmt->execute([$_POST['name'],$_POST['email'],$_POST['year'],$_POST['sex'],$_POST['limb'],$_POST['bio'],$_POST['checked']]);

	  $id = $db->lastInsertId();
	  $sppe= $db->prepare("INSERT INTO form1 SET power_id=:power, person_id=:person");
	  $sppe->bindParam(':person', $id);
	  foreach($_POST['form1']  as $ability){
		$sppe->bindParam(':power', $ability);
		if($sppe->execute()==false){
		  print_r($sppe->errorCode());
		  print_r($sppe->errorInfo());
		  exit();
		}
	  }
  }
  catch(PDOException $e){
    print('Error : ' . $e->getMessage());
    exit();
  }
  setcookie('save', '1');
  header('Location: ?save=1');
}
