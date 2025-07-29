<?php
$conn = new mysqli('localhost', 'root', '', 'rr_business');

$data = [
    'total_products' => 0,
    'new_orders' => 0,
    'pending_queries' => 0
];

if (!$conn->connect_error) {
    $data['total_products'] = $conn->query("SELECT COUNT(*) FROM products")->fetch_row()[0];
    $data['new_orders'] = $conn->query("SELECT COUNT(*) FROM orders WHERE status='new'")->fetch_row()[0];
    $data['pending_queries'] = $conn->query("SELECT COUNT(*) FROM messages WHERE status='unread'")->fetch_row()[0];
}

header('Content-Type: application/json');
echo json_encode($data);
?>
