<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

$mysqli = require __DIR__ . "/database.php";

// Fetch hashed password from the database
$sql = "SELECT password_hash FROM user WHERE id = $user_id";
$result = $mysqli->query($sql);

// Check if user data is found
if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submitPassword"])) {
        // Get the entered password from the form
        $enteredPassword = $_POST['adminPassword'];

        // Verify the entered password against the stored hashed password
        $isValidPassword = password_verify($enteredPassword, $user['password_hash']);

        // Display an alert based on the validation result
        echo '<script>';
        if ($isValidPassword) {
            echo 'alert("Password matches!"), window.location.href="customer_page.php";';
        } else {
            echo 'alert("Password does not match!");';
        }
        echo '</script>';
    }
} else {
    // User data not found, return failure
    echo json_encode(['success' => false]);
    exit; // Stop further execution
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Pass</title>
    <style>
        body {
            margin:0;
            color: #40596b;

        }

        *{
            font-family: poppins;
        }

        .bgphoto {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover; /* This property maintains the aspect ratio while covering the entire viewport */
        }

        .btnsubmit{
            position: absolute;
            background-color: #f89819;
            border: none;
            width: 180px;
            height: 40px;
            border-radius: 8px;
            text-transform: uppercase;
            font-weight: 600;
            font-size: 23px;
            margin-left: 90px;
            margin-top: 200px;
            color: white;
            
        }

        .admin-pass-container{
            position: absolute;
            margin-left: 590px;
            margin-top: 200px;
        }

        .text-admin{
            position: absolute;
            margin-left: 50px;
            width: 300px;
            color: white;
        }

        .paragraph-adminpass{
            position: absolute;
            margin-top: 70px;
            margin-left: 70px;
            width: 300px;
            color: white;
        }

        input[type="password"]{
            position: absolute;
            margin-top: 130px;
            margin-left: 0px;
            border-radius: 8px;
            height: 45px;
            outline: #40596b;
            padding: 0 10px 0 45px;
            border: none;
            border-radius: 40px;
            width: 300px;
            color: #40596b !important;
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
        }

        .linkback{
            position: absolute;
            color: white;
            margin-left: 165px;
            margin-top: 280px;
            text-decoration: none;
        }
    </style>
</head>
<body>
<img class="bgphoto" src=".\\imagesfinal\bgphotowcolor1.jpg" alt="">
    <div class="admin-pass-container">
        <h1 class="text-admin">Admin Password</h1>
        <p class="paragraph-adminpass">Please enter admin password.</p>
    <form method="post">
        <input type="password" id="adminPassword" name="adminPassword" required> <br>
        <button class="btnsubmit" type="submit" name="submitPassword">Proceed</button>
        <a class="linkback" href="category-management.php">Back</a>
    </form>
    </div>
    
</body>
</html>
