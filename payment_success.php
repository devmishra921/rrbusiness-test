<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $customer = $_POST['customer_name'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Thank You</title>
</head>
<body>

<h2>Payment Successful</h2>
<p>Thank you <?= $customer ?>, your payment of ₹<?= $amount ?> was successful.</p>

<a href="products.php">Go Back to Products</a>

</body>
</html>
