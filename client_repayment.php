<?php include 'db.php'; session_start(); ?>

<?php
if($_SESSION['role'] != 'client'){
  header("Location: login.php");
}

$user = $_SESSION['user'];

if($_SERVER["REQUEST_METHOD"] == "POST"){
  $loan_id = $_POST['loan_id'];
  $amount = $_POST['amount'];

  $loan_id = str_replace("LN-","",$loan_id);

  pg_query($conn,"
  INSERT INTO repayments (loan_id, amount, payment_date)
  VALUES ($loan_id, $amount, CURRENT_DATE)
  ");

  header("Location: client_repayment.php");
}

$loans = pg_query($conn,"SELECT * FROM loans WHERE borrower_name='$user'");

$nextLoan = pg_fetch_assoc(pg_query($conn,"
SELECT * FROM loans 
WHERE borrower_name='$user' AND status='Active'
ORDER BY due_date ASC LIMIT 1
"));

$nextEMI = $nextLoan ? $nextLoan['emi'] : 0;
$nextDate = $nextLoan ? $nextLoan['due_date'] : "-";

$totalPaid = pg_fetch_result(pg_query($conn,"
SELECT COALESCE(SUM(amount),0) FROM repayments 
JOIN loans ON loans.id = repayments.loan_id
WHERE loans.borrower_name='$user'
"),0,0);

$remaining = pg_fetch_result(pg_query($conn,"
SELECT 
  COALESCE(
    (SELECT SUM(loan_amount) FROM loans 
     WHERE borrower_name='$user' AND status!='Closed'), 0
  )
  -
  COALESCE(
    (SELECT SUM(amount) FROM repayments 
     WHERE loan_id IN (
       SELECT id FROM loans WHERE borrower_name='$user'
     )
    ), 0
  )
"),0,0);

$history = pg_query($conn,"
SELECT repayments.*, loans.borrower_name 
FROM repayments
JOIN loans ON loans.id = repayments.loan_id
WHERE loans.borrower_name='$user'
ORDER BY payment_date DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>Repayments · LoanBridge</title>

<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css"/>
</head>

<body>
<div class="app">

<aside class="sidebar">
  <div class="brand-mini"><div class="logo">L</div><div class="name">LOAN<span>BRIDGE</span></div></div>

  <nav class="nav">
    <a href="client_dashboard.php">Home</a>
    <a href="apply_loan.php">Apply for loan</a>
    <a href="my_loans.php">My loans</a>
    <a class="is-active" href="client_repayment.php">Repayments</a>
    <a href="logout.php">Log out</a>
  </nav>

  <div class="me">
    <div class="avatar lilac">U</div>
    <div class="who"><?php echo $user; ?><span class="role">Borrower</span></div>
  </div>
</aside>

<main class="main">

<header class="page-head">
  <h1>YOUR <em>REPAYMENTS.</em></h1>
  <p class="sub">Next EMI ₹<?php echo $nextEMI; ?> due on <?php echo $nextDate; ?></p>
</header>

<section class="kpis">

<div class="kpi peach">
  <div class="k">₹<?php echo $nextEMI; ?></div>
  <div class="l">Next EMI</div>
</div>

<div class="kpi mint">
  <div class="k">₹<?php echo $totalPaid; ?></div>
  <div class="l">Paid to date</div>
</div>

<div class="kpi rose">
  <div class="k">₹<?php echo $remaining; ?></div>
  <div class="l">Remaining</div>
</div>

</section>

<section class="card">

<h3>Payment history</h3>

<table class="t">
<thead>
<tr>
<th>Date</th>
<th>Amount</th>
<th>Status</th>
</tr>
</thead>

<tbody>

<?php while($row = pg_fetch_assoc($history)){ ?>
<tr>
<td><?php echo $row['payment_date']; ?></td>
<td>₹<?php echo $row['amount']; ?></td>
<td><span class="badge ok">Paid</span></td>
</tr>
<?php } ?>

</tbody>
</table>

</section>

<section class="card">

<h3>Pay now</h3>

<form method="POST">

<input type="hidden" name="loan_id" value="LN-<?php echo $nextLoan['id']; ?>">

<div class="field">
<label>Amount</label>
<input class="input" name="amount" value="<?php echo $nextEMI; ?>" readonly>
</div>

<button class="btn btn-primary">Pay EMI</button>

</form>

</section>

</main>
</div>

</body>
</html>