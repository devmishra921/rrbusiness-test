<?php
session_start();

// Secure DB connection
$host = 'sql110.infinityfree.com';
$user = 'if0_39236898';
$pass = 'Rrbusiness2025';
$db   = 'if0_39236898_rrbusiness';

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Prepared statement to prevent SQL Injection
  $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username=? AND password=?");
  mysqli_stmt_bind_param($stmt, "ss", $username, $password);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if (mysqli_num_rows($result) == 1) {
    $_SESSION['user'] = $username;
    header("Location: index.php");
    exit;
  } else {
    echo "<script>alert('Invalid credentials'); window.history.back();</script>";
  }
}
?>
