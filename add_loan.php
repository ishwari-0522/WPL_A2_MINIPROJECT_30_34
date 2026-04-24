<?php include 'db.php'; session_start(); ?>

<?php
if($_SESSION['role'] != 'admin'){
  header("Location: login.php?type=admin");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>Add Loan · LoanBridge</title>

<link rel="stylesheet" href="css/style.css"/>
</head>

<body>
<div class="app">

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
    <a href="repayments.php">Repayments</a>
    <a href="overdue.php">Overdue</a>
    <a class="is-active" href="add_loan.php">Add loan</a>
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

<main class="main">

<header class="page-head">
  <h1>ADD A <em>NEW LOAN.</em></h1>
</header>

<section class="card">

<form action="insert_loan.php" method="post">

<div class="form-grid">

<div class="field">
<label>Full name</label>
<input class="input" name="full_name" required>
</div>

<div class="field">
<label>Loan amount</label>
<input class="input" name="amount" type="number" required>
</div>

<div class="field">
<label>Tenure (months)</label>
<input class="input" name="tenure" type="number" required>
</div>

<div class="field">
<label>Purpose</label>
<select class="input" name="purpose" required>
  <option>Small shop expansion</option>
  <option>Agricultural equipment</option>
  <option>Dairy / livestock</option>
  <option>Education</option>
  <option>Medical emergency</option>
  <option>Home improvement</option>
</select>
</div>

</div>

<button class="btn btn-primary">Create Loan</button>

</form>

</section>

</main>
</div>

</body>
</html>