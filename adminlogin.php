<?php
require 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];
  if ($username === 'admin' && $password === 'admin123') {
    $_SESSION['admin'] = true;
    header("Location: admin/dashboard.php");
    exit;
  } else {
    $error = "Invalid credentials";
  }
}
?>
<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
  <h2>Admin Login</h2>
  <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
  <form method="POST">
    <input name="username" required placeholder="Username"><br>
    <input name="password" type="password" required placeholder="Password"><br>
    <button type="submit">Login</button>
  </form>
</body>
</html>
