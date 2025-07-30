<?php
$host = 'sql110.infinityfree.com';
$user = 'if0_39236898';
$pass = 'Rrbusiness2025';
$db   = 'if0_39236898_rrbusiness'; 
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed']));
}

// Total products
$tp = $conn->query("SELECT COUNT(*) AS count FROM products")->fetch_assoc()['count'];

// Orders
$no = $conn->query("SELECT COUNT(*) AS count FROM orders WHERE status = 'new'")->fetch_assoc()['count'];
$ip = $conn->query("SELECT COUNT(*) AS count FROM orders WHERE status = 'in_progress'")->fetch_assoc()['count'];
$co = $conn->query("SELECT COUNT(*) AS count FROM orders WHERE status = 'completed'")->fetch_assoc()['count'];

// Messages (queries)
$pq = $conn->query("SELECT COUNT(*) AS count FROM message WHERE status = 'pending'")->fetch_assoc()['count'];
$cq = $conn->query("SELECT COUNT(*) AS count FROM message WHERE status = 'completed'")->fetch_assoc()['count'];

$no = $conn->query("
        SELECT COUNT(*) AS count
        FROM orders
        WHERE status IN ('new','pending')
    ")->fetch_assoc()['count'];


echo json_encode([
    'total_products' => $tp,
    'new_orders' => $no,
    'in_progress' => $ip,
    'completed_orders' => $co,
    'pending_queries' => $pq,
    'completed_queries' => $cq
]);
?>
