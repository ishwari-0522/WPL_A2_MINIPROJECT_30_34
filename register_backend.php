<?php
include 'db.php';

$username = $_POST['username'];
$password = $_POST['password'];


$res = pg_query_params($conn,
"INSERT INTO users (username, password, role)
VALUES ($1, crypt($2, gen_salt('bf')), 'client')",
array($username, $password)
);

header("Location: login.php?type=client");
exit;
?>