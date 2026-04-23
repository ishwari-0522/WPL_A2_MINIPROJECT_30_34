<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>

<div class="ppage-inner">

<form action="insert_loan.php" method="POST">

<input class="fc" type="text" name="name" placeholder="Name"><br><br>
<input class="fc" type="number" name="amount" placeholder="Amount"><br><br>
<input class="fc" type="number" name="emi" placeholder="EMI"><br><br>

<select class="fc" name="status">
<option>Active</option>
<option>Pending</option>
<option>Closed</option>
<option>Overdue</option>
</select><br><br>

<input class="fc" type="date" name="due"><br><br>

<button class="btn-confirm">Insert</button>

</form>

</div>

<?php include 'footer.php'; ?>