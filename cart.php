<?php
session_start();
if (!isset($_SESSION['cart'])) {
    header('Location: products.php');
    exit();
}

$product = $_SESSION['cart'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cart | R.R. Business</title>
</head>
<body>

<h2>Your Cart</h2>

<form method="post" action="payment.php">
    Product: <strong><?= $product['product_name'] ?></strong><br>
    Price: ₹<strong><?= $product['price'] ?></strong><br><br>

    Quantity: 
    <input type="number" name="qty" value="1" min="1" required><br><br>

    <input type="hidden" name="product_name" value="<?= $product['product_name'] ?>">
    <input type="hidden" name="price" value="<?= $product['price'] ?>">

    <button type="submit">Proceed to Payment</button>
</form>

</body>
</html>
