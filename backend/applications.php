<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>
<?php include 'db.php'; ?>

<div class="ppage-inner">

<table>
<tr>
<th>Name</th>
<th>Amount</th>
<th>Purpose</th>
<th>Status</th>
</tr>

<?php
$result = pg_query($conn, "SELECT * FROM applications");

while($row = pg_fetch_assoc($result)){
?>
<tr>
<td><?php echo $row['applicant_name']; ?></td>
<td><?php echo $row['amount']; ?></td>
<td><?php echo $row['purpose']; ?></td>
<td><?php echo $row['status']; ?></td>
</tr>
<?php } ?>

</table>

</div>

<?php include 'footer.php'; ?>