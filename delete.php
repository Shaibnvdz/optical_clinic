<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Product</title>
</head>
<body>
    <h3>Confirm Deletion</h3>
    <form id="deleteForm" action="delete_logic.php" method="POST">
        <input type="hidden" name="ids" value="<?php echo implode(",", $_GET['ids']); ?>">
        <p>Are you sure you want to delete? Items you delete can't be restored.</p>
        <button type="submit">Delete</button>
        <button type="button" onclick="cancelDelete()">Cancel</button>

        <script>
            function cancelDelete() {
                // Redirect back to addproduct.php
                window.location.href = 'addproduct.php';
            }
        </script>
    </form>
</body>
</html>
