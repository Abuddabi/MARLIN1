<?php
  // phpinfo(); exit;
  session_start();
  echo "<pre>";
  var_dump($_SESSION);
  var_dump($_COOKIE);
  var_dump($_SESSION['online_id']);

?>