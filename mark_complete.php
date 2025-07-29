<?php
$host = 'localhost';
$db = 'rr_business';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id'])) {
    $id = intval($_POST['order_id']);
    $conn->query("UPDATE orders SET status='completed' WHERE id=$id");
    echo "Order completed";
}
$conn->close();
?>
