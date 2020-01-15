<?php
$host="";
$db_name="";
$db_user="";
$db_pass="";

try{
  $pdo = new PDO("mysql:host=$host; dbname=$db_name", $db_user, $db_pass);
} 
catch(PDOException $e){
  echo "Error: ".$e -> getMessage()."<br>";
  echo "On line: ".$e -> getLine();
}

?>