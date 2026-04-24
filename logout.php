<?php
session_start();

session_unset();
session_destroy();

if(isset($_COOKIE['user'])){
    setcookie("user", "", time() - 3600, "/");
}

header("Location: index.php");
exit;
?>