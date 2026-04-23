<?php
include 'db.php';

$name=$_POST['name'];
$amount=$_POST['amount'];
$emi=$_POST['emi'];
$status=$_POST['status'];
$due=$_POST['due'];

pg_query($conn,"INSERT INTO loans (borrower_name,loan_amount,emi,status,due_date)
VALUES('$name',$amount,$emi,'$status','$due')");

header("Location: loans.php");
?>