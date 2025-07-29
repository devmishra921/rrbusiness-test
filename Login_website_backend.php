<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "rr_business");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) == 1) {
    $_SESSION['user'] = $username;  // 🟢 Store username
    header("Location: index.php");
  } else {
    echo "<script>alert('Invalid credentials'); window.history.back();</script>";
  }
}
?>
