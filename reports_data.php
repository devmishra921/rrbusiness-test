<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['admin_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

require 'db_connect.php';

// Debugging: Check if connection is working
if (!$conn) {
    echo json_encode(['error' => 'Database connection failed', 'details' => mysqli_connect_error()]);
    exit;
}

$range = $_GET['range'] ?? '7';
$fromDate = $_GET['from'] ?? null;
$toDate = $_GET['to'] ?? null;

$labels = [];
$data = [];

// Handle custom date
if ($range === 'custom' && $fromDate && $toDate) {
    $query = "SELECT DATE(order_date) as order_date, SUM(total_amount) as total 
FROM orders 
WHERE order_date >= CURDATE() - INTERVAL 7 DAY 
GROUP BY DATE(order_date)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $fromDate, $toDate);
} else {
    $dateCond = match($range) {
        'today' => "DATE(order_date) = CURDATE()",
        '7' => "order_date >= CURDATE() - INTERVAL 7 DAY",
        '30' => "order_date >= CURDATE() - INTERVAL 30 DAY",
        '90' => "order_date >= CURDATE() - INTERVAL 90 DAY",
        '365' => "order_date >= CURDATE() - INTERVAL 1 YEAR",
        default => "order_date >= CURDATE() - INTERVAL 7 DAY"
    };
    $query = "SELECT DATE(order_date) as order_date, SUM(total_amount) as total 
              FROM orders 
              WHERE $dateCond 
              GROUP BY DATE(order_date)";
    $stmt = $conn->prepare($query);
}

// Check if statement prepared successfully
if (!$stmt) {
    echo json_encode(['error' => 'SQL Prepare failed', 'details' => $conn->error]);
    exit;
}

$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $labels[] = $row['order_date'];
    $data[] = (float)$row['total'];
}

echo json_encode(['labels' => $labels, 'data' => $data]);
?>
