<?php
session_start();
include 'header.php';
include 'navbar.php';

if ($_SESSION['role'] != 'admin') header("Location: login.php");
?>

<h2>Admin Dashboard</h2>

<a href="loans.php">Manage Loans</a><br>
<a href="applications.php">Applications</a><br>
<a href="analysis.php">Analysis</a>

<?php include 'footer.php'; ?>