<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "opticaldb";

    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Initialize arrays to store the changed values and corresponding column names
    $changedValues = [];
    $columnTypes = "";
    $columnValues = [];

    // Get user inputs
    $fontColor = isset($_POST["font"]) ? $_POST["font"] : "";
    $bgColor = isset($_POST["background"]) ? $_POST["background"] : "";

    // Handle font color and background color changes
    if (!empty($fontColor)) {
        $changedValues[] = "`font` = ?";
        $columnTypes .= "s";
        $columnValues[] = $fontColor;
    }

    if (!empty($bgColor)) {
        $changedValues[] = "`background` = ?";
        $columnTypes .= "s";
        $columnValues[] = $bgColor;
    }

    // Handle file uploads and changes for logo, ads1, ads2, and ads3
    function handleFileUpload($fieldName, $columnName, $columnType, &$changedValues, &$columnTypes, &$columnValues, $conn) {
        $uploadDir = "uploadedphoto/";
        $targetFile = $uploadDir . basename($_FILES[$fieldName]["name"]);

        // Check if the file is set and not empty
        if (isset($_FILES[$fieldName]) && !empty($_FILES[$fieldName]["name"])) {
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Check if the file is an actual image
            if (getimagesize($_FILES[$fieldName]["tmp_name"]) === false) {
                echo "Error: File is not an image.";
                return false;
            }

            // Check file size (adjust the limit as needed)
            if ($_FILES[$fieldName]["size"] > 5000000) {
                
                echo '<script>alert("Error: File is too large."); window.location.href = "customer_page.php";</script>';
                return false;
            }

            // Allow only certain file formats
            $allowedFormats = ["jpg", "jpeg", "png", "gif"];
            if (!in_array($imageFileType, $allowedFormats)) {
                echo '<script>alert("Error: Only JPG, JPEG, PNG, and GIF files are allowed."); window.location.href = "customer_page.php";</script>';
                return false;
            }

            // Move the uploaded file to the designated directory
            if (move_uploaded_file($_FILES[$fieldName]["tmp_name"], $targetFile)) {
                $changedValues[] = "`$columnName` = ?";
                $columnTypes .= $columnType;
                $columnValues[] = $targetFile;
        
                return true;
            } else {
                echo "Error: Unable to move the file.";
                return false;
            }
        }

        return null; // Return null if the file is not set or empty
    }

    // Handle file uploads and changes for logo, ads1, ads2, and ads3
    handleFileUpload("logo", "logo", "s", $changedValues, $columnTypes, $columnValues, $conn);
    handleFileUpload("ads1", "ads1", "s", $changedValues, $columnTypes, $columnValues, $conn);
    handleFileUpload("ads2", "ads2", "s", $changedValues, $columnTypes, $columnValues, $conn);
    handleFileUpload("ads3", "ads3", "s", $changedValues, $columnTypes, $columnValues, $conn);

    // Check if any values were changed
    if (!empty($changedValues)) {
        // Construct the dynamic part of the SQL query
        $setClause = implode(', ', $changedValues);

        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("UPDATE `design` SET $setClause WHERE `id` = 1");

        // Bind parameters
        if (!empty($columnTypes)) {
            $stmt->bind_param($columnTypes, ...$columnValues);
        }

        // Execute the statement
        $stmt->execute();
        $stmt->close();

        // Close the database connection
        $conn->close();

        // Display success message
        echo '<script>alert("Successfully Changed."); window.location.href = "customer_page.php";</script>';
    } else {
        echo '<script>alert("No changes were made."); window.location.href = "customer_page.php";</script>';
    }
}
?>
