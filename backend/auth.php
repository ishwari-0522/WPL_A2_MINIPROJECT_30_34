<?php
session_start();
include 'db.php';

$username = $_POST['username'];
$password = $_POST['password'];
$type = $_POST['type'];

$res = pg_query($conn, "SELECT * FROM users WHERE username='$username'");
$user = pg_fetch_assoc($res);

if ($user && pg_fetch_result(pg_query($conn,
"SELECT crypt('$password', '{$user['password']}') = '{$user['password']}'"),0,0)) {

$_SESSION['user'] = $username;
$_SESSION['role'] = $user['role'];

if ($user['role'] == 'admin') {
header("Location: admin_dashboard.php");
} else {
if ($type == 'apply') header("Location: apply_loan.php");
else header("Location: client_dashboard.php");
}

} else {
echo "Invalid login";
}
?>