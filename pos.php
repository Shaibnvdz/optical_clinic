<?php
// Function to calculate total
function calculateTotal($cart, $products) {
    $total = 0;

    foreach ($cart as $productId => $quantity) {
        $product = array_filter($products, function ($p) use ($productId) {
            return $p["id"] == $productId;
        });

        $product = reset($product);

        if ($product) {
            $total += $product["price"] * $quantity;
        }
    }

    return $total;
}

session_start();
include('admin-sidebar.php');
$mysqli = require __DIR__ . "/database.php";

// Fetch user data from the database
$sql = "SELECT * FROM user WHERE id = {$_SESSION["user_id"]}";
$result = $mysqli->query($sql);
$user = $result->fetch_assoc();

// Fetch products from the database
$sql = "SELECT * FROM addproduct";
$result = $mysqli->query($sql);

// Check if the query result is a boolean or empty
if (!$result || $result->num_rows === 0) {
    // Handle the case where the query failed or returned no results
    $products = [];
} else {
    // Fetch the data if the query was successful
    $products = $result->fetch_all(MYSQLI_ASSOC);
}

// Fetch unique product categories for the filter dropdown
$sql = "SELECT DISTINCT category FROM addproduct";
$categoryResult = $mysqli->query($sql);

// Check if the query result is a boolean or empty
if (!$categoryResult || $categoryResult->num_rows === 0) {
    // Handle the case where the query failed or returned no results
    $categories = [];
} else {
    // Fetch the data if the query was successful
    $categories = $categoryResult->fetch_all(MYSQLI_ASSOC);
}

// Fetch the category filter from the URL
$filterCategory = isset($_GET['category']) ? $_GET['category'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Point of Sale</title>
    <link rel="stylesheet" href="admin.css">
    <style>
        body {
            font-family: poppins;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        #product-list {
            width: 38%;
            box-sizing: border-box;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            left: 320px;
            position: absolute;
            top: 20px;
        }
        #shopping-cart{
            width: 38%;
            box-sizing: border-box;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: absolute;
            left: 920px;
            top: 20px;
        }
        h1, h2 {
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

        img {
            max-width: 100px;
            max-height: 100px;
            margin-right: 20px;
            border-radius: 5px;
        }

        form {
            display: inline-block;
        }

        h2 {
            margin-top: 20px;
        }

        p {
            margin-top: 20px;
        }

        a {
            text-decoration: none;
        }

        #total {
            margin-top: 20px;
            text-align: right;
        }

        #logout-link {
            margin-top: 20px;
        }

        input{
            border-radius: 5px;
                border: none;
                color: white !important;
                background-color: #f89819;
                font-weight: 600;
                height:30px ;
                text-transform: uppercase;
                margin-left: 15px;
                font-size: small;
        }

        #pos{
            background-color: #f4f4f4;
                font-weight: 600;
        }

        
    </style>
</head>
<body>

    <div id="product-list">
        <h2>Product List</h2>
        <div>
            <label for="category-filter">Filter by Category:</label>
            <select id="category-filter" onchange="filterProducts(this.value)">
                <option value="">All Categories</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['category']; ?>" <?php echo ($filterCategory == $category['category']) ? 'selected' : ''; ?>>
                        <?php echo $category['category']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <ul>
            <?php
            foreach ($products as $product):
                // Apply category filter
                if (!$filterCategory || $product['category'] == $filterCategory):
            ?>
                    <li>
                        <img src="uploadedphoto/<?php echo $product["image"]; ?>" alt="Product Image">
                        <div>
                            <p><?php echo htmlspecialchars($product["name"]); ?></p>
                            <p>₱<?php echo number_format($product["price"], 2); ?></p>
                        </div>
                        <form action="addToCart.php" method="post">
                            <input type="hidden" name="product_id" value="<?php echo $product["id"]; ?>">
                            <input type="submit" value="Add to Cart">
                        </form>
                    </li>
            <?php
                endif;
            endforeach;
            ?>
        </ul>
    </div>

    <div id="shopping-cart">
        <h2>Shopping Cart</h2>
        <ul>
            <?php
            $cart = isset($_SESSION["cart"]) ? $_SESSION["cart"] : [];

            foreach ($cart as $productId => $quantity):
                $product = array_filter($products, function ($p) use ($productId) {
                    return $p["id"] == $productId;
                });

                $product = reset($product);

                // Check if the product exists before displaying
                if ($product):
            ?>
                    <li>
                        <img src="uploadedphoto/<?php echo $product["image"]; ?>" alt="Product Image">
                        <div>
                            <p><?php echo htmlspecialchars($product["name"]); ?></p>
                            <p>₱<?php echo number_format($product["price"], 2); ?></p>
                            <p>Quantity: <?php echo $quantity; ?></p>
                        </div>
                        <form action="removeFromCart.php" method="post">
                            <input type="hidden" name="product_id" value="<?php echo $product["id"]; ?>">
                            <input type="submit" value="Remove from Cart">
                        </form>
                    </li>
            <?php
                endif;
            endforeach;
            ?>
        </ul>

        <div id="total">
            <h2>Total: ₱<?php echo number_format(calculateTotal($cart, $products), 2); ?></h2>
            <form action="checkout1.php" method="post">
                <input id="checkout-btn" type="submit" value="Checkout">
            </form>
        </div>
    </div>

    <script>
        function filterProducts(category) {
            window.location.href = "pos.php" + (category ? "?category=" + category : "");
        }
    </script>
</body>
</html>