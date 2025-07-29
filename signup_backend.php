<?php
$conn = mysqli_connect("localhost", "root", "", "rr_business");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  $check = "SELECT * FROM users WHERE username='$username'";
  $res = mysqli_query($conn, $check);
  if (mysqli_num_rows($res) > 0) {
    echo "<script>alert('Username already exists'); window.history.back();</script>";
  } else {
    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    if (mysqli_query($conn, $sql)) {
      echo "<script>alert('Signup Successful'); window.location.href='index.php';</script>";
    } else {
      echo "<script>alert('Error in signup'); window.history.back();</script>";
    }
  }
}
?>
