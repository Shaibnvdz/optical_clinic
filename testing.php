<?php
include("config.php");

session_start();

// Check if the user is logged in
//if (!isset($_SESSION['email'])) {
    // Redirect to the login page or handle the case when the user is not logged in
    //header("Location: login.php");
    //exit;
//}

$email = $_SESSION['user_id'];

// Fetch user information from the database
    $query = "SELECT * FROM user WHERE e_address = '$email'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        // Handle the query error
        die("Database query failed.");
    }

    $userInfo = mysqli_fetch_assoc($result);

    // Update session variables with the user information, including the profile image path
    $_SESSION['fname'] = $userInfo['name'];
    $_SESSION['phoneNumber'] = $userInfo['phone_number'];
    $_SESSION['address'] = $userInfo['e_address'];
    $_SESSION['profileImage'] = $userInfo['profileImage'];


if (isset($_POST['uploadImg'])) {
    // Check if a file was selected
    if ($_FILES['profileImage']['name']) {
        $target_dir = "upload/";
        $target_file = $target_dir . basename($_FILES['profileImage']['name']);

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $target_file)) {
            // Update the database with the file path
            $updateImageQuery = "UPDATE user SET profileImage='$target_file' WHERE emailAddress='$email'";
            $updateImageResult = mysqli_query($con, $updateImageQuery);

            if (!$updateImageResult) {
                // Handle the update error
                die("Failed to update profile image. Error: " . mysqli_error($con));
            }

            // Update the session variable with the new profile image path
            $_SESSION['profileImage'] = $target_file;


            // Display a success message using JavaScript
            echo "<script>alert('Profile Image Uploaded Successfully!'); window.location.href='AccountSettings.php';</script>";
            exit;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }

    }
}



// Check if the form is submitted for saving changes
if (isset($_POST['save'])) {
    // Process the form data and update the database
    $firstName = $_POST['firstName'];
    $phone = $_POST['phoneNumber'];
    $address = $_POST['address'];

    // Update the user information in the database
    $updateQuery = "UPDATE customer_info SET firstName='$firstName', lastName='$lastName', phoneNumber='$phone', address='$address' WHERE emailAddress='$email'";
    $updateResult = mysqli_query($con, $updateQuery);

    if (!$updateResult) {
        // Handle the update error
        die("Failed to update user information. Error: " . mysqli_error($con));
    }

    // Fetch the updated user information
    $query = "SELECT * FROM user WHERE emailAddress = '$email'";
    $result = mysqli_query($con, $query);

    if (!$result) {
        // Handle the query error
        die("Database query failed.");
    }

    $userInfo = mysqli_fetch_assoc($result);

    // Update session variables with the new user information
    $_SESSION['fname'] = $userInfo['firstName'];
    $_SESSION['phoneNumber'] = $userInfo['phoneNumber'];
    $_SESSION['address'] = $userInfo['address'];

    // Redirect to the account settings page or any other page
    echo "<script>alert('Account Information Saved!'); window.location.href='account-settings.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testing</title>
</head>
<body>
<div class="accountSettingsConFields">
    <form method="post" action="">
        <label for="firstName" >First Name:</label>
        <input type="text" class="firstName" name="firstName" value="<?php echo $userInfo['firstName']; ?>" <?php echo isset($_POST['edit']) ? '' : 'readonly'; ?>><br> 

        <label for="emailAddress">Email Address:</label>
        <input type="text" class="emailAddress" name="emailAddress" value="<?php echo $userInfo['emailAddress']; ?>" readonly><br>

        <label for="phone">Phone Number:</label>
        <input type="text" class="phoneNumber" name="phoneNumber" value="<?php echo isset($userInfo['phoneNumber']) ? $userInfo['phoneNumber'] : ''; ?>" <?php echo isset($_POST['edit']) ? '' : 'readonly'; ?>><br>

        <label for="address">Address:</label>
        <input type="text" class="address" name="address" value="<?php echo $userInfo['address']; ?>" <?php echo isset($_POST['edit']) ? '' : 'readonly'; ?>><br>

        <?php if (isset($_POST['edit'])): ?>
            <input type="submit" name="save" value="Save">
        <?php else: ?>
            <input type="submit" name="edit" value="Edit">
        <?php endif; ?>
    </form>
    </div>
</body>
</html>