<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "login_db";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['productId'])) {
    $productId = $_POST['productId'];

    $sql = "SELECT productName, productImage FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $stmt->bind_result($productName, $productImage);
        $stmt->fetch();

        $productDetails = [
            'productName' => $productName,
            'productImage' => $productImage,
        ];

        echo json_encode($productDetails);

        $stmt->close();
    } else {
        echo "Error in prepared statement: " . $conn->error;
    }
} else {
    echo "Product ID not provided.";
}

$conn->close();
?>
