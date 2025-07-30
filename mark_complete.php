<?php
$host = 'sql110.infinityfree.com';
$user = 'if0_39236898';
$pass = 'Rrbusiness2025';
$db   = 'if0_39236898_rrbusiness'; 
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id'])) {
    $id = intval($_POST['order_id']);
    $conn->query("UPDATE orders SET status='completed' WHERE id=$id");
    echo "Order completed";
}
$conn->close();
?>
