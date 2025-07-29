<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['product_name'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];
    $total = $qty * $price;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment | R.R. Business</title>
</head>
<body>

<h2>Payment Page</h2>

<p>Product: <strong><?= $name ?></strong></p>
<p>Price: ₹<?= $price ?> x <?= $qty ?> = ₹<?= $total ?></p>

<form method="post" action="payment_success.php">
    <input type="hidden" name="amount" value="<?= $total ?>">
    <input type="text" name="customer_name" placeholder="Your Name" required><br><br>
    <input type="email" name="email" placeholder="Email ID" required><br><br>
    <button type="submit">Make Payment</button>
</form>

</body>
</html>
