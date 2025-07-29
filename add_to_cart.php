<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_name'], $_POST['price'], $_POST['quantity'])) {
    $product = trim($_POST['product_name']);
    $price = floatval($_POST['price']);
    $quantity = max(1, intval($_POST['quantity']));

    // यदि cart नहीं बना है तो बनाएं
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // यदि प्रोडक्ट पहले से है तो उसकी quantity बढ़ाएं
    if (isset($_SESSION['cart'][$product])) {
        $_SESSION['cart'][$product]['quantity'] += $quantity;
    } else {
        // नया प्रोडक्ट जोड़ें
        $_SESSION['cart'][$product] = [
            'price' => $price,
            'quantity' => $quantity
        ];
    }

    // Redirect वापस products.php पर
    header("Location: products.php?added=1");
    exit();
}
?>
