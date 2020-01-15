<?php
  session_start();
  $url = "/register.php";
  $tmp_name = trim($_POST['name']);
  $tmp_pass = trim($_POST['password']);
  if(!empty(trim($_POST['email'])) && $_POST['submit']=="press"){ //Если набран email и нажата кнопка
    if(!preg_match("/^[a-z0-9\.\-\_\!]+@[a-z_]+\.[a-z]{2,3}$/i", $_POST['email'])){
      $_SESSION['reg_fs1'] ="Ошибка. Запрещенные символы";
      header("location: $url"); exit;
    }
    else{
      $check_email = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));
      require_once("db2.php");
      //Проверка, есть ли такой email в БД
      $query = "SELECT email FROM users_marlin1 WHERE email = ?";
      $stmt = $pdo->prepare($query);
      $res = $stmt->execute([$check_email]);
      if($stmt->rowCount()>0){
        $_SESSION['reg_fs1'] ="Ошибка. Данный e-mail уже зарегистрирован";
        header("location: $url"); exit;
      }
      else $email = $check_email;
    }
    //Валидация
    if(empty($tmp_name)){
      $_SESSION['reg_fs2'] ="Ошибка. Введите имя";
      header("location: $url"); exit;
    }
    elseif(preg_match("/[\<|\>|\;|\$|\:|\#|\@|\%|\'|\"|\=|\+]/", $_POST['name'])){
      $_SESSION['reg_fs2'] ="Ошибка. Запрещенные символы";
      header("location: $url"); exit;
    }
    elseif(mb_strlen($tmp_name)>60){
      $_SESSION['reg_fs2'] ="Ошибка. Не более 60 символов";
      header("location: $url"); exit;
    }
    else $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));

    if(empty($tmp_pass) || empty(trim($_POST['password_conf']))){
      $_SESSION['reg_fs3'] ="Ошибка. Введите пароль";
      header("location: $url"); exit;
    }
    elseif(mb_strlen($tmp_pass)<5 || mb_strlen($tmp_pass)>20){
      $_SESSION['reg_fs3'] ="Ошибка. Пароль от 5 до 20 символов";
      header("location: $url"); exit;
    } 
    else $pass=password_hash(trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING)), PASSWORD_DEFAULT);

    if($_POST['password'] == $_POST['password_conf']) $same=1;
    else{
      $_SESSION['reg_fs3'] ="Ошибка. Пароли не совпадают";
      header("location: $url"); exit;
    }
    //Конец валидации

    if($name && $pass && $same){
      require_once("db2.php");
      $date_of_reg = date("d M.yг H:i:s");
      $ip = $_SERVER["REMOTE_ADDR"];
      //Отправляет данные в БД (users_marlin1)
      $qr = "INSERT INTO users_marlin1 (name, email, pass, date_of_reg, ip) VALUES (?,?,?,?,?)";
      $stmt = $pdo->prepare($qr);
      $res = $stmt->execute([$name,$email,$pass,$date_of_reg,$ip]);

      if(!$res){
        $_SESSION['reg_fs1'] ="Ошибка базы данных";
        unset($same);
        header("location: $url");
      }
      else{
        $_SESSION['reg_ok'] = "ok";
        unset($same);
        header("location: /login.php");
      }
    }
  }
?>