<?php include 'header.php'; include 'navbar.php'; include 'db.php'; ?>

<?php
$total = pg_fetch_result(pg_query($conn,"SELECT COUNT(*) FROM loans"),0,0);
$sum = pg_fetch_result(pg_query($conn,"SELECT COALESCE(SUM(loan_amount),0) FROM loans"),0,0);
?>

<h2>Total Loans: <?php echo $total; ?></h2>
<h2>Total Amount: ₹<?php echo $sum; ?></h2>

<?php include 'footer.php'; ?>