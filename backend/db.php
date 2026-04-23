<?php

$host = "127.0.0.1";
$port = "5434";   
$dbname = "LOANBRIDGE";
$user = "postgres";
$password = "posgres123";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}
?>