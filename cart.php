<?php
// cart.php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include("navbar.php");
require 'config.php';

session_start();
// Check if the user is logged in
if (empty($_SESSION["user_id"])) {
    echo "<script>alert('Please log in first.'); window.location.href='login.php'</script>";
}

// Retrieve cart items from the database based on the user's email
$userEmail = $_SESSION["user_id"];
$cartItemsQuery = "SELECT * FROM cart WHERE userID = '$userEmail'";
$cartItemsResult = mysqli_query($conn, $cartItemsQuery);

if (!$cartItemsResult) {
    die("Error in SQL query: " . mysqli_error($conn));
}

if (isset($_POST['checkout'])) {
    if (isset($_POST['selected']) && !empty($_POST['selected'])) {
        $_SESSION['checkoutlist'] = implode(', ', $_POST['selected']);
        echo "<script> window.location.href='checkout.php'</script>";
    } else {
        echo "<script>alert('Please select items to checkout'); window.location.href='cart.php'</script>";
    }
}


if (isset($_POST['remove'])) {
    // Check if items are selected for removal
    if (isset($_POST['selected']) && !empty($_POST['selected'])) {
        $selectedItems = implode(', ', $_POST['selected']);

        // Display confirmation dialog
        echo "<script>
                var userConfirmation = confirm('Are you sure you want to remove selected items?');
                if (userConfirmation) {
                    window.location.href='cart.php?removeItems=$selectedItems';
                } else {
                    // Redirect back to cart.php without removing items
                    window.location.href='cart.php';
                }
              </script>";
        exit; // Ensure the script stops here to prevent further execution
    } else {
        echo "<script>alert('Please select items to remove'); window.location.href='cart.php'</script>";
    }
}

// Process removal after confirmation
if (isset($_GET['removeItems'])) {
    $selectedItems = $_GET['removeItems'];
    mysqli_query($conn, "DELETE FROM cart WHERE ProductID IN ($selectedItems)");
    echo "<script> window.location.href='cart.php'</script>";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <!-- Add your stylesheets and other head elements here -->

    <style>
        body{
            margin: 0;
            font-family: poppins;
        }

        .cart-container {
            margin-left: 370px;
            margin-top: 100px;
            max-height: 530px;
            max-width: 780px;
            overflow-y: auto;
            background-color: white;
            padding: 10px;
            box-shadow: 0px 2px 3px 0px rgba(187, 187, 187, 0.5);
        }

        .btn-checkout{
                border-radius: 5px;
                border: none;
                color: white !important;
                background-color: #f89819;
                font-weight: 600;
                height:30px ;
                width: 90px;
                text-transform: uppercase;
                margin-left: 540px;
                margin-top: -68px;
            }

            .remove-btn{
                margin-left: 15px;
                border-radius: 5px;
                border: none;
                color: white !important;
                background-color: #40596b;
                font-weight: 600;
                height:30px ;
                width: 90px;
                text-transform: uppercase;
                margin-left:653px;
                margin-top: -68px;
            }

            h1{
                margin-left: 15px;
                color: #f89819;
            }

            hr{
                border-style: none;
                border: 1px solid #d4d4d4;
            }

            table{
                margin-left: 65px;
            }

    </style>
</head>

<body>
    <!-- Shopping Cart Container -->
    <div class="cart-container">
        <h1>Shopping Cart</h1>
        <hr>
        <table cellspacing="10">
        <form method="post">

        
            <?php
            // Display cart items
            while ($cartItem = mysqli_fetch_assoc($cartItemsResult)) {
                  echo "<div class='cart-item'>";
                  echo "<tr style='box-shadow: 0px 2px 3px 0px rgba(187, 187, 187, 0.5);'>";
                  echo "<td><input type='checkbox' name='selected[]' value='{$cartItem['ProductID']}'></td>";
                  echo "   <td><img src='uploadedphoto/{$cartItem['Image']}' alt='{$cartItem['ProductName']}' height='50' width='50' /> </td>";
                  echo "   <td><span>{$cartItem['ProductName']}</span> </td>";
                  echo "   <td><span>Quantity: <input type='number' name='quantity' value='{$cartItem['Quantity']}' min='1'></span> </td>";
                  echo "   <td><span>Price: &nbsp ₱{$cartItem['Price']}.00</span > </td>";
                  echo "<td></td>";
                  echo "</tr>";
                  echo "</div>";
            }

            ?>
            <input type='submit' value='Checkout' name ='checkout' class='btn-checkout'>
            <button class='remove-btn' type='submit' name='remove' value='<?php echo $cartItem['ProductID']; ?>'>Remove</button>
        </form>
        </table>
    </div>
    <!-- Add your additional HTML content and scripts here -->
</body>

</html>
