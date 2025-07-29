<?php
session_start();
require 'db_connect.php';

$customer = trim($_POST['customer_name'] ?? '');
$email    = trim($_POST['email'] ?? '');
$phone    = trim($_POST['phone'] ?? '');
$address  = trim($_POST['address'] ?? '');
$txnId    = trim($_POST['transaction_id'] ?? '');
$paid     = 1;  // Payment verified
$gstAmt   = floatval($_POST['gst_amount'] ?? 0);
$totalAmt = floatval($_POST['total'] ?? 0);

// Arrays of products
$products = $_POST['products'] ?? [];
$qtys     = $_POST['qtys'] ?? [];
$rates    = $_POST['rates'] ?? [];

if (!$customer || !$email || !$phone || !$address || !$txnId || empty($products)) {
    echo "<script>alert('Please fill all required fields.'); history.back();</script>";
    exit;
}

// Combine product details
$productDetails = '';
for ($i = 0; $i < count($products); $i++) {
    $pname = htmlspecialchars($products[$i]);
    $qty = intval($qtys[$i]);
    $rate = floatval($rates[$i]);
    $productDetails .= "$pname (Qty: $qty, ₹$rate each)\n";
}

// Generate Order UID
$order_uid = 'RR' . date('Ymd') . rand(1000, 9999);

// Insert into orders table
$sql = "INSERT INTO `orders` 
(order_uid, customer_name, email, phone, product_name, quantity, address, transaction_id, payment_status, status) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'new')";

$stmt = $conn->prepare($sql);
$totalQty = array_sum($qtys);
$stmt->bind_param('sssssisii', $order_uid, $customer, $email, $phone, $productDetails, $totalQty, $address, $txnId, $paid);

if ($stmt->execute()) {
    // ✅ Email Send Code - Commented for now
    /*
    $to = $email;
    $subject = "R.R. Business - Order Confirmation";
    $message = "Hello $customer,\n\nThank you for your order.\n\nOrder ID: $order_uid\n\nProducts:\n$productDetails\n\nTotal Amount: ₹$totalAmt\n\nTrack your order here:\nhttps://yourdomain.com/track_order.php?order_uid=$order_uid\n\nRegards,\nR.R. Business Team";
    $headers = "From: support@rrbusiness.com";

    mail($to, $subject, $message, $headers);  // Send email
    */

    // ✅ Show confirmation + copy button
    echo "
    <html><body style='font-family:sans-serif; text-align:center; padding:50px;'>
    <h2 style='color:green;'>Order Placed Successfully!</h2>
    <p>Your Order ID: <b id='orderId'>$order_uid</b></p>
    <button onclick='copyOrderId()' style='padding:8px 16px; font-size:16px;'>Copy Order ID</button>
    <p style='margin-top:20px;'><a href='track_order.php?order_uid=$order_uid' style='text-decoration:underline; color:#007bff;'>Track Your Order</a></p>
    <p><a href='index.php'>Back to Home</a></p>
    
    <script>
    function copyOrderId(){
      const id = document.getElementById('orderId').textContent;
      navigator.clipboard.writeText(id).then(()=>{
        alert('Order ID copied!');
      });
    }
    </script>
    </body></html>";
} else {
    echo 'DB Error: '.$stmt->error;
}

$stmt->close();
$conn->close();
?>
