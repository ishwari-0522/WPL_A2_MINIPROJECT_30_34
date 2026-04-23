<?php
session_start();
include 'header.php';
include 'navbar.php';

if (!isset($_SESSION['user'])) header("Location: login.php");
?>

<form action="insert_loan.php" method="POST">

<input class="fc" name="name" placeholder="Name"><br>
<input class="fc" name="amount" placeholder="Amount"><br>
<input class="fc" name="emi" placeholder="EMI"><br>

<input type="hidden" name="status" value="Pending">

<input class="fc" type="date" name="due"><br>

<button class="btn-confirm">Apply</button>

</form>

<?php include 'footer.php'; ?>