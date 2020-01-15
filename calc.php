<?php
  session_start();
?>
<html>
<head>
    <title>Калькулятор</title>
</head>
<body>
<form action="calc_h.php" method="post">
    <input type="text" name="x1">
    <select name="math">
        <option value="+">+</option>
        <option value="-">-</option>
        <option value="*">*</option>
        <option value="/">/</option>
    </select>
    <input type="text" name="x2">
    <input type="submit" value="Посчитать">
</form>
<?php 
  if(isset($_SESSION['error'])){
    echo $_SESSION['error']; 
    unset($_SESSION['error']);
  }
  if(isset($_SESSION['expr'])){
    echo $_SESSION['expr']; 
    unset($_SESSION['expr']);
  }
?>
</body>
</html>