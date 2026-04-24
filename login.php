<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login · LoanBridge</title>

<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">

<style>

body {
  margin: 0;
  font-family: 'Inter', sans-serif;
  background: radial-gradient(circle at top, #0f172a, #020617);
}

.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;

  backdrop-filter: blur(10px);
  background: rgba(0,0,0,0.5);

  display: flex;
  justify-content: center;
  align-items: center;

  z-index: 999;
}

.login-card {
  width: 380px;
  padding: 30px;

  background: rgba(15, 23, 42, 0.85);
  border-radius: 16px;

  border: 1px solid rgba(255,255,255,0.08);

  box-shadow:
    0 20px 60px rgba(0,0,0,0.6),
    0 0 40px rgba(59,130,246,0.2);

  backdrop-filter: blur(20px);

  animation: popIn 0.3s ease;
}

@keyframes popIn {
  from {
    transform: scale(0.95);
    opacity: 0;
  }
  to {
    transform: scale(1);
    opacity: 10;
  }
}

.login-card h3 {
  text-align: center;
  font-weight: 700;
  margin-bottom: 5px;
}

.login-card .sub {
  text-align: center;
  margin-bottom: 20px;
}

.field {
  margin-bottom: 15px;
}

.helper {
  text-align: center;
  margin-top: 15px;
  font-size: 14px;
}

</style>
</head>

<body>

<div class="modal-overlay">

  <div class="login-card">

    <h3>LOGIN</h3>
    <p class="sub">Access your LoanBridge account</p>

    <form action="auth.php" method="POST">

      <input type="hidden" name="type" value="<?php echo $_GET['type'] ?? ''; ?>">

      <div class="field">
        <label>Username</label>
        <input class="input" type="text" name="username" required>
      </div>

      <div class="field">
        <label>Password</label>
        <input class="input" type="password" name="password" required>
      </div>

      <label style="display:flex; align-items:center; gap:8px; font-size:13px; margin-bottom:14px;">
        <input type="checkbox" name="remember"> Remember me
      </label>

      <button class="btn btn-primary btn-block" type="submit">Login</button>

      <div class="helper">
        Don’t have an account?
        <a href="register.php">Register</a>
      </div>

    </form>

  </div>

</div>

</body>
</html>