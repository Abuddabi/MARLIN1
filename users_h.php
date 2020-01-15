<?php
  //var_dump($_POST); echo "<br>";
  session_start(); 
  //var_dump($_SESSION);  echo "<br>"; 
  $url = "users.php";
  if(isset($_POST['unblock']) || isset($_POST['block']) || isset($_POST['delete'])){
    require_once("db2.php");
    if(!empty($_POST['unblock'])) {
      $id = $_POST['unblock'];
      $qr = "UPDATE users_marlin1 SET block = '0' WHERE users_marlin1.id = ?";
      $stmt = $pdo->prepare($qr);
      $res = $stmt->execute([$id]);
      if($res){
        unset($_SESSION['user'][$id]);
        header("location: $url"); exit;
      }
      else echo "Ошибка базы данных";
    }
    elseif(!empty($_POST['block'])) {
      $id = $_POST['block'];
      $qr = "UPDATE users_marlin1 SET block = '1' WHERE users_marlin1.id = ?";
      $stmt = $pdo->prepare($qr);
      $res = $stmt->execute([$id]);
      if($res){
        $_SESSION['user'][$id] = '0';
        header("location: $url"); exit;
      }
      else echo "Ошибка базы данных";
    }
   elseif(!empty($_POST['delete'])) {
      $id = $_POST['delete'];
      $qr = "DELETE FROM users_marlin1 WHERE users_marlin1.id = ?";
      $stmt = $pdo->prepare($qr);
      $res = $stmt->execute([$id]);
      if($res){
        header("location: $url"); exit;
      }
      else echo "Ошибка базы данных";
   }
   else{ 
      header("location: $url");
   }
  }
  else header("location: $url");
  
?>