<?php
include 'db.php';

$id = $_GET['id'];

pg_query($conn,"UPDATE applications SET status='Rejected' WHERE id=$id");

header("Location: applications.php");
?>