<?php
// checkout.php

// Include PHPMailer for sending emails
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
include("navbar.php");
require 'config.php';

session_start();
// Check if the user is logged in
if (empty($_SESSION["user_id"])) {
    echo "<script>alert('Please log in first.'); window.location.href='login.php'</script>";
}

// Retrieve selected cart items from the database based on the user's ID
$userID = $_SESSION["user_id"];
$checkoutItemsQuery = "SELECT * FROM cart WHERE userID = '$userID' AND ProductID IN (" . $_SESSION['checkoutlist'] . ")";
$checkoutItemsResult = mysqli_query($conn, $checkoutItemsQuery);

if (!$checkoutItemsResult) {
    die("Error in SQL query: " . mysqli_error($conn));
}

// Get the total amount
$totalAmount = 0;
while ($checkoutItem = mysqli_fetch_assoc($checkoutItemsResult)) {
    $totalAmount += $checkoutItem['Price'] * $checkoutItem['Quantity'];
}

if (isset($_POST['checkout'])) {

    if($totalAmount == $_POST['payment']){
        $randomCode = rand(100000, 999999);

        mysqli_data_seek($checkoutItemsResult, 0);

        // Save transaction details for email content
        $transactionDetails = "";

        while ($checkoutItem = mysqli_fetch_assoc($checkoutItemsResult)) {
            // Insert the order into the database
            $insertOrderQuery = "INSERT INTO payment_history (transactionID, orderDate,	time, product_name,	price, quantity,	total_amount,	user_id, transactionOrigin) 
            VALUES ('$randomCode', CURDATE(), CURTIME(), '$checkoutItem[ProductName]', '$checkoutItem[Price]', '$checkoutItem[Quantity]', '$totalAmount', '$userID', 'Online Purchase' )";
            mysqli_query($conn, $insertOrderQuery);

            $update_query = "UPDATE addproduct SET quantity = quantity - $checkoutItem[Quantity] WHERE id IN (" . $_SESSION['checkoutlist'] . ")";
            mysqli_query($conn, $update_query);

            $delete_query = "DELETE FROM cart WHERE userID = '$userID' AND ProductID IN (" . $_SESSION['checkoutlist'] . ")";
            mysqli_query($conn, $delete_query);

            // Build transaction details for email
            $transactionDetails .= "Product: {$checkoutItem['ProductName']}, Quantity: {$checkoutItem['Quantity']}, Price: ₱{$checkoutItem['Price']}.00\n";
        }

        // Get user email
        $userEmailResult = mysqli_query($conn, "SELECT * FROM user WHERE id = $_SESSION[user_id]");
        $userEmailRow = mysqli_fetch_assoc($userEmailResult);
        $userEmail = $userEmailRow['email'];

        // Send email to the user using PHPMailer with SMTP
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();  // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'optimalopticsclinic@gmail.com';  // SMTP username
            $mail->Password = 'lzakfapcaxpyncbw';  // SMTP password
            $mail->SMTPSecure = 'tls';  // Enable encryption, 'ssl' also accepted
            $mail->Port = 587;  // TCP port to connect to

            $mail->setFrom('optimalopticsclinic@gmail.com', 'Admin');  // Replace with your information
            $mail->addAddress($userEmail);  // Add the user's email
            $mail->Subject = 'Thank you for your purchase!';
            $mail->Body = "Your recent purchase details:\n\nTransaction ID: $randomCode\n\n$transactionDetails\nTotal Amount: ₱$totalAmount.00";

            $mail->send();
            $totalAmount = 0;
            echo "<script>alert('Checkout Successfully'); window.location.href='receipt.php'</script>";
            exit;
        } catch (Exception $e) {
            echo "Error sending email: " . $mail->ErrorInfo;
        }
    } else {            
        echo "<script>alert('Payment is not enough'); window.location.href='checkout.php'</script>";
    }        
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <!-- Add your stylesheets and other head elements here -->

    <style>
        body {
            font-family: poppins;
            background-color: #f4f4f4;
            
        }

        .checkout-container {
            margin-top: 70px;
            margin-left: 145px;
            padding: 20px;
            width: 80%;
            max-width: 800px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /*max-height: 530px;
            max-width: 780px;
            overflow-y: auto;
            background-color: white;*/
        }

        h1 {
            text-align: center;
            color: #f89819;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        img {
            max-width: 50px;
            max-height: 50px;
            margin-right: 10px;
        }

        .checkout-item {
            display: flex;
            align-items: center;
        }

        .total-container {
            position: absolute;
            margin-top: -50px;
            text-align: center;
            margin-left: 900px;
            background-color: white;
            padding: 15px;
            box-shadow: 0px 2px 3px 0px rgba(187, 187, 187, 0.5);
            border-radius: 8px;
        }

        .payment-input {
            padding: 8px;
            margin-top: 0px;
            box-sizing: border-box;
        }

        .checkout-btn {
            border-radius: 5px;
            border: none;
            color: white !important;
            background-color: #f89819;
            font-weight: 600;
            height: 40px;
            width: 90px;
            text-transform: uppercase;
            margin-left: 10px;
            margin-top: 30px;
        }

        .total-text{
            font-size: large;
            font-weight: 600;
        }

    </style>
</head>

<body>
    <!-- Checkout Container -->
    <div class="checkout-container">
        <h1>CHECKOUT</h1>
        <table>
            <form method="post">

                <?php
                // Display checkout items
                mysqli_data_seek($checkoutItemsResult, 0);
                while ($checkoutItems = mysqli_fetch_assoc($checkoutItemsResult)) {
                    echo "<tr>";
                    echo "<div class='checkout-item'>";
                    echo "   <td><img src='uploadedphoto/{$checkoutItems['Image']}' alt='{$checkoutItems['ProductName']}' height='50' width='50' /> </td>";
                    echo "   <td><span>{$checkoutItems['ProductName']}</span> </td>";
                    echo "   <td><span>Price: &nbsp ₱{$checkoutItems['Price']}.00</span> </td>";                    
                    echo "</div>";
                    echo "</tr>";
                }

                echo"<div class='total-container'>";
                echo "<span class='total-text'>Total Amount:  &nbsp  ₱$totalAmount.00 </span>";
                echo "<br>";
                echo "&nbsp &nbsp<input class='payment-input' type='text' name='payment'>";
                echo "<input type='submit' value='Checkout' name ='checkout' class='checkout-btn'>";
                echo"</div>";
                ?>
                
            </form>
        </table>
        

        
