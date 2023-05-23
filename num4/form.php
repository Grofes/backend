<head>
  <link rel="stylesheet" href="style.css" type="text/css">
  <style>
    .error {
      margin: 0 auto 2px auto;
      width: 200px;
      border: 2px solid red;
    }
  </style>
</head>
<body>
<?php
if (!empty($messages)) {
  print('<div id="messages">');
  // Выводим все сообщения.
  foreach ($messages as $message) {
    print($message);
  }
  print('</div>');
}
?>
  <div class="fr1">
  <form action="index.php" method="POST">
    <label> ФИО </label> <br>
    <input name="name" <?php if ($errors['name']) {print 'class="error"';} ?> name_value="<?php print $values['name']; ?>" /> <br>
    <label> Почта </label> <br>
    <input name="email" type="email" <?php if ($errors['email']) {print 'class="error"';} ?>email_value="<?php print $values['email']; ?>" /> <br>
    <label>
      <?php
        printf('Год рождения:');
      ?>
      <br>
      <input name="year" placeholder="year" <?php if ($errors['year']) {print 'class="error"';} ?> year_value="<?php print $values['year']; ?>">
      </label>
    </select> <br>
    <label> Ваш пол </label> <br>
    <div <?php if ($errors['sex']) {print 'class="error"';} ?>sex_value="<?php print $value['sex']; ?>>
      <input name="sex" type="radio" value="1" /> Мужчина
      <input name="sex" type="radio" value="2" /> Женщина
    </div>
    <label> Сколько у вас конечностей </label> <br>
    <div <?php if ($errors['limb']) {print 'class="error"';} ?>limb_value="<?php print $values['limb']; ?>">
      <input name="limb" type="radio" value="1" /> 1 
      <input name="limb" type="radio" value="2" /> 2 
      <input name="limb" type="radio" value="3" /> 3 
      <input name="limb" type="radio" value="4" /> 4 
    </div>
    <label> Выберите суперспособности </label> <br>
    <select name="form1[]" size="3" multiple <?php if ($errors['form1']) {print 'class="error"';} ?>form1_value="<?php print $values['form1']; ?>">
      <option value="1">Телепортация</option>
      <option value="2">Бессмертие</option>
      <option value="3">Телепатия</option>
    </select> <br>
    <label> Краткая биография </label> <br>
    <textarea <?php if ($errors['bio']) {print 'class="error"';} ?> bio_value="<?php print $values['bio']; ?>" name="bio" rows="10" cols="15"></textarea> <br>
    <div  <?php if ($errors['checked']) {print 'class="error"';} ?> checked_value="<?php print $values['checked']; ?>">
    <input name="checked" type="checkbox"> Вы согласны с пользовательским соглашением <br>
    </div>
    <input type="submit" value="Отправить"/>
  </form>
  </div>
</body>
