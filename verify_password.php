<?php
session_start();
include("config.php");
include("functions.php");

function verifyAdminPassword($conn, $admin_id, $enteredPassword) {
    $query = mysqli_query($conn, "SELECT * FROM admin WHERE admin_id = '$admin_id' LIMIT 1");

    if ($query && mysqli_num_rows($query) > 0) {
        $adminData = mysqli_fetch_assoc($query);
        if ($adminData['password'] === $enteredPassword) {
            return true;
        }
    }

    return false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitPassword"])) {
    $adminPassword = mysqli_real_escape_string($con, $_POST['adminPassword']);
    $admin_id = $_SESSION['admin_id'];

    if (verifyAdminPassword($con, $admin_id, $adminPassword)) {
        // Password is correct, set a session variable to indicate success
        $_SESSION['admin_password_verified'] = true;
        header("Location: customer-design-setting.php?success=1");
        exit();
    } else {
        // Incorrect password, set a session variable to indicate failure
        $_SESSION['admin_password_verified'] = false;
        header("Location: adminSettings.php?error=1");
        exit();
    }
}
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Admin Settings</title>
        
        <script>
            // Function to show an alert based on URL parameters
            function showAlert() {
                var urlParams = new URLSearchParams(window.location.search);
                if (urlParams.get('success') === '1') {
                    alert('Admin password verified!.');
                }
            }

            // Call the showAlert function when the page is loaded
            window.onload = showAlert;
        </script>
        <link rel="website icon" type="png" href="pictures/icon.png">
    </head>
   

    <body><br><br><br><br>
        <div class="form-container">
            <h2>ADMIN PASSWORD VERIFICATION</h2>
            <form method="post">

                <input type="password" id="adminPassword" name="adminPassword" required>
                <button type="submit" name="submitPassword">Submit</button>
            </form>
        </div>
    </body>

    </html>
