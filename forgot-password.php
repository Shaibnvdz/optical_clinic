<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <meta charset="UTF-8">
    
    <style>
        body {
            margin: 0px;
        }

        *{
            font-family: poppins;
            color: #ffffff;
        }
        
        .forgot-form-container {
            position: absolute;
            margin-left: 425px;
            border-radius: 10px;
            margin-top: 180px;
        }

        .txtforgot{            
            margin-left: 60px;
            margin-top: 30px;
            font-size: 40px;
        }

        .bgphoto{
            position: absolute;
            width: 100%;
            height: 775px;
        }

        .edit-form-container{
            position: absolute;
            margin-left: 140px;
            margin-top: 20px;
        }

        .btnsend{
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

        input[type="email"]{
            border-radius: 8px;
            height: 45px;
            outline: #40596b;
            padding: 0 10px 0 45px;
            border: none;
            border-radius: 40px;
            margin-top: 40px;
            margin-left: 0px;
            width: 300px;
            color: #40596b !important;
        }
    </style>
</head>
<body>
<img class="bgphoto" src=".\\imagesfinal\bgphotowcolor1.jpg" alt="">    

    <div class="forgot-form-container">
        <h1 class="txtforgot">Yo! Forgot Your Password?</h1>
        <p class="paragraph-forgot">No worries! Just enter your email and we will send you a link to reset your password</p>

        <div class="edit-form-container">
            <form method="post" action="send-password-reset.php">

                
                <input type="email" name="email" id="email" placeholder="Enter your email"> </br>

                <button class="btnsend">Send</button>

            </form>
        </div>
        
    </div>
    

</body>
</html>