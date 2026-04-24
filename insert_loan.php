<?php
include 'db.php';
session_start();

if($_SESSION['role'] != 'admin'){
    header("Location: login.php?type=admin");
    exit;
}

$name    = $_POST['full_name'];
$amount  = $_POST['amount'];
$tenure  = $_POST['tenure'];
$purpose = $_POST['purpose'];   

$rate = 12;

$r = $rate / (12 * 100);

if($r == 0){
    $emi = $amount / $tenure;
} else {
    $emi = ($amount * $r * pow(1+$r,$tenure)) / (pow(1+$r,$tenure)-1);
}

$due = date('Y-m-d', strtotime("+1 month"));

pg_query_params($conn,
"INSERT INTO loans (borrower_name, loan_amount, purpose, emi, status, due_date)
 VALUES ($1, $2, $3, $4, 'Active', $5)",
array($name, $amount, $purpose, $emi, $due)
);

header("Location: loans.php");
exit;
?>