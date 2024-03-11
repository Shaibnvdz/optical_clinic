<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "login_db";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, productName, productImage FROM products";
$result = $conn->query($sql);

$products = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = array(
            'id' => $row['id'],
            'productName' => $row['productName'],
            'productImage' => $row['productImage']
        );
    }
}

$conn->close();

echo json_encode($products);
?>
