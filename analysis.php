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
<title>Analysis · LoanBridge</title>

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
    <a class="is-active" href="analysis.php">Analysis</a>
  </nav>

  <div class="nav-label">Operations</div>
  <nav class="nav">
    <a href="loans.php">All loans</a>
    <a href="applications.php">Applications</a>
    <a href="repayments.php">Repayments</a>
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
  <div class="search"><input placeholder="Search analytics..."/></div>
</div>

<?php
/* ===== CORRECT KPI LOGIC ===== */

// total disbursement
$totalDisbursed = pg_fetch_result(pg_query($conn,"
SELECT COALESCE(SUM(loan_amount),0) FROM loans
"),0,0);


// total collected
$totalCollected = pg_fetch_result(pg_query($conn,"
SELECT COALESCE(SUM(amount),0) FROM repayments
"),0,0);

// expected EMI (simple version: 1 EMI per loan)
$totalExpected = pg_fetch_result(pg_query($conn,"
SELECT COALESCE(SUM(emi),0) FROM loans WHERE status='Active'
"),0,0);

// efficiency
$efficiency = $totalExpected > 0 
  ? round(($totalCollected / $totalExpected) * 100, 1)
  : 0;

$totalInterest = pg_fetch_result(pg_query($conn,"
SELECT COALESCE(SUM(r.amount - l.loan_amount / 12),0)
FROM repayments r
JOIN loans l ON l.id = r.loan_id
"),0,0);

if($totalInterest < 0) $totalInterest = 0;

// total loans
$totalLoans = pg_fetch_result(pg_query($conn,"
SELECT COUNT(*) FROM loans
"),0,0);

// NPA (overdue loans amount)
$npa = pg_fetch_result(pg_query($conn,"
SELECT COALESCE(SUM(loan_amount),0) 
FROM loans 
WHERE due_date < CURRENT_DATE AND status!='Closed'
"),0,0);
?>

<header class="page-head">
  <h1>PORTFOLIO <em>ANALYSIS.</em></h1>
</header>

<!-- KPI -->
<section class="kpis">

<div class="kpi blue">
  <div class="k">₹<?php echo number_format($totalDisbursed); ?></div>
  <div class="l">Disbursements</div>
</div>

<div class="kpi mint">
  <div class="k">₹<?php echo number_format($totalInterest); ?></div>
  <div class="l">Interest income</div>
</div>

<div class="kpi lime">
  <div class="k"><?php echo $efficiency; ?>%</div>
  <div class="l">Collection efficiency</div>
</div>

<div class="kpi rose">
  <div class="k">₹<?php echo number_format($npa); ?></div>
  <div class="l">NPA</div>
</div>

</section>

<!-- BREAKDOWN -->
<section class="grid-2">

<div class="card">
  <h3>Portfolio breakdown</h3>

  <?php
  $avgLoan = $totalLoans ? round($totalDisbursed/$totalLoans) : 0;
  ?>

  <table class="t">
    <tr>
      <td>Avg. loan size</td>
      <td style="text-align:right;">₹<?php echo number_format($avgLoan); ?></td>
    </tr>
    <tr>
      <td>Loans count</td>
      <td style="text-align:right;"><?php echo $totalLoans; ?></td>
    </tr>
    <tr>
      <td>Efficiency</td>
      <td style="text-align:right;"><?php echo $efficiency; ?>%</td>
    </tr>
  </table>

</div>

<!-- LIVE ACTIVITY -->
<div class="card">
  <h3>Recent activity</h3>

<?php
$recent = pg_query($conn,"
SELECT * FROM loans ORDER BY id DESC LIMIT 5
");

while($r = pg_fetch_assoc($recent)){
?>
<div>
Loan — <?php echo $r['borrower_name']; ?> ₹<?php echo number_format($r['loan_amount']); ?>
</div>
<?php } ?>

</div>

</section>

</main>
</div>

</body>
</html>