<?php
include 'db.php';
session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php?type=admin");
    exit;
}

if(!isset($_GET['id'])){
    header("Location: applications.php");
    exit;
}

$id = $_GET['id'];

$res = pg_query_params($conn,
"SELECT * FROM applications WHERE id = $1",
array($id)
);

$app = pg_fetch_assoc($res);

if(!$app){
    echo "Application not found";
    exit;
}

$existingLoan = pg_fetch_result(pg_query_params($conn,
"SELECT COUNT(*) FROM loans WHERE application_id = $1",
array($id)
),0,0);

if($existingLoan > 0){
    header("Location: applications.php");
    exit;
}

if($app['status'] == 'Approved'){
    header("Location: applications.php");
    exit;
}

$amount = $app['amount'];
$rate = 7;
$tenure = 12;

$r = $rate/(12*100);

if($r == 0){
    $emi = $amount / $tenure;
} else {
    $emi = ($amount*$r*pow(1+$r,$tenure))/(pow(1+$r,$tenure)-1);
}

pg_query_params($conn,
"INSERT INTO loans (application_id, borrower_name, loan_amount, purpose, emi, status, due_date)
 VALUES ($1, $2, $3, $4, $5, 'Active', CURRENT_DATE + INTERVAL '30 days')",
array(
    $id,
    $app['applicant_name'],
    $amount,
    $app['purpose'],
    $emi
)
);

pg_query_params($conn,
"UPDATE applications SET status='Approved' WHERE id=$1",
array($id)
);

header("Location: applications.php");
exit;
?>