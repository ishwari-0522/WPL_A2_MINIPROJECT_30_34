<?php include 'db.php'; session_start(); ?>

<?php
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
  header("Location: login.php?type=admin");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>Admin Dashboard · LoanBridge</title>

<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css"/>
</head>

<body>
<div class="app">

<!-- SIDEBAR -->
<aside class="sidebar">
  <div class="brand-mini">
    <div class="logo">L</div>
    <div class="name">LOAN<span>BRIDGE</span></div>
  </div>

  <div class="nav-label">Overview</div>
  <nav class="nav">
    <a class="is-active" href="admin_dashboard.php">Home</a>
    <a href="analysis.php">Analysis</a>
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
    <div class="who">
      <?php echo $_SESSION['user']; ?>
      <span class="role">Admin</span>
    </div>
  </div>
</aside>

<!-- MAIN -->
<main class="main">

<div class="topbar">
  <div class="search">
    <input placeholder="Search borrowers..."/>
  </div>
</div>

<?php
$total = pg_fetch_result(pg_query($conn,"SELECT COALESCE(SUM(loan_amount),0) FROM loans"),0,0);
$active = pg_fetch_result(pg_query($conn,"SELECT COUNT(*) FROM loans WHERE status='Active'"),0,0);
$overdue = pg_fetch_result(pg_query($conn,"SELECT COUNT(*) FROM loans WHERE due_date<CURRENT_DATE"),0,0);
$closed = pg_fetch_result(pg_query($conn,"SELECT COUNT(*) FROM loans WHERE status='Closed'"),0,0);
?>

<header class="page-head">
  <h1>GOOD MORNING, <em><?php echo strtoupper($_SESSION['user']); ?></em></h1>
</header>

<section class="kpis">
  <div class="kpi blue">
    <div class="k">₹<?php echo $total; ?></div>
    <div class="l">Total portfolio</div>
  </div>

  <div class="kpi mint">
    <div class="k"><?php echo $active; ?></div>
    <div class="l">Active loans</div>
  </div>

  <div class="kpi rose">
    <div class="k"><?php echo $overdue; ?></div>
    <div class="l">Overdue</div>
  </div>

  <div class="kpi lilac">
    <div class="k"><?php echo $closed; ?></div>
    <div class="l">Closed</div>
  </div>
</section>

<section class="grid-2">

<!-- RECENT APPLICATIONS -->
<div class="card">
  <div class="card-head">
    <h3>Recent applications</h3>
  </div>

  <table class="t">
    <thead>
      <tr>
        <th>Applicant</th>
        <th>Amount</th>
        <th>Purpose</th>
        <th>Status</th>
        <th></th>
      </tr>
    </thead>

    <tbody>

<?php
$res = pg_query($conn,"SELECT * FROM applications ORDER BY id DESC LIMIT 5");

while($row = pg_fetch_assoc($res)){
$status = trim(strtolower($row['status']));
?>
<tr>

<td><?php echo $row['applicant_name']; ?></td>

<td>₹<?php echo number_format($row['amount'],2); ?></td>

<td><?php echo $row['purpose']; ?></td>

<td>
<span class="badge 
<?php 
echo ($status=='approved')?'ok':(($status=='rejected')?'bad':'info');
?>">
<?php echo ucfirst($status); ?>
</span>
</td>

<td>

<?php if($status == 'pending'){ ?>

<a class="btn btn-primary btn-sm"
   href="approve_application.php?id=<?php echo $row['id']; ?>">
Approve
</a>

<?php } else { ?>

<span style="color:#6b7280; font-size:12px;">—</span>

<?php } ?>

</td>

</tr>
<?php } ?>

    </tbody>
  </table>
</div>

<!-- LIVE ACTIVITY -->
<div class="card">
  <h3>Live activity</h3>

<?php
$recent = pg_query($conn,"SELECT * FROM loans ORDER BY id DESC LIMIT 3");

while($r = pg_fetch_assoc($recent)){
?>
<div class="activity-item">
  <span class="activity-text">
    Loan created
  </span>

  <span class="activity-sep">•</span>

  <span class="activity-user">
    <?php echo $r['borrower_name']; ?>
  </span>

  <span class="activity-amount">
    ₹<?php echo number_format($r['loan_amount'],2); ?>
  </span>
</div>
<?php } ?>

</div>

</section>

</main>
</div>

</body>
</html>