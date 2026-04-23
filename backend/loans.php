<?php include 'header.php'; include 'navbar.php'; include 'db.php'; ?>

<table>
<tr><th>Name</th><th>Amount</th><th>Status</th></tr>

<?php
$r=pg_query($conn,"SELECT * FROM loans");
while($row=pg_fetch_assoc($r)){
echo "<tr><td>{$row['borrower_name']}</td><td>{$row['loan_amount']}</td><td>{$row['status']}</td></tr>";
}
?>
</table>

<?php include 'footer.php'; ?>