<?php 
    session_start();
    $mysqli = require __DIR__ . "/database.php";

    $is_password_updated = false;

    

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $user_id = $_SESSION["user_id"];
    
        // Change Password
        $current_password = $_POST["current_password"];
        $new_password = $_POST["new_password"];
        $confirm_password = $_POST["confirm_password"];

        $result = $mysqli->query("SELECT * FROM user WHERE id = $user_id");
        $user = $result->fetch_assoc();

        // Verify current password
    if (password_verify($current_password, $user["password_hash"])) {
        // Validate new password and confirm password
        if ($new_password === $confirm_password) {
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
            $mysqli->query("UPDATE user SET password_hash = '$hashed_new_password' WHERE id = $user_id");
            $is_password_updated = true;
        } else {
            $password_error_message = "New password and confirm password do not match.";
        }
    } else {
        $password_error_message = "Current password is incorrect.";
    }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account settings</title>

    <style>
        body {
            margin: 0;
            background-color: #f4f4f4;
        }

        *{
            font-family: poppins;
            color: #40596b;
        }

        .whole-container{
            margin-left: 420px;
            margin-top: 80px;
        }

        .account-setting-container{
            position: absolute;
            width: 700px;
            height: 500px;
            background-color: white;
            box-shadow: 0px 2px 3px 0px rgba(187, 187, 187, 0.5);
        }

        .account-setting-sidebar{
            position: absolute;
            width: 200px;
            height: 500px;
            background-color: white;
            box-shadow: 3px 2px 3px 0px rgba(187, 187, 187, 0.5);
            font-weight: 400;
            text-align: justify;
        }

        .text-position{
            margin-left: 30px;
            margin-top: 50px;
        }

        #changepassword{
            font-weight: 600;
        }

        .profile{
            margin-left: 280px;
            margin-top: 40px
        }

        .account-setting-form{
            margin-left: 300px;
            margin-top: 30px;
        }

        .currentpassword{
            height: 35px;
            width: 300px;
            background: #dedede;
            border:none;
            border-radius:8px;
        }

        .newpassword{
            height: 35px;
            width: 300px;
            background: #dedede;
            border:none;
            border-radius:8px;
            margin-top: 40px;
        }

        .confirmpassword{
            margin-top: 45px;
            height: 35px;
            width: 300px;
            background: #dedede;
            border:none;
            border-radius:8px;
        }

        .btnsave{
            margin-left: 80px;
            margin-top: 30px;
            border: none;
            background-color: #f89819;
            color: white;
            font-weight: 500;
            padding: 6px;
            border-radius: 8px;
        }

        .text-photo{
            margin-left: 390px;
            margin-top: -50px;
            font-size: smaller;
        }

        a{
            text-decoration: none;
        }

        label{
            font-weight: 500;
        }
        
        .lblcurrentpassword{
            position: absolute;
            margin-top: -20px;
            font-size: small;
        }

        .lblnewpassword{
            position: absolute;
            margin-top: 20px;
            font-size: small;
        }

        .lblnconfirmpassword{
            position: absolute;
            margin-top: 25px;
            font-size: small;
        }

        input::placeholder {
        font-size: 12px; /* Adjust the size as needed */
        }

        .back-arrow{
            margin-left: 30px;
            margin-top: 25px;
        }

        h2{
            margin-top: 10px;
        }

        .top-area{
            margin-top: 30px;
            margin-left: 305px;
        }

        .padlock{
            margin-left: 105px;
        }

    </style>
</head>
<body>

    <div class="whole-container">
        <h1>Admin Account Settings</h1>

        <div class="account-setting-container">
        
            <div class="account-setting-sidebar">
                <a href="category-management.php"><img class="back-arrow" src=".\\imagesfinal\back-arrow.png" alt="" height="20px"></a> 
                <div class="text-position">
                    <a href="admin-account-settings.php"><p id="editprofile">Edit Profile</p></a> 
                    <a href="admin-change-password.php"><p id="changepassword">Change Password</p></a> 
                </div>
                
            </div>

            <div class="top-area">
                <img class="padlock" src=".\\imagesfinal\padlock.png" alt="" height="60px">
                
            </div>
            
            <div class="account-setting-form">
                <?php if (isset($password_error_message)): ?>
                <p class="error" style="color: red; font-size: smaller;"><?= $password_error_message ?></p>
                <?php elseif ($is_password_updated): ?>
                <script>alert('Password updated successfully!')</script>
                <?php endif; ?> <br>
                <form action="" method="post">
                    <!-- Current Password -->                
                    <label class="lblcurrentpassword" for="current_password">Current Password</label>
                    <input class="currentpassword" type="password" name = "current_password"> <br>

                    <!-- New Password -->
                    <label class="lblnewpassword" for="neW_password">New Password</label>
                    <input class="newpassword" type="password" name = "new_password"> <br> 

                    <!-- Confirm Password -->
                    <label class="lblnconfirmpassword" for="confirm_password">Confirm Password</label>
                    <input class="confirmpassword" type="password" name = "confirm_password"> <br>

                    <input type="submit" class="btnsave" value="Change Password">
                </form>
                                                                    
            </div>

            

            
        </div>
    </div>
    
</body>
</html>