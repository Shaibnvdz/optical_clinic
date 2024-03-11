<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$mysqli = require __DIR__ . "/database.php";

// Fetch user data from the database
$sql = "SELECT * FROM user WHERE id = {$_SESSION["user_id"]}";
$result = $mysqli->query($sql);
$user = $result->fetch_assoc();

// Fetch products from the database
$sql = "SELECT * FROM products";
$result = $mysqli->query($sql);
$products = $result->fetch_all(MYSQLI_ASSOC);

// Check if the cart is set in the session
$cart = isset($_SESSION["cart"]) ? $_SESSION["cart"] : [];

// Calculate total price
$total = calculateTotal($cart, $products);

// Clear the shopping cart after checkout
unset($_SESSION["cart"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Success</title>
    <link rel="stylesheet" href="admin.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        #success-message {
            width: 50%;
            box-sizing: border-box;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: absolute;
            left: 25%;
            top: 20px;
        }

        h1, h2, p {
            color: #333;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 15px;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .product-details {
            flex: 1;
            margin-right: 20px;
        }

        #back-to-shopping {
            margin-top: 20px;
            text-align: right;
        }
    </style>
</head>
<body>

    <div id="success-message">
        <h1>Thank you for your purchase, <?php echo htmlspecialchars($user["name"]); ?>!</h1>
        
        <?php if (!empty($cart)): ?>
            <h2>Receipt</h2>
            <ul>
                <?php foreach ($cart as $productId => $quantity): ?>
                    <?php
                    $product = array_filter($products, function ($p) use ($productId) {
                        return $p["id"] == $productId;
                    });

                    $product = reset($product);
                    ?>
                    <li>
                        <div class="product-details">
                            <p><?php echo htmlspecialchars($product["productName"]); ?></p>
                            <p>Price: ₱<?php echo number_format($product["productPrice"], 2); ?></p>
                            <p>Quantity: <?php echo $quantity; ?></p>
                        </div>
                        <p>Subtotal: ₱<?php echo number_format($product["productPrice"] * $quantity, 2); ?></p>
                    </li>
                <?php endforeach; ?>

                <li>
                    <p>Total: ₱<?php echo number_format($total, 2); ?></p>
                </li>
            </ul>
        <?php endif; ?>

        <div id="back-to-shopping">
            <a href="index.php">Back to Shopping</a>
        </div>
    </div>
</body>
</html>

<?php
function calculateTotal($cart, $products) {
    $total = 0;

    foreach ($cart as $productId => $quantity) {
        $product = array_filter($products, function ($p) use ($productId) {
            return $p["id"] == $productId;
        });

        $product = reset($product);

        $total += $product["productPrice"] * $quantity;
    }

    return $total;
}
?>
