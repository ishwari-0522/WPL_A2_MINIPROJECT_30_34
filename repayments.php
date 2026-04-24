<?php
include 'db.php';
session_start();

if(!isset($_SESSION['user']) || $_SESSION['role'] != 'admin'){
  header("Location: login.php?type=admin");
  exit;
}

/* FETCH ALL REPAYMENTS */
$result = pg_query($conn,"
SELECT repayments.*, loans.borrower_name 
FROM repayments
JOIN loans ON loans.id = repayments.loan_id
ORDER BY payment_date DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>All Repayments · LoanBridge</title>

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
    <a href="admin_dashboard.php">Home</a>
    <a href="analysis.php">Analysis</a>
  </nav>

  <div class="nav-label">Operations</div>
  <nav class="nav">
    <a href="loans.php">All loans</a>
    <a href="applications.php">Applications</a>
    <a class="is-active" href="repayments.php">Repayments</a>
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

<!-- TOPBAR -->
<div class="topbar">
  <div class="search">
    <input placeholder="Search repayments..."/>
  </div>
</div>

<!-- HEADER -->
<header class="page-head">
  <h1>ALL <em>REPAYMENTS.</em></h1>
</header>

<!-- TABLE -->
<section class="card">

<table class="t">
<thead>
<tr>
<th>Borrower</th>
<th>Amount</th>
<th>Date</th>
</tr>
</thead>

<tbody>

<?php while($row = pg_fetch_assoc($result)){ ?>
<tr>
<td><?php echo $row['borrower_name']; ?></td>
<td>₹<?php echo number_format(round($row['amount'])); ?></td>
<td><?php echo $row['payment_date']; ?></td>
</tr>
<?php } ?>

</tbody>
</table>

</section>

</main>

</div>

</body>
</html>