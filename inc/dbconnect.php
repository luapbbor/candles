<?php 

// Connect to database
$servername = "localhost";
$db_username = "root";
$db_password = "root";

try {
  $db = new PDO("mysql:host=$servername;dbname=candlesdb",$db_username, $db_password);
  // set the PDO error mode to exception
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>
