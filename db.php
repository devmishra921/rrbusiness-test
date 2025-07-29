<?php
$conn = new mysqli("localhost", "root", "", "rr_business");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
?>
