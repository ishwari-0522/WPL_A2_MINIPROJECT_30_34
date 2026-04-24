<?php
session_start();
include 'db.php';

$username = $_POST['username'];
$password = $_POST['password'];
$type = isset($_POST['type']) ? $_POST['type'] : 'client';

$res = pg_query_params($conn, "SELECT * FROM users WHERE username = $1", array($username));
$user = pg_fetch_assoc($res);

if ($user && password_verify_pg($password, $user['password'])) {

    $_SESSION['user'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    if(isset($_POST['remember'])){
        setcookie("user", $username, time()+86400*30, "/");
    }

    if ($user['role'] == 'admin') {
        header("Location: admin_dashboard.php");
        exit;
    } else {
        if ($type == 'apply') {
            header("Location: apply_loan.php");
        } else {
            header("Location: client_dashboard.php");
        }
        exit;
    }

} else {
    echo "Invalid login";
}

function password_verify_pg($password, $hash){
    global $conn;
    $res = pg_query_params($conn,
        "SELECT crypt($1, $2) = $2",
        array($password, $hash)
    );
    return pg_fetch_result($res, 0, 0) === 't';
}
?>