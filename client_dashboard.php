<?php include 'db.php'; session_start(); ?>

<?php
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'client'){
  header("Location: login.php?type=client");
  exit;
}

$user = $_SESSION['user'];

$loans = pg_query($conn,"
SELECT * FROM loans 
WHERE borrower_name='$user'
ORDER BY id DESC
");

$totalPrincipal = pg_fetch_result(pg_query($conn,"
SELECT COALESCE(SUM(loan_amount),0) 
FROM loans 
WHERE borrower_name='$user' AND status!='Closed'
"),0,0);

$totalRepaid = pg_fetch_result(pg_query($conn,"
SELECT COALESCE(SUM(amount),0) 
FROM repayments 
JOIN loans ON loans.id = repayments.loan_id 
WHERE loans.borrower_name='$user'
"),0,0);

$nextLoan = pg_fetch_assoc(pg_query($conn,"
SELECT * FROM loans 
WHERE borrower_name='$user' AND status='Active'
ORDER BY id DESC LIMIT 1
"));

$nextEMI = $nextLoan ? $nextLoan['emi'] : 0;
$nextDate = $nextLoan ? $nextLoan['due_date'] : "-";

$loanCount = pg_fetch_result(pg_query($conn,"
SELECT COUNT(DISTINCT id) 
FROM loans 
WHERE borrower_name='$user' AND status='Active'
"),0,0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>My Dashboard · LoanBridge</title>

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
    <a class="is-active" href="client_dashboard.php">Home</a>
    <a href="apply_loan.php">Apply for loan</a>
    <a href="my_loans.php">My loans</a>
    <a href="client_repayment.php">Repayments</a>
    <a href="logout.php">Log out</a>
  </nav>

  <div class="me">
    <div class="avatar lilac">U</div>
    <div class="who">
      <?php echo $user; ?>
      <span class="role">Borrower</span>
    </div>
  </div>
</aside>

<main class="main">

<header class="page-head">
  <h1>HELLO, <em><?php echo strtoupper($user); ?></em></h1>
  <p class="sub">
    Next EMI ₹<?php echo number_format($nextEMI,2); ?> 
    due on <?php echo $nextDate; ?>
  </p>
</header>

<section class="kpis">

<div class="kpi blue">
  <div class="k">₹<?php echo number_format($totalPrincipal,2); ?></div>
  <div class="l">Active principal</div>
</div>

<div class="kpi mint">
  <div class="k">₹<?php echo number_format($totalRepaid,2); ?></div>
  <div class="l">Repaid</div>
</div>

<div class="kpi peach">
  <div class="k">₹<?php echo number_format($nextEMI,2); ?></div>
  <div class="l">Next EMI</div>
</div>

<div class="kpi lime">
  <div class="k"><?php echo $loanCount; ?></div>
  <div class="l">Active loans</div>
</div>

</section>

<!-- UPDATED TABLE -->
<section class="card">

<div class="card-head">
  <h3>Recent Transactions</h3>
</div>

<div class="table-wrap">

<table class="t">

<thead>
<tr>
<th>Loan ID</th>
<th>Principal</th>
<th>EMI</th>
<th>Status</th>
<th>Next Due</th>
</tr>
</thead>

<tbody>

<?php while($row = pg_fetch_assoc($loans)){ ?>

<tr>

<td>#LN-<?php echo $row['id']; ?></td>

<td>₹<?php echo number_format($row['loan_amount'],2); ?></td>

<td>
<?php echo ($row['status']=="Closed") 
  ? "—" 
  : "₹".number_format($row['emi'],2); ?>
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

<td>
<?php echo ($row['status']=="Closed") 
  ? "—" 
  : $row['due_date']; ?>
</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</section>

</main>
</div>

</body>
</html>