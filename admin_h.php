<?php 
  require_once("conf.php");
  if(isset($_POST['allow']) || isset($_POST['forbid']) || isset($_POST['delete'])){
    require_once("db2.php");
    if(!empty($_POST['allow'])) {
      $id = $_POST['allow'];
      $qr = "UPDATE comments SET status = '1' WHERE comments.id = ?";
      $stmt = $pdo->prepare($qr);
      $res = $stmt->execute([$id]);
      if($res){
        header("location: /admin.php"); exit;
      } 
      else echo "Ошибка базы данных";
    }
    elseif(!empty($_POST['forbid'])) {
      $id = $_POST['forbid'];
      $qr = "UPDATE comments SET status = '0' WHERE comments.id = ?";
      $stmt = $pdo->prepare($qr);
      $res = $stmt->execute([$id]);
      if($res){
        header("location: /admin.php"); exit;
      }
      else echo "Ошибка базы данных";
    }
    elseif(!empty($_POST['delete'])) {
      $id = $_POST['delete'];
      $qr = "DELETE FROM comments WHERE comments.id = ?";
      $stmt = $pdo->prepare($qr);
      $res = $stmt->execute([$id]);
      if($res){
        header("location: /admin.php"); exit;
      }
      else echo "Ошибка базы данных";
    }
  }
  else header("location: /admin.php");
  
?>