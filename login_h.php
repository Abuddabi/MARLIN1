<?php
  require_once("conf.php");
  $url = "/login.php";
  if($_POST['submit']=="press"){
    //Валидация
    if(empty(trim($_POST['email']))){
      $_SESSION['lg_fs1'] ="Ошибка. Введите e-mail";
      header("location: $url"); exit;
    }
    else $email=trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));

    if(empty(trim($_POST['password']))) {
      $_SESSION['lg_fs2'] ="Ошибка. Введите пароль";
      header("location: $url"); exit;
    }
    else $pass=trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));
    
    if($email && $pass){
      require_once("db2.php");
      $qr = "SELECT id, name, pass, ip, ava FROM users_marlin1 WHERE email = ?";
      $stmt = $pdo->prepare($qr);
      $stmt->execute([$email]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
      if($stmt->rowCount()>0){
        if(password_verify($pass, $user['pass'])){
          $_SESSION['user_id'] = $user['id'];
          $_SESSION['name']    = $user['name'];
          $_SESSION['email']   = $email;
          $_SESSION['ava']     = $user['ava'];
          //ОБНОВЛЯЕМ базу online
          $qr = "UPDATE online SET user_id = ? WHERE ip = ?";
          $stmt = $pdo->prepare($qr);
          $stmt->execute([$user['id'], $user['ip']]);
          
          //Галка Remember me
          if(isset($_POST['rmbr'])){
            setcookie('email', $email, time()+3600*24*7, '/');
            setcookie('pass', $user['pass'], time()+3600*24*7, '/');
          }
          else{
            setcookie('email', '', time()-1);
            setcookie('pass', '', time()-1);
          }
          header('location: /');
        }
        else{
          $_SESSION['lg_fs2'] ="Ошибка. Неверный пароль";
          header("location: $url"); exit;
        }
      }
      else{
        $_SESSION['lg_fs1'] = "Ошибка. Неверный e-mail";
        header("location: $url"); exit;
      }
    }
    else{
      $_SESSION['lg_fs1'] ="Ошибка. Заполните все поля";
      $_SESSION['lg_fs2'] ="Ошибка. Заполните все поля";
      header("location: $url"); exit;
    }
  }
?>