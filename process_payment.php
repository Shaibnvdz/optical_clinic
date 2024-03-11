<?php
session_start();
include ('admin-sidebar.php');
$mysqli = require __DIR__ . "/database.php";

// Function to calculate total
function calculateTotal($cart, $products) {
    $total = 0;

    foreach ($cart as $productId => $quantity) {
        $product = array_filter($products, function ($p) use ($productId) {
            return $p["id"] == $productId;
        });

        $product = reset($product);

        $total += $product["price"] * $quantity;
    }

    return $total;
}

// Retrieve cart data
$cart = isset($_SESSION["cart"]) ? $_SESSION["cart"] : [];

// Fetch products from the database
$sql = "SELECT * FROM addproduct";
$result = $mysqli->query($sql);
$products = $result->fetch_all(MYSQLI_ASSOC);

// Calculate total
$total = calculateTotal($cart, $products);

// Validate the peso cash input
if (isset($_POST['cash_amount']) && is_numeric($_POST['cash_amount'])) {
    $cashAmount = floatval($_POST['cash_amount']);

    // Check if the cash amount is sufficient
    if ($cashAmount >= $total) {
        // Process the payment (You can implement your payment processing logic here)

        // Clear the cart after successful payment
        unset($_SESSION['cart']);

        // Calculate change
        $change = $cashAmount - $total;
    } else {
        // Display error message if the cash amount is not sufficient
        echo "<script>
            alert('Error: Insufficient funds. Please enter a valid amount.');
            window.history.go(-1); 
        </script>";
    }
} else {
    // Display error message if the cash amount is not numeric
    echo "<h2>Error: Invalid input. Please enter a valid numeric amount.</h2>";
}
$mysqli = require __DIR__ . "/database.php";

$user_id = $_SESSION["user_id"];

// Fetch user data from the database
$sql = "SELECT * FROM user WHERE id = $user_id";
$result = $mysqli->query($sql);
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
        body {
            font-family: poppins;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            min-height: 100vh;
            color: #40596b;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 80%;
            max-width: 600px;
            margin-left: 450px;
        }

        h1, h2, h3 {
            color: #40596b;
            text-align: center;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        p {
            margin: 0;
        }

        .total {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Payment Receipt</h1>

        <?php if (isset($change)): ?>
            <h2>Payment successful! Thank you for your purchase.</h2>

            <h3>Receipt:</h3>
            <ul>
                <?php foreach ($cart as $productId => $quantity): ?>
                    <?php
                        $product = array_filter($products, function ($p) use ($productId) {
                            return $p["id"] == $productId;
                        });

                        $product = reset($product);
                    ?>
                    <li>
                        <p><?php echo htmlspecialchars($product["name"]); ?></p>
                        <p>Quantity: <?php echo $quantity; ?></p>
                        <p>Subtotal: ₱<?php echo number_format($product["price"] * $quantity, 2); ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="total">
                <p>Total Amount: ₱<?php echo number_format($total, 2); ?></p>
                <p>Cash Amount Received: ₱<?php echo number_format($cashAmount, 2); ?></p>
                <p>Change: ₱<?php echo number_format($change, 2); ?></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
