<?php
  session_start();
  if(!empty($_POST['x1']) && !empty($_POST['math']) && !empty($_POST['x2'])){
    if(is_numeric($_POST['x1']) && is_numeric($_POST['x2'])){
      $x1 = $_POST['x1'];
      $x2 = $_POST['x2'];
      switch($_POST['math']){
        case '+':
          $res = $x1 + $x2;
          break;
        case '-':
          $res = $x1 - $x2;
          break;
        case '*':
          $res = $x1 * $x2;
          break;
        case '/':
          $res = $x1 / $x2;
          break;
      }
      $_SESSION['expr'] = $x1 . ' ' . $_POST['math'] . ' ' . $x2 . ' = '.$res;
      header('location:/calc.php');
    }
    else {
      $_SESSION['error'] = "Введите числа";
      header('location:/calc.php');
    }
  }
  else {
    $_SESSION['error'] = "Заполните все поля";
    header('location:/calc.php');
  }
?>