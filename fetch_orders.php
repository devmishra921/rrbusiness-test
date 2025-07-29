<?php
$host = 'localhost';
$db = 'rr_business';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$result = $conn->query("SELECT * FROM orders ORDER BY order_date DESC");
$orders = [];

while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

header('Content-Type: application/json');
echo json_encode($orders);
$conn->close();
?>
