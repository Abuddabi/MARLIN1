<?php 
  require_once("conf.php");
  unset($_SESSION['name']);
  //unset($_SESSION['admin']);
  unset($_SESSION['user_id']);
  unset($_SESSION['email']); 
  unset($_SESSION['ava']);
  unset($_SESSION['total_online']);
  session_destroy();
  setcookie('email', '', time() - 1);
  setcookie('pass', '', time() - 1);
  setcookie('last_visit', '', time() - 1);
  setcookie('check_online', '', time() - 1);
  header('location: /login.php');
?>