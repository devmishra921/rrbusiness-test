<?php
require 'db_connect.php';

$order_id = trim($_POST['track_order_id'] ?? '');

if (!$order_id) {
  echo "<script>alert('Please enter Order ID'); history.back();</script>";
  exit;
}

$query = $conn->prepare("SELECT customer_name, product_name, status, remarks FROM orders WHERE order_uid = ?");
$query->bind_param("s", $order_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  echo "<h3>Order Status</h3>";
  echo "<p><strong>Name:</strong> {$row['customer_name']}</p>";
  echo "<p><strong>Product:</strong> {$row['product_name']}</p>";
  echo "<p><strong>Status:</strong> {$row['status']}</p>";
  if ($row['status'] == 'cancelled') {
    echo "<p><strong>Reason:</strong> {$row['remarks']}</p>";
  }
} else {
  echo "<script>alert('Invalid Order ID'); history.back();</script>";
}

$conn->close();
?>
