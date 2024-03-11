<?php
session_start();
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

// Fetch user data from the database
$sql = "SELECT * FROM user WHERE id = {$_SESSION["user_id"]}";
$result = $mysqli->query($sql);
$user = $result->fetch_assoc();

// Fetch products from the database
$sql = "SELECT * FROM addproduct";
$result = $mysqli->query($sql);
$products = $result->fetch_all(MYSQLI_ASSOC);

// Retrieve cart data
$cart = isset($_SESSION["cart"]) ? $_SESSION["cart"] : [];

// Calculate total
$total = calculateTotal($cart, $products);

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
    <title>Checkout</title>

    <style>
        body {
            font-family: poppins;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            color:#40596b;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 80%;
            max-width: 800px;
            box-sizing: border-box;
        }

        h1, h2 {
            color: #40596b;;
        }

        .order-summary, .payment-form, .total {
            margin-bottom: 20px;
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

        img {
            max-width: 80px;
            max-height: 80px;
            margin-right: 20px;
            border-radius: 5px;
        }

        .product-details {
            flex-grow: 1;
        }

        .payment-form label {
            display: block;
            margin-bottom: 10px;
        }

        .payment-form input[type="text"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            margin-bottom: 15px;
        }

        .payment-form input[type="submit"] {
            background-color: #f89819;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .total h2 {
            text-align: right;
        }
    </style>
</head>
<body>
        
    <div class="container">
        <h1>Checkout</h1>

        <div class="order-summary">
            <h2>Order Summary</h2>
            <ul>
                <?php foreach ($cart as $productId => $quantity): ?>
                    <?php
                        $product = array_filter($products, function ($p) use ($productId) {
                            return $p["id"] == $productId;
                        });

                        $product = reset($product);
                    ?>
                    <li>
                        <img src="uploadedphoto/<?php echo $product["image"]; ?>" alt="Product Image">
                        <div class="product-details">
                            <p><?php echo htmlspecialchars($product["name"]); ?></p>
                            <p>Price: ₱<?php echo number_format($product["price"], 2); ?></p>
                            <p>Quantity: <?php echo $quantity; ?></p>
                            <p>Total: ₱<?php echo number_format($product["price"] * $quantity, 2); ?></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="payment-form">
            <h2>Payment Information</h2>
            <!-- Peso cash input -->
            <form action="process_payment.php" method="post">
                <label for="cash_amount">Enter Peso Cash Amount:</label>
                <input type="text" id="cash_amount" name="cash_amount" required>
                
                <input style="font-family: poppins; font-weight: bold" type="submit" value="Submit Payment">
            </form>
        </div>

        <div class="total">
            <h2>Total Amount: ₱<?php echo number_format($total, 2); ?></h2>
        </div>
    </div>
</body>
</html>
