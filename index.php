<?php include 'db.php'; 
session_start();

if(isset($_SESSION['role'])){
    if($_SESSION['role'] == 'admin'){
        header("Location: admin_dashboard.php");
        exit;
    } else {
        header("Location: client_dashboard.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>LoanBridge — Microfinance Management Network</title>

<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css"/>

<style>
</style>
</head>

<body>
<div class="shell-center">

<header class="brandbar">
  <a href="index.php" class="brand"><span class="dot"></span> LOANBRIDGE</a>
  <nav class="topnav">
    <a class="is-active" href="#">HOME</a>
    <a href="login.php?type=admin">ALL LOANS</a>
    <a href="login.php?type=admin">APPLICATIONS</a>
    <a href="login.php?type=admin">REPAYMENTS</a>
    <a href="login.php?type=admin">OVERDUE</a>
    <a href="login.php?type=admin">ANALYSIS</a>
  </nav>
</header>

<section class="hero">
  <span class="eyebrow">Active Microfinance Management Network</span>
  <h1>Loan<em>Bridge</em></h1>
  <p>A unified platform connecting borrowers with microfinance institutions.</p>
</section>

<section class="portal-section">
  <div class="portal-grid">

    <div class="portal-card">
  
  <div class="card-content">
    <h3>CLIENT PORTAL</h3>
    <p>Apply for loans and manage repayments.</p>
  </div>

<a href="login.php?type=client" class="btn btn-primary">
  APPLY FOR LOAN
</a>
</div>

    <div class="portal-card">
      <h3>LOAN MANAGER</h3>
      <p>Review applications and manage loans.</p>
      <a href="login.php?type=admin" class="btn btn-primary">GET STARTED</a>
    </div>

    <div class="portal-card">
      <h3>ADMIN PORTAL</h3>
      <p>Oversee operations and analytics.</p>
      <a href="login.php?type=admin" class="btn btn-primary">VIEW ANALYTICS</a>
    </div>

  </div>
</section>

<!-- STATS -->
<section class="stats-bar">

<?php
$totalLoans = pg_fetch_result(pg_query($conn,"SELECT COUNT(*) FROM loans"),0,0);
$totalAmount = pg_fetch_result(pg_query($conn,"SELECT COALESCE(SUM(loan_amount),0) FROM loans"),0,0);
$overdue = pg_fetch_result(pg_query($conn,"SELECT COUNT(*) FROM loans WHERE due_date < CURRENT_DATE"),0,0);
$repayments = pg_fetch_result(pg_query($conn,"SELECT COUNT(*) FROM repayments"),0,0);

$recovery = $totalLoans ? round(($repayments/$totalLoans)*100,1) : 0;
?>

  <div class="stat">
    <h2><?php echo $totalLoans; ?></h2>
    <p>ACTIVE LOANS</p>
  </div>

  <div class="stat highlight">
    <h2>₹<?php echo $totalAmount; ?></h2>
    <p>PORTFOLIO VALUE</p>
  </div>

  <div class="stat">
    <h2><?php echo $recovery; ?>%</h2>
    <p>RECOVERY RATE</p>
  </div>

  <div class="stat danger">
    <h2><?php echo $overdue; ?></h2>
    <p>OVERDUE TODAY</p>
  </div>

</section>

</div>
</body>
</html>