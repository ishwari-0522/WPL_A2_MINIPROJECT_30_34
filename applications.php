<?php include 'db.php'; session_start(); ?>

<?php
/* ===== SESSION CHECK ===== */
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
<title>Applications · LoanBridge</title>

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
    <a class="is-active" href="applications.php">Applications</a>
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
    <input placeholder="Search applications..."/>
  </div>
</div>

<?php
$pending = pg_fetch_result(pg_query($conn,"SELECT COUNT(*) FROM applications WHERE TRIM(LOWER(status))='pending'"),0,0);
$approved = pg_fetch_result(pg_query($conn,"SELECT COUNT(*) FROM applications WHERE TRIM(LOWER(status))='approved'"),0,0);
$rejected = pg_fetch_result(pg_query($conn,"SELECT COUNT(*) FROM applications WHERE TRIM(LOWER(status))='rejected'"),0,0);
$pipeline = pg_fetch_result(pg_query($conn,"SELECT COALESCE(SUM(amount),0) FROM applications"),0,0);
?>

<header class="page-head">
  <h1>LOAN <em>APPLICATIONS.</em></h1>
</header>

<section class="kpis">
  <div class="kpi blue">
    <div class="k"><?php echo $pending; ?></div>
    <div class="l">Pending</div>
  </div>

  <div class="kpi mint">
    <div class="k"><?php echo $approved; ?></div>
    <div class="l">Approved</div>
  </div>

  <div class="kpi rose">
    <div class="k"><?php echo $rejected; ?></div>
    <div class="l">Rejected</div>
  </div>

  <div class="kpi lime">
    <div class="k">₹<?php echo number_format($pipeline,2); ?></div>
    <div class="l">Pipeline</div>
  </div>
</section>

<section class="card">
  <div class="card-head">
    <h3>Applications</h3>
  </div>

  <div class="table-wrap">
    <table class="t">
      <thead>
        <tr>
          <th>ID</th>
          <th>Amount</th>
          <th>Purpose</th>
          <th>Status</th>
          <th></th>
        </tr>
      </thead>

      <tbody>

<?php
$res = pg_query($conn,"SELECT * FROM applications ORDER BY id DESC");

while($row = pg_fetch_assoc($res)){
$status = trim(strtolower($row['status']));
?>
<tr>

<td><?php echo $row['id']; ?></td>

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

<a class="btn btn-primary btn-sm btn-pill"
   href="approve_application.php?id=<?php echo $row['id']; ?>"
   onclick="this.style.pointerEvents='none'; this.innerText='Processing...';">
Approve
</a>

<a class="btn btn-ghost btn-sm btn-pill"
   href="reject_application.php?id=<?php echo $row['id']; ?>">
Reject
</a>

<?php } ?>

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