<?php

$token = $_GET["token"];

$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT * FROM user
        WHERE reset_token_hash = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null) {
    die("token not found");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("token has expired");
}

?>
<!DOCTYPE html>
<html>
<head>
    


    <style>
        body{
            margin: 0;
        }

        *{
            font-family: poppins;
            color: #ffffff;
        }

        .bgphoto{
            position: absolute;
            width: 100%;
            height: 775px;
        }

        .reset-form-container{
            position: absolute;
            background: rgba(229, 229, 229, 0.3);
            height: 500px;
            width: 500px;
            margin-left: 490px;
            border-radius: 10px;
            margin-top: 120px;
        }

        .edit-form-container{
            position: absolute;
            margin-left: 70px;
            margin-top: 170px;
        }

        input{
                border-radius: 8px;
                height: 30px;
                outline: #40596b;
                padding: 0 10px 0 45px;
                border: none;
                border-radius: 40px;
                margin-top: 40px;
                margin-left: 0px;
                width: 300px;
                color: #40596b !important;
            }

        .lblnewpassword{
            position: absolute;
            margin-top: 5px;
        }

        .lblcnewpassword{
            position: absolute;
            margin-top: 5px;
        }

        .btnreset{
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

        .textreset{
            position: absolute;
            margin-left: 70px;
            margin-top: 30px;
            font-size: 40px;
        }
    </style>

    <title>Reset Password</title>
        <meta charset="UTF-8">
        <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
        <script src="validation1.js" defer></script>
</head>
<body>
    <img class="bgphoto" src=".\\imagesfinal\bgphotowcolor1.jpg" alt="">    
    <div class="reset-form-container">
        
        <h1 class="textreset">Reset Password</h1>

        <div class="edit-form-container">
            <form method="post" action="process-reset-password.php">

                    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

                    <label class="lblnewpassword" for="password">New password</label>
                    <input class="newpassword" type="password" id="password" name="password"><br>

                    <label class="lblcnewpassword" for="password_confirmation">Repeat password</label>
                    <input class="confirmpassword" type="password" id="password_confirmation"
                        name="password_confirmation"> <br>

                <button class="btnreset">Send</button>
                </form>
        </div>
        
    </div>
    

</body>
</html>