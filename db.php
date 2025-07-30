<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "inventorydb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die(json_encode(['error' => 'Connection failed']));
}
?>
