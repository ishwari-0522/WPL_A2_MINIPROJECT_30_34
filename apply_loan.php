<?php include 'db.php'; session_start(); ?>

<?php
if($_SESSION['role'] != 'client'){
  header("Location: login.php?type=client");
  exit;
}

$user = $_SESSION['user'];

/* ===== HANDLE FORM SUBMIT ===== */
if($_SERVER["REQUEST_METHOD"] == "POST"){

  $purpose   = $_POST['purpose'];
  $amount    = $_POST['amount'];
  $tenure    = $_POST['tenure'];
  $aadhaar   = $_POST['aadhaar'];
  $income    = $_POST['income'];
  $occupation= $_POST['occupation'];
  $notes     = $_POST['notes'];

  pg_query_params($conn,
"INSERT INTO applications 
(applicant_name, amount, purpose, status)
VALUES ($1,$2,$3,'Pending')",
array($user,$amount,$purpose)
);

  header("Location: client_dashboard.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>Apply for Loan · LoanBridge</title>

<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
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

  <nav class="nav">
    <a href="client_dashboard.php">Home</a>
    <a class="is-active" href="apply_loan.php">Apply for loan</a>
    <a href="my_loans.php">My loans</a>
    <a href="client_repayment.php">Repayments</a>
    <a href="logout.php">Log out</a>
  </nav>

  <div class="me">
    <div class="avatar lilac">U</div>
    <div class="who"><?php echo $user; ?><span class="role">Borrower</span></div>
  </div>
</aside>

<!-- MAIN -->
<main class="main">

<header class="page-head">
  <h1>APPLY FOR A <em>LOAN.</em></h1>
</header>

<section class="card">

<form method="POST">

<div class="form-grid">

<div class="field">
<label>Purpose of loan</label>
<select class="input" name="purpose" required>
  <option>Small shop expansion</option>
  <option>Agricultural equipment</option>
  <option>Dairy / livestock</option>
  <option>Education</option>
  <option>Medical emergency</option>
  <option>Home improvement</option>
</select>
</div>

<div class="field">
<label>Amount</label>
<input class="input" id="amt" type="number" name="amount" required>
</div>

</div>

<div class="form-grid">

<div class="field">
<label>Tenure (months)</label>
<input class="input" id="ten" type="number" name="tenure" required>
</div>

<div class="field">
<label>Aadhaar Number</label>
<input class="input aadhaar" type="text" name="aadhaar" placeholder="XXXX XXXX XXXX" maxlength="14" required>
</div>

</div>

<div class="form-grid">

<div class="field">
<label>Income</label>
<input class="input" type="number" name="income">
</div>

<div class="field">
<label>Occupation</label>
<input class="input" name="occupation">
</div>

</div>

<div class="field">
<label>Notes</label>
<textarea class="textarea" name="notes"></textarea>
</div>

<button class="btn btn-primary">Submit application</button>

</form>

</section>

</main>
</div>

<!-- Aadhaar Formatter -->
<script>
document.querySelectorAll('input.aadhaar').forEach(inp => {
  inp.addEventListener('input', e => {
    let v = e.target.value.replace(/\D/g, '').slice(0, 12);
    e.target.value = v.replace(/(\d{4})(?=\d)/g, '$1 ').trim();
  });
});
</script>

</body>
</html>