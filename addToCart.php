<?php
session_start();

if (isset($_POST["product_id"])) {
    $productId = $_POST["product_id"];

    if (!isset($_SESSION["cart"][$productId])) {
        $_SESSION["cart"][$productId] = 1;
    } else {
        $_SESSION["cart"][$productId]++;
    }
}

header("Location: pos.php");
exit;
?>
