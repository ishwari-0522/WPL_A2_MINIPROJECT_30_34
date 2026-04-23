<?php include 'header.php'; ?>

<div class="ppage-inner">

<div class="card">
<div class="c-head"><span class="c-title">Login</span></div>

<div class="m-body">

<form action="auth.php" method="POST">
<input type="hidden" name="type" value="<?php echo $_GET['type']; ?>">

<input class="fc" type="text" name="username" placeholder="Username"><br><br>
<input class="fc" type="password" name="password" placeholder="Password"><br><br>

<button class="btn-confirm">Login</button>
</form>

</div>
</div>

</div>

<?php include 'footer.php'; ?>