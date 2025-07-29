<?php
require 'db_connect.php';

$order_id = trim($_GET['order_uid'] ?? '');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Track Order - R.R. Business</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #f44336, #fda085);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            max-width: 500px;
            width: 90%;
            background: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border-radius: 16px;
            padding: 40px 30px;
            text-align: center;
            animation: fadeIn 0.5s ease-in-out;
        }

        h2 {
            color: #c62828;
            margin-bottom: 25px;
        }

        .detail {
            font-size: 18px;
            margin: 12px 0;
            color: #333;
        }

        .status {
            font-weight: bold;
            color: #007bff;
        }

        .cancel-reason {
            margin-top: 15px;
            color: #e63946;
            font-style: italic;
        }

        .btn-wrapper {
            margin-top: 35px;
        }

        .back-btn {
            background: #007bff;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            transition: 0.3s ease;
        }

        .back-btn:hover {
            background: #0056b3;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="container">
    <?php
    if (!$order_id) {
        echo "<script>alert('Please enter Order ID'); history.back();</script>";
        exit;
    }

    $query = "SELECT customer_name, product_name, status, cancel_reason FROM orders WHERE order_uid = '$order_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        echo "<h2>Order Status</h2>";
        echo "<div class='detail'>Customer Name: <b>" . htmlspecialchars($row['customer_name']) . "</b></div>";
        echo "<div class='detail'>Product: <b>" . htmlspecialchars($row['product_name']) . "</b></div>";
        echo "<div class='detail'>Status: <span class='status'>" . htmlspecialchars($row['status']) . "</span></div>";

        if (strtolower($row['status']) === 'cancelled') {
            echo "<div class='cancel-reason'>Reason: " . htmlspecialchars($row['cancel_reason']) . "</div>";
        }
    } else {
        echo "<h2>Order Not Found</h2>";
        echo "<p class='detail'>Please check your Order ID and try again.</p>";
    }
    ?>

    <!-- ✅ Go to Home button hamesha sabse last mein aur reason ke bahar -->
    <div class="btn-wrapper">
        <a href="index.php" class="back-btn">Go to Home</a>
    </div>
</div>

</body>
</html>
