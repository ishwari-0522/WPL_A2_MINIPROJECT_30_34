<?php include 'db.php'; session_start(); ?>

<?php
if($_SESSION['role'] != 'client'){
  header("Location: login.php");
}

$user = $_SESSION['user'];

$res = pg_query($conn,"SELECT * FROM loans WHERE borrower_name='$user'");

$totalLoans = pg_fetch_result(pg_query($conn,"SELECT COUNT(*) FROM loans WHERE borrower_name='$user'"),0,0);

$activeLoans = pg_fetch_result(pg_query($conn,"SELECT COUNT(*) FROM loans WHERE borrower_name='$user' AND status='Active'"),0,0);

$outstanding = pg_fetch_result(pg_query($conn,"SELECT COALESCE(SUM(loan_amount),0) FROM loans WHERE borrower_name='$user' AND status!='Closed'"),0,0);

$totalEMI = pg_fetch_result(pg_query($conn,"SELECT COALESCE(SUM(emi),0) FROM loans WHERE borrower_name='$user' AND status='Active'"),0,0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>My Loans · LoanBridge</title>

<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css"/>
</head>

<body>
<div class="app">

<aside class="sidebar">
  <div class="brand-mini">
    <div class="logo">L</div>
    <div class="name">LOAN<span>BRIDGE</span></div>
  </div>

  <nav class="nav">
    <a href="client_dashboard.php">Home</a>
    <a href="apply_loan.php">Apply for loan</a>
    <a class="is-active" href="my_loans.php">My loans</a>
    <a href="client_repayment.php">Repayments</a>
    <a href="logout.php">Log out</a>
  </nav>

  <div class="me">
    <div class="avatar lilac">U</div>
    <div class="who"><?php echo $user; ?><span class="role">Borrower</span></div>
  </div>
</aside>

<main class="main">

<header class="page-head">
  <h1>MY <em>LOANS.</em></h1>
</header>

<section class="kpis">
  <div class="kpi blue">
    <div class="k"><?php echo $totalLoans; ?></div>
    <div class="l">Total loans</div>
  </div>

  <div class="kpi mint">
    <div class="k">₹<?php echo $outstanding; ?></div>
    <div class="l">Outstanding</div>
  </div>

  <div class="kpi peach">
    <div class="k">₹<?php echo $totalEMI; ?></div>
    <div class="l">EMI / month</div>
  </div>

  <div class="kpi lime">
    <div class="k"><?php echo $activeLoans; ?></div>
    <div class="l">Active loans</div>
  </div>
</section>

<section class="card">

<table class="t">
<thead>
<tr>
<th>Loan</th>
<th>Principal</th>
<th>EMI</th>
<th>Next due</th>
<th>Status</th>
</tr>
</thead>

<tbody>

<?php while($row = pg_fetch_assoc($res)){ ?>

<tr>

<td>#LN-<?php echo $row['id']; ?></td>

<td class="num">₹<?php echo $row['loan_amount']; ?></td>

<td class="num">
<?php echo ($row['status']=="Closed") ? "—" : "₹".$row['emi']; ?>
</td>

<td>
<?php echo ($row['status']=="Closed") ? "—" : $row['due_date']; ?>
</td>

<td>
<span class="badge 
<?php 
echo ($row['status']=="Active")?"ok":
(($row['status']=="Overdue")?"bad":
(($row['status']=="Closed")?"ghost":"info"));
?>">
<?php echo $row['status']; ?>
</span>
</td>

</tr>

<?php } ?>

</tbody>
</table>

</section>

</main>
</div>

</body>
</html>