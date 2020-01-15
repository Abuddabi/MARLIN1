<?php
require_once("db2.php");
//Если не авторизован, но есть куки - авторизация автоматом
if (!isset($_SESSION['name']) && !empty($_COOKIE['email']) && !empty($_COOKIE['pass'])) {
  $email = $_COOKIE['email'];
  $pass = $_COOKIE['pass'];
  $qr = "SELECT id, name, email, ava FROM users_marlin1 WHERE email = ?";
  $stmt = $pdo->prepare($qr);
  $stmt->execute([$email]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  //Данные юзера из БД попадают в сессию
  if ($user) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['ava'] = $user['ava'];
    //header("location: $_SERVER['PHP_SELF']");
  } else {
    $_SESSION['auth_err'] = "err";
    header("/login.php");
  }
}

//Счетчик онлайна
$online_time = 60*5; //Контрольное время
$cook_lifetime = time()+$online_time; //Время жизни cookies
//УЧЕТ ОНЛАЙНА
if(!isset($_COOKIE['last_visit'])){
  $timestamp = time();
  $datetime = date("d M.yг H:i:s");
  $visitor_ip = $_SERVER['REMOTE_ADDR'];
  //ЕСЛИ ГОСТЬ
  if(!isset($_SESSION['user_id']) && !isset($_COOKIE['email']) && !isset($_COOKIE['pass'])){
    $qr = "SELECT id FROM online WHERE ip = ?";
    $stmt = $pdo->prepare($qr);
    $stmt->execute([$visitor_ip]);
    // $res = $stmt->fetchColumn();
    if($stmt->rowCount() < 1 ){
      //Новый гость - создаем новую запись в таблице online
      $qr = "INSERT INTO online (ip, last_visit, time, status) VALUES (?, ?, ?, 1)";
      $stmt = $pdo->prepare($qr);
      $stmt->execute([$visitor_ip, $timestamp, $datetime]);
      setcookie('last_visit', $datetime, $cook_lifetime, '/');
    }
    else {
      //Старый гость - обновляем
      $qr = "UPDATE online SET last_visit = ?, time = ?, status = 1, user_id = 0 WHERE ip = ?";
      $stmt = $pdo->prepare($qr);
      $stmt->execute([$timestamp, $datetime, $visitor_ip]);
      setcookie('last_visit', $datetime, $cook_lifetime, '/');
    }
  }
  //ЕСЛИ ЗАЛОГИНЕН
  else{
    $qr = "UPDATE online SET last_visit = ?, time = ?, user_id = ?, status = 1 WHERE ip = ?";
    $stmt = $pdo->prepare($qr);
    $stmt->execute([$timestamp, $datetime, $_SESSION['user_id'], $visitor_ip]);
    setcookie('last_visit', $datetime, $cook_lifetime, '/');
  }
}
//ВЫВОД НА ЭКРАН
if(!isset($_COOKIE['check_online']) || !isset($_SESSION['total_online'])){
// if(true){
  $minimum = time() - $online_time; //точка отсчета online/offline

  //Все кто более $minimum отсутствует - offline
  $qr = "UPDATE online SET status = 0 WHERE status = 1 AND last_visit < ?";
  $stmt = $pdo->prepare($qr);
  $stmt->execute([$minimum]);

  //Узнаем сколько посетителей онлайн за последние $online_time минут/часов/секунд
  $qr = "SELECT id, user_id FROM online WHERE last_visit > ?"; // AND user_id > 0
  $stmt = $pdo->prepare($qr);
  $stmt->execute([$minimum]);
  // $total_online = $stmt->fetchAll(PDO::FETCH_ASSOC);
  if(isset($_SESSION['user_id']) && $_SESSION['user_id']=='1') $_SESSION['online_id'] = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
  $_SESSION['total_online'] = $stmt->rowCount();
  setcookie('check_online', ($online_time/60).' минут', $cook_lifetime, '/'); // $datetime
}
?>