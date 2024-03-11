<?php
// block-customer.php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Assuming you have a database connection in $mysqli
    $mysqli = require __DIR__ . "/database.php";

    // Get user ID from the form submission
    $user_id = $_POST["user_id"];

    // Update user status to 'blocked' in the database
    $update_query = "UPDATE user SET is_blocked = 1 WHERE id = ?";
    $update_stmt = $mysqli->prepare($update_query);
    $update_stmt->bind_param("i", $user_id);

    if ($update_stmt->execute()) {
        echo "<script>alert('User blocked successfully.'); window.location.href='manage-account.php';</script>";
        exit;
    } else {
        echo "Error blocking user: " . $update_stmt->error;
    }

    $mysqli->close();
} else {
    echo "Invalid request method.";
}
?>
