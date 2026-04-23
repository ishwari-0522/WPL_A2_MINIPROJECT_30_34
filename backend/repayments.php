<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>
<?php include 'db.php'; ?>

<div class="ppage-inner">

<table>
<tr>
<th>Loan ID</th>
<th>Amount</th>
<th>Date</th>
</tr>

<?php
$result = pg_query($conn, "SELECT * FROM repayments");

while($row = pg_fetch_assoc($result)){
?>
<tr>
<td><?php echo $row['loan_id']; ?></td>
<td><?php echo $row['amount']; ?></td>
<td><?php echo $row['payment_date']; ?></td>
</tr>
<?php } ?>

</table>

</div>

<?php include 'footer.php'; ?>