<?php
header("Content-Type: text/html; charset=utf-8");
include_once "db_conn.php";

$username = $_POST['username'];
$password = $_POST['password'];
$display_name = $_POST['display_name'];
$password_check = $_POST['password_check'];

$query = "insert into user values(?,?,?,?,?)";
$stmt = $db->prepare($query);
$stmt->execute(array(null,$username,$display_name,$password,'u'));
header("Location: login.php");
?>
