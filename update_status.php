<?php
// update_status.php
require 'db_connect.php';

$type = $_POST['type'] ?? '';
$id   = intval($_POST['id'] ?? 0);

if ($type === 'order') {
    $table = 'orders';
} elseif ($type === 'query') {
    $table = 'queries';
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid type']);
    exit;
}

$stmt = $conn->prepare("UPDATE $table SET status = 'completed' WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();

echo json_encode(['success' => $stmt->affected_rows > 0]);
