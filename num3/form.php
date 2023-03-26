<head>
  <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
  <div class="fr1">
  <form action="index.php" method="POST">
    <label> ФИО </label> <br><br>
    <input name="name" /> <br><br>
    <label> Почта </label> <br><br>
    <input name="email" type="email" /> <br><br>
    <label> Год рождения </label> <br><br>
    <select name="year">
      <option value="Выбрать">Выбрать</option>
    <?php
        for($i=1901;$i<=2901;$i++){
          printf("<option value=%d>%d год</option>",$i,$i);
        }
    ?>
    </select> <br><br>
    <label> Ваш пол </label> <br><br>
    <div>
      <input name="sex" type="radio" value="1" /> Мужчина
      <input name="sex" type="radio" value="2" /> Женщина
    </div>
    <label> Сколько у вас конечностей </label> <br><br>
    <div>
      <input name="limb" type="radio" value="1" /> 1 
      <input name="limb" type="radio" value="2" /> 2 
      <input name="limb" type="radio" value="3" /> 3 
      <input name="limb" type="radio" value="4" /> 4 
    </div>
    <label> Выберите суперспособности </label> <br><br>
    <select name="form1[]" size="3" multiple>
      <option value="1">Телпортация</option>
      <option value="2">Бессмертие</option>
      <option value="3">Телепатия</option>
    </select> <br><br>
    <label> Биография </label> <br><br>
    <textarea name="bio" rows="10" cols="15"></textarea> <br><br>
    <input name="checked" type="checkbox" value="on"> Вы согласны с пользовательским соглашением <br><br>
    <input type="submit" value="Отправить"/>
  </form>
  </div>
</body>
