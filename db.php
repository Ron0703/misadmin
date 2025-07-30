<?php
$servername = "gateway01.us-west-2.prod.aws.tidbcloud.com";
$username = "2CmofanFHB8EpD6.root";
$password = "";
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die(json_encode(['error' => 'Connection failed']));
}
?>
