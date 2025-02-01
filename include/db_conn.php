<?php
$servername = "127.0.0.1:3306";
$username = "u268280788_mtfrb_lucban";
$password = "XubCfv#1";
$dbname = "u268280788_mtfrb_lucban";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully";
