<?php
session_start();

/* Destroy all session data */
session_unset();
session_destroy();

/* Optional: remove remember-me cookie */
if(isset($_COOKIE['user'])){
    setcookie("user", "", time() - 3600, "/");
}

/* Redirect to login */
header("Location: login.php?type=client");
exit;
?>