<?php
// receipt.php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include("navbar.php");
require 'config.php';

session_start();
// Check if the user is logged in
if (empty($_SESSION["user_id"])) {
    echo "<script>alert('Please log in first.'); window.location.href='login.php'</script>";
}

// Retrieve payment details from the database based on the latest transaction
$userID = $_SESSION["user_id"];
$latestTransactionQuery = "SELECT * FROM payment_history WHERE user_id = '$userID' ORDER BY transactionID DESC LIMIT 1";
$latestTransactionResult = mysqli_query($conn, $latestTransactionQuery);

if (!$latestTransactionResult) {
    die("Error in SQL query: " . mysqli_error($conn));
}

// Fetch the transaction details
$transactionDetails = mysqli_fetch_assoc($latestTransactionResult);

// Retrieve all products associated with the transaction
$transactionProductsQuery = "SELECT * FROM payment_history WHERE transactionID = '{$transactionDetails['transactionID']}'";
$transactionProductsResult = mysqli_query($conn, $transactionProductsQuery);

if (!$transactionProductsResult) {
    die("Error in SQL query: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <!-- Add your stylesheets and other head elements here -->

    <style>
        body {
            font-family: poppins;
            background-color: #f4f4f4;
        }

        .receipt-container {
            margin-top: 70px;
            margin-left: 350px;
            padding: 20px;
            width: 80%;
            max-width: 800px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #f89819;
        }

        .receipt-details {
            margin-top: 20px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .product-list {
            margin-top: 20px;
        }

        .product-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .total-container {
            margin-top: 20px;
            text-align: right;
            background-color: white;
            padding: 15px;
            box-shadow: 0px 2px 3px 0px rgba(187, 187, 187, 0.5);
            border-radius: 8px;
        }

        hr{
                border-style: none;
                border: 1px solid #d4d4d4;
            }
    </style>
</head>

<body>
    <!-- Receipt Container -->
    <div class="receipt-container">
        <h1>RECEIPT</h1>
        <hr>

        <div class="receipt-details">
            <div class="detail-row">
                <span>Transaction ID:</span>
                <span><?php echo $transactionDetails['transactionID']; ?></span>
            </div>
            <div class="detail-row">
                <span>Order Date:</span>
                <span><?php echo $transactionDetails['orderDate']; ?></span>
            </div>
            <div class="detail-row">
                <span>Transaction Time:</span>
                <span><?php echo $transactionDetails['time']; ?></span>
            </div>
        </div>

        <div class="product-list">
            <h2>Products</h2>
            <?php while ($product = mysqli_fetch_assoc($transactionProductsResult)) : ?>
                <div class="product-item">
                    <span><?php echo $product['product_name']; ?></span>
                    <span><?php echo '₱' . $product['price'] . '.00'; ?> x <?php echo $product['quantity']; ?></span>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="total-container">
            <strong>Total Amount:</strong> ₱<?php echo $transactionDetails['total_amount']; ?>
        </div>
    </div>
    <!-- Add your additional HTML content and scripts here -->
</body>

</html>
