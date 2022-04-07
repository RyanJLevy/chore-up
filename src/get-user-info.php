<?php 
session_start();
require "./config/config.php";

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_errno) {
    echo $mysqli->error;
    exit();
}

$sql = "SELECT * FROM users WHERE username = '" . $_SESSION['username'] . "';";
$executed = $mysqli->query($sql);
if (!$executed) {
    echo $mysqli->error;
    exit();
}

$mysqli->close();

echo json_encode($executed->fetch_assoc());


?>