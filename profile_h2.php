  <?php 
  session_start();
  $url = "/profile.php#pass";
  $current = trim($_POST['current']);
  $tmp_pass = trim($_POST['password']);
  $conf = trim($_POST['password_conf']);
  if(!empty($current) && !empty($tmp_pass) && !empty($conf) && $_POST['submit'] == "press"){
    if($tmp_pass !== $conf){
      $_SESSION['pass_fs2'] = "Ошибка. Значения не совпадают";
      $_SESSION['pass_fs3'] = "Ошибка. Значения не совпадают";
      header("location: $url"); exit;
    }
    elseif(strlen($tmp_pass)<5 || strlen($tmp_pass)>20){
      $_SESSION['pass_fs2'] = "Ошибка. Пароль от 5 до 20 символов";
      $_SESSION['pass_fs3'] = "Ошибка. Пароль от 5 до 20 символов";
      header("location: $url"); exit;
    }
    else{
      require_once("db2.php");
      $id = $_SESSION['user_id'];
      $qr = "SELECT pass FROM users_marlin1 WHERE id = ?";
      $stmt = $pdo->prepare($qr);
      $stmt->execute([$id]);
      $real_pass = $stmt->fetchColumn();
      $current = trim(filter_input(INPUT_POST, 'current', FILTER_SANITIZE_STRING));
      if(!password_verify($current, $real_pass)){
        $_SESSION['pass_fs1'] ="Ошибка. Неверный пароль";
        header("location: $url"); exit;
      }
      else{
        $new_pass = password_hash(trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING)), PASSWORD_DEFAULT);
        $qr = "UPDATE users_marlin1 SET pass = ? WHERE users_marlin1.id = ?";
        $stmt = $pdo->prepare($qr);
        $res = $stmt->execute([$new_pass, $id]);
        if($res){
          $_SESSION['update_pass'] = "ok";
          header("location: $url"); exit;
        }
        else{
          $_SESSION['pass_fs1'] ="Ошибка базы данных";
          header("location: $url"); exit;
        } 
      }
    }
  }
  else {
    $_SESSION['pass_fs1'] = "Ошибка. Заполните все поля";
    $_SESSION['pass_fs2'] = "Ошибка. Заполните все поля";
    $_SESSION['pass_fs3'] = "Ошибка. Заполните все поля";
    header("location: $url");
  }
?>