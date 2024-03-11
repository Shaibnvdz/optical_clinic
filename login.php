<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $email = $mysqli->real_escape_string($_POST["email"]);
    
    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
                   $email);
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        
        // Check if the account is blocked
        if ($user["is_blocked"] == 1) {
            $is_invalid = true;
            $block_message = "Account is blocked. Contact support for assistance.";
        } else {
            if (password_verify($_POST["password"], $user["password_hash"])) {
                
                session_start();
                
                session_regenerate_id();
                
                $_SESSION["user_id"] = $user["id"];
                
                // Check user type and redirect accordingly
                if ($user["user_type"] === "admin") {
                    header("Location: category-management.php");
                } else {
                    header("Location: index.php");
                }
                exit;
            }
        }
    }
    
    $is_invalid = true;
}

?>

?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <style>
        body {
            margin: 0px;
        }

        *{
            font-family: poppins;
            color: #ffffff;
        }

        .bgphoto {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover; /* This property maintains the aspect ratio while covering the entire viewport */
        }

        .login-form-container{
            position: absolute;
            background: rgba(229, 229, 229, 0.3);
            height: 500px;
            width: 500px;
            margin-left: 490px;
            border-radius: 10px;
            margin-top: 130px;
        }

        .edit-form-container{
            position: absolute;
            margin-left: 70px;
            margin-top: 120px;
        }

        .donthaveaccount-container{
            position: absolute;
            margin-left: 70px;
            margin-top: 265px;
            font-size: small;
        }

        input[type="email"]{
            border-radius: 8px;
            height: 30px;
            outline: #40596b;
            padding: 0 10px 0 45px;
            border: none;
            border-radius: 40px;
            margin-top: 40px;
            margin-left: 0px;
            width: 350px;
            color: #40596b !important;
        }
            
        .password{
            border-radius: 8px;
            height: 30px;
            outline: #40596b;
            padding: 0 10px 0 45px;
            border: none;
            border-radius: 40px;
            margin-top: 40px;
            margin-left: 0;
            width: 350px;
            color: #40596b !important;
        }
            
        .lblemail{
            position: absolute;
            margin-top: 15px;
        }

        .lblpassword{
            position: absolute;
            margin-top: 15px;
        }

        .btnlogin{
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
            margin-top: 50px;
        }

        .txtlogin{
            position: absolute;
            margin-left: 70px;
            margin-top: 30px;
            font-size: 40px;
        }

        .linksignup{
            text-decoration: none;
            position: absolute;
            margin-left: 8px;
            margin-top: 10px;
            font-size: small;
        }

        .linkresetpass{
            text-decoration: none;
            position: absolute;
            margin-left: 230px;
            margin-top: 10px;
            font-size: small;
        }

        .noneaccount{
            font-size: small;
        }

        
    </style>
</head>
<body>
    <img class="bgphoto" src=".\\imagesfinal\bgphotowcolor1.jpg" alt="">
    <div class="login-form-container">
        <h1 class="txtlogin">Login</h1>
        <div class="edit-form-container">
        <?php if ($is_invalid): ?>
            <em><?= $block_message ?? "Invalid login" ?></em>
        <?php endif; ?>
        
        <form method="post">
            <label class="lblemail" for="email">Email</label> 
            <input type="email" name="email" id="email" placeholder="Enter Email"
                value="<?= htmlspecialchars($_POST["email"] ?? "") ?>"></br>
            
            <label class="lblpassword" for="password">Password</label>
            <input class="password" type="password" name="password" id="password" placeholder="Enter Password" autocomplete="off"> </br>
            
            <a class="linksignup" href="signup.html">Don't have an account?</a>
            <a class="linkresetpass" href="forgot-password.php">Forgot Password?</a>
            <button class="btnlogin">Login</button>
            
        </form>
        </div>        
    </div>
    
    
</body>
</html>
