<?php
// Assuming you have a database connection in $mysqli
$mysqli = require __DIR__ . "/database.php";

// Check if the user_id is provided
if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // Update the user's is_blocked status to unblock
    $update_query = "UPDATE user SET is_blocked = 0 WHERE id = ?";
    $update_stmt = $mysqli->prepare($update_query);

    // Bind parameters
    $update_stmt->bind_param("i", $user_id);

    // Execute the update query
    if ($update_stmt->execute()) {
        // Alert message to be shown after successful unblock
        $alert_message = "User successfully unblocked!";
        echo "<script>alert('$alert_message');</script>";

        // Redirect back to the manage-account page after successful unblock
        header("Location: manage-account.php");
        exit();
    } else {
        // Handle the case where the update fails
        echo "Error updating user status: " . $update_stmt->error;
    }

    $update_stmt->close();
}

$mysqli->close();
?>
