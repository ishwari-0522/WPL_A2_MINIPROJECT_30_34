<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>
<?php include 'db.php'; ?>

<div class="ppage-inner">

<table>
<tr>
<th>Name</th>
<th>Amount</th>
<th>Due Date</th>
</tr>

<?php
$result = pg_query($conn, "
SELECT * FROM loans 
WHERE due_date < CURRENT_DATE AND status != 'Closed'
");

while($row = pg_fetch_assoc($result)){
?>
<tr>
<td><?php echo $row['borrower_name']; ?></td>
<td><?php echo $row['loan_amount']; ?></td>
<td><?php echo $row['due_date']; ?></td>
</tr>
<?php } ?>

</table>

</div>

<?php include 'footer.php'; ?>