<?php
header("Content-Type: text/html; charset=utf-8");
include_once "db_conn.php";

$username = $_POST['username'];
$password = $_POST['password'];
$display_name = $_POST['display_name'];
$password_check = $_POST['password_check'];

$query = "insert into user values(?,?,?,?,?)";
$stmt = $db->prepare($query);
if (empty($username) || empty($password) || empty($display_name) || empty($password_check)) {
    $message = "Variable 'username' is empty.";
    echo "<html><script>alert('警告：有空格沒填東西'); location.href = 'register.php';</script></html>";;
}elseif ($password!=$password_check) {
    $message = "Password is not the same.";
    echo "<html><script>alert('警告：密碼不一樣'); location.href = 'register.php';</script></html>";;

}else{
    $stmt->execute(array(null,$username,$display_name,$password,'u'));
    header("Location: login.php");
}

//header("Location: login.php");
?>
