<?php
session_start();

if (isset($_POST["product_id"])) {
    $productId = $_POST["product_id"];

    if (isset($_SESSION["cart"][$productId])) {
        if ($_SESSION["cart"][$productId] > 1) {
            $_SESSION["cart"][$productId]--;
        } else {
            unset($_SESSION["cart"][$productId]);
        }
    }
}

header("Location: pos.php");
exit;
?>
