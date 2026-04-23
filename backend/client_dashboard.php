<?php
session_start();
include 'header.php';
include 'navbar.php';

if ($_SESSION['role'] != 'client') header("Location: login.php");
?>

<h2>Client Dashboard</h2>

<a href="apply_loan.php">Apply Loan</a><br>
<a href="repayments.php">Repayments</a>

<?php include 'footer.php'; ?>