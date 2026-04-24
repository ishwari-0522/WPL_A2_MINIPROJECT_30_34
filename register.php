<?php include 'db.php'; session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register · LoanBridge</title>

<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="auth-shell">

  <div class="auth-card">

    <!-- HEADER -->
    <div class="auth-header">
      <h2>CREATE <em>ACCOUNT.</em></h2>
      <p>Join LoanBridge to manage your loans seamlessly.</p>
    </div>

    <!-- FORM -->
    <form action="register_backend.php" method="POST" class="auth-form">

      <div class="field">
        <label>Username</label>
        <input class="input" type="text" name="username" placeholder="Enter username" required>
      </div>

      <div class="field">
        <label>Password</label>
        <input class="input" type="password" name="password" placeholder="Enter password" required>
      </div>

      <div class="auth-options">
        <label class="check">
          <input type="checkbox" name="remember">
          <span>Remember me</span>
        </label>
      </div>

      <button class="btn btn-primary full">Register</button>

    </form>

    <!-- FOOTER -->
    <div class="auth-footer">
      Already have an account?
      <a href="login.php?type=client">Login</a>
    </div>

  </div>

</div>

</body>
</html>