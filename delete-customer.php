<?php
// delete-customer.php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Assuming you have a database connection in $mysqli
    $mysqli = require __DIR__ . "/database.php";

    // Get user ID from the form submission
    $user_id = $_POST["user_id"];

    // Delete user from the database
    $delete_query = "DELETE FROM user WHERE id = ?";
    $delete_stmt = $mysqli->prepare($delete_query);
    $delete_stmt->bind_param("i", $user_id);

    if ($delete_stmt->execute()) {
        echo "<script>alert('User deleted successfully.'); window.location.href='manage-account.php';</script>";
        exit;
    } else {
        echo "Error deleting user: " . $delete_stmt->error;
    }

    $mysqli->close();
} else {
    echo "Invalid request method.";
}
?>
