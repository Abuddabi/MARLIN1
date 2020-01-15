<?php
  require_once("conf.php");
  $url = "/";
  if($_POST['submit'] == "press"){
    if(empty(trim($_SESSION['user_id']))){
      $_SESSION['lg_fs1'] ="Ошибка. Вы не авторизованы";
      header('location: /login.php'); exit;
    }
    elseif(empty(trim($_POST['text-comm']))){
      $_SESSION['fsmsg2'] ="Ошибка. Введите сообщение";
      header("location: $url"); exit;
    }
    elseif(strlen(trim($_POST['text-comm']))>450){
      $_SESSION['fsmsg2'] ="Ошибка. Не более 450 символов";
      header("location: $url"); exit;
    }
    else{
      $date = date("d/m/Y");
      $comm = nl2br(trim(filter_input(INPUT_POST, 'text-comm', FILTER_SANITIZE_STRING)));
      $user_id = $_SESSION["user_id"];
      require_once("db2.php");
      //Отправляет данные в БД
      $query = "INSERT INTO comments (date, comm, user_id) VALUES (?,?,?)";
      $stmt = $pdo->prepare($query);
      $res = $stmt->execute([$date, $comm, $user_id]);
      if($res){
        $_SESSION['comm_sent'] = 'Ваш комментарий успешно добавлен';
        header("location: $url"); exit;
      }
      else{
        $_SESSION['fsmsg2'] ="Ошибка базы данных";
        header("location: $url"); exit;
      }
    }
  }
?>