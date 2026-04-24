<?php include 'db.php'; session_start(); ?>

<?php
if($_SESSION['role'] != 'admin'){
  header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>All Loans · LoanBridge</title>

<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css"/>
</head>

<body>
<div class="app">

<!-- SIDEBAR -->
<aside class="sidebar">
  <div class="brand-mini"><div class="logo">L</div><div class="name">LOAN<span>BRIDGE</span></div></div>

  <div class="nav-label">Overview</div>
  <nav class="nav">
    <a href="admin_dashboard.php">Home</a>
    <a href="analysis.php">Analysis</a>
  </nav>

  <div class="nav-label">Operations</div>
  <nav class="nav">
    <a class="is-active" href="loans.php">All loans</a>
    <a href="applications.php">Applications</a>
    <a href="client_repayment.php">Repayments</a>
    <a href="overdue.php">Overdue</a>
    <a href="add_loan.php">Add loan</a>
  </nav>

  <div class="nav-label">Account</div>
  <nav class="nav">
    <a href="logout.php">Log out</a>
  </nav>

  <div class="me">
    <div class="avatar amber">A</div>
    <div class="who"><?php echo $_SESSION['user']; ?><span class="role">Admin</span></div>
  </div>
</aside>

<!-- MAIN -->
<main class="main">

<div class="topbar">
  <div class="search"><input placeholder="Search by borrower, loan ID, city..."/></div>
</div>

<?php
$totalLoans = pg_fetch_result(pg_query($conn,"SELECT COUNT(*) FROM loans"),0,0);
$active = pg_fetch_result(pg_query($conn,"SELECT COUNT(*) FROM loans WHERE status='Active'"),0,0);
$overdue = pg_fetch_result(pg_query($conn,"SELECT COUNT(*) FROM loans WHERE due_date < CURRENT_DATE"),0,0);
$closed = pg_fetch_result(pg_query($conn,"SELECT COUNT(*) FROM loans WHERE status='Closed'"),0,0);
$totalAmount = pg_fetch_result(pg_query($conn,"SELECT COALESCE(SUM(loan_amount),0) FROM loans"),0,0);
?>

<header class="page-head">
  <h1>ALL <em>LOANS.</em></h1>
  <p class="sub"><?php echo "$totalLoans total · $active active · $overdue overdue · $closed closed"; ?></p>
</header>

<section class="kpis">
  <div class="kpi blue"><div class="k">₹<?php echo $totalAmount; ?></div><div class="l">Portfolio</div></div>
  <div class="kpi mint"><div class="k"><?php echo $active; ?></div><div class="l">Active</div></div>
  <div class="kpi rose"><div class="k"><?php echo $overdue; ?></div><div class="l">Overdue</div></div>
  <div class="kpi lilac"><div class="k"><?php echo $closed; ?></div><div class="l">Closed</div></div>
</section>

<section class="card">

<div class="table-wrap">
<table class="t">

<thead>
<tr>
<th>Loan ID</th>
<th>Principal</th>
<th>EMI</th>
<th>Status</th>
<th>Next due</th>
</tr>
</thead>

<tbody>

<?php
$res = pg_query($conn,"SELECT * FROM loans ORDER BY id DESC");

while($row = pg_fetch_assoc($res)){

$status = $row['status'];
$badge = "ok";

if($status == "Overdue") $badge = "bad";
if($status == "Pending") $badge = "info";
if($status == "Closed") $badge = "ghost";
?>

<tr>
<td class="mono">#LN-<?php echo $row['id']; ?></td>

<td class="num">₹<?php echo $row['loan_amount']; ?></td>

<td class="num">
<?php echo ($status=="Closed") ? "—" : "₹".$row['emi']; ?>
</td>

<td>
<span class="badge <?php echo $badge; ?>">
<?php echo $status; ?>
</span>
</td>

<td class="mono">
<?php echo ($status=="Closed") ? "—" : $row['due_date']; ?>
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