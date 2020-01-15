<?php
  session_start();
  //var_dump($_FILES["image"]["tmp_name"]); exit;
  $url = "/profile.php";
  // var_dump($_FILES); exit;
  $tmp_name   = trim($_POST["name"]);
  $tmp_email  = trim($_POST["email"]);
  if(($tmp_name !== $_SESSION["name"] || $tmp_email !== $_SESSION["email"] || !empty($_FILES["image"]["name"])) && $_POST["submit"]=="press"){
    //Валидация
    //Имя
    if (!empty($tmp_name) && $tmp_name !== $_SESSION["name"]) {
      if (preg_match("/[\<|\>|\;|\$|\:|\#|\@|\%|\'|\"|\=|\+]/", $tmp_name)){
        $_SESSION["prof_fs1"] ="Ошибка. Запрещенные символы";
        header("location: $url"); exit;
      }
      elseif(strlen($tmp_name)>60){
        $_SESSION["prof_fs1"] ="Не более 60 символов";
        header("location: $url"); exit;
      }
      else $new_name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
    }
    //E-mail
    if(!empty($tmp_email) && $tmp_email !== $_SESSION["email"]){
      if(!preg_match("/^[a-z0-9\.\-\_\!]+@[a-z_]+\.[a-z]{2,3}$/i", $tmp_email)){
        $_SESSION["prof_fs2"] ="Ошибка. Запрещенные символы";
        header("location: $url"); exit;
      }
      else{
        $check_email = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));
        require_once("db2.php");
        //Проверка, есть ли такой email в БД
        $qr = "SELECT email FROM users_marlin1 WHERE email = ?";
        $stmt = $pdo->prepare($qr);
        $stmt->execute([$check_email]);
        if($stmt->rowCount() > 0){
          $_SESSION["prof_fs2"] ="Ошибка. Данный e-mail уже зарегистрирован";
          header("location: $url"); exit;
        }
        else $new_email = $check_email;
      }
    }

    // ******** КАРТИНКА ********* //
    if(!empty($_FILES["image"]["name"])){
      if($_FILES["image"]["size"]>2097152){
        $_SESSION["prof_fs3"] ="Ошибка. Не более 2 МБ";
        header("location: $url"); exit;
      }
      else{
        if($_FILES["image"]["type"] == "image/jpeg") $jpg = ".jpg";
        elseif($_FILES["image"]["type"] == "image/png") $png = ".png";
        if($jpg || $png){
          if($jpg) $ext = $jpg;
          elseif($png) $ext = $png;
          // var_dump($ext); exit;
          unset($jpg);
          unset($png);
          if(!empty($_SESSION["ava"])) {
            // $filemtime = filemtime($_SESSION["ava"]);
            //$tmp_ava = $_SESSION["ava"]."?".$filemtime;
            $tmp_ava = $_SESSION["ava"];
          }
          else $tmp_ava = "img/".uniqid()."$ext";
          // var_dump($tmp_ava); exit;
          $res = move_uploaded_file($_FILES["image"]["tmp_name"], $tmp_ava);
          if($res)$new_ava = $tmp_ava;
          else {
            $_SESSION["prof_fs3"] ="Ошибка при загрузке файла";
            header("location: $url"); exit;
          }
        }
        else{
          $_SESSION["prof_fs3"] ="Ошибка. Допустимые форматы JPG и PNG";
          header("location: $url"); exit;
        }
      }
    }
    //Конец валидации

    //Отправка в БД
    $id = $_SESSION["user_id"];
    require_once("db2.php");
    if($new_name && $new_email && $new_ava){
      $qr = "UPDATE users_marlin1 SET name = ?, email = ?, ava = ? WHERE users_marlin1.id = ?";
      $stmt = $pdo->prepare($qr);
      $res = $stmt->execute([$new_name,$new_email,$new_ava,$id]);
      if($res){
        $_SESSION["name"]   = $new_name;
        $_SESSION["email"]  = $new_email;
        $_SESSION["ava"]    = $new_ava;
        $_SESSION["update"] = "ok";
        header("location: $url"); exit;
      }
    }
    elseif($new_name || $new_email || $new_ava){
      if($new_name){
        $qr = "UPDATE users_marlin1 SET name = ? WHERE users_marlin1.id = ?";
        $stmt = $pdo->prepare($qr);
        $res = $stmt->execute([$new_name,$id]);
        if($res){
          $_SESSION["name"]   = $new_name;
          $_SESSION["update"] = "ok";
        }
      }
      if($new_email){
        $qr = "UPDATE users_marlin1 SET email = ? WHERE users_marlin1.id = ?";
        $stmt = $pdo->prepare($qr);
        $res = $stmt->execute([$new_email,$id]);
        if($res){
          $_SESSION["email"]  = $new_email;
          $_SESSION["update"] = "ok";
        }
      }
      if($new_ava){
        $qr = "UPDATE users_marlin1 SET ava = ? WHERE users_marlin1.id = ?";
        $stmt = $pdo->prepare($qr);
        $res = $stmt->execute([$new_ava,$id]);
        if($res){
          $_SESSION["ava"]    = $new_ava;
          $_SESSION["update"] = "ok";
        }
        
      }
      header("location: $url"); exit;
    }
  }
  else header("location: $url");
?>