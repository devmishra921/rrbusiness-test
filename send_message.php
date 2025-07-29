<?php
require 'db_connect.php';          // DB connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Form values
    $name  = trim($_POST['name']    ?? '');
    $email = trim($_POST['email']   ?? '');
    $phone = trim($_POST['phone']   ?? '');
    $msg   = trim($_POST['message'] ?? '');

    // 2. Basic empty‑check (optional)
    if (!$name || !$email || !$phone || !$msg) {
        echo "<script>alert('Please fill all fields.'); history.back();</script>";
        exit;
    }

    // 3. Prepare insert – table `message` (back‑ticks) & exact column names
    $sql = "INSERT INTO `message` (customer_name, email, phone, query_text)
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die('Prepare failed: ' . $conn->error);   // dev‑debug, live में हटा सकते हैं
    }

    // 4. Bind + execute
    $stmt->bind_param('ssss', $name, $email, $phone, $msg);

    if ($stmt->execute()) {
        echo "<script>alert('Message sent!'); window.location.href='contact.php#contact';</script>";
    } else {
        echo 'DB Error: ' . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>
