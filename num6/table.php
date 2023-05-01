<style>
  .error {
    border: 2px solid red;
  }
</style>
<body>
  <div class="table">
    <table>
      <tr>
        <th>Имя</th>
        <th>Почта</th>
        <th>Год</th>
        <th>Пол</th>
        <th>Кол-во конечностей</th>
        <th>Сверхсилы</th>
        <th>Био</th>
      </tr>
      <?php
      foreach($users as $user){
      ?>
            <tr>
              <td><?= $user['name']?></td>
              <td><?= $user['email']?></td>
              <td><?= $user['year']?></td>
              <td><?= $user['sex']?></td>
              <td><?= $user['limb']?></td>
              <td><?php 
                $user_pwrs=array(
                    "1"=>FALSE,
                    "2"=>FALSE,
                    "3"=>FALSE
                );
                foreach($pwrs as $pwr){
                    if($pwr['id']==$user['id']){
                        if($pwr['form1']=='Бессмертие'){
                            $user_pwrs['1']=TRUE;
                        }
                        if($pwr['form1']=='Телепортация'){
                            $user_pwrs['2']=TRUE;
                        }
                        if($pwr['form1']=='Телепатия'){
                            $user_pwrs['3']=TRUE;
                        }
                    }
                }
                if($user_pwrs['1']){echo 'Бессмертие<br>';}
                if($user_pwrs['2']){echo 'Телепортация<br>';}
                if($user_pwrs['3']){echo 'Телепатия<br>';}?>
              </td>
              <td><?= $user['bio']?></td>
              <td>
                <form method="get" action="index.php">
                  <input name=index_id value="<?= $user['id']?>" hidden>
                  <input type="submit" value=Edit>
                </form>
              </td>
            </tr>
      <?php
       }
      ?>
    </table>
    <?php
    printf('Кол-во пользователей с сверхспособностью "Бессмертие": %d <br>',$form1_count[0]);
    printf('Кол-во пользователей с сверхспособностью "Телепортация": %d <br>',$form1_count[1]);
    printf('Кол-во пользователей с сверхспособностью "Телепатия": %d <br>',$form1_count[2]);
    ?>
  </div>
</body>
