<?php
        @include 'config.php';

        session_start();

        if (empty($_SESSION["pImage"])) {
            $_SESSION["pImage"] = 'uploadedphoto/profile1.png';
        }
    
        if (isset($_SESSION["user_id"])) {
            
            $mysqli = require __DIR__ . "/database.php";
            
            $sql = "SELECT * FROM user
                    WHERE id = {$_SESSION["user_id"]}";
                    
            $result = $mysqli->query($sql);
            
            $user = $result->fetch_assoc();

            $sqlI = mysqli_query($conn, "SELECT * FROM user WHERE id = '$_SESSION[user_id]'");
            while($row = mysqli_fetch_assoc($sqlI)){
            $_SESSION['pImage'] = $row['profileImage'];
        }
        }

        
    ?>

<html>
    <head>
        <title></title>
        <style>
                body{
                    margin: 0px;
                    background-color: #f4f4f4;
                }

                *{
                    font-family: poppins;
                    color: #40596b;
                    }

                .anchnav{
                    text-decoration: none;
                    margin-left: 30px;
                    color: #40596b;
                    padding: 5px;    
                }

                .anchnavbtn{
                    text-decoration: none;
                    margin-left: 30px;
                    padding: 5px;
                    color: #40596b;
                    border-radius: 8px;
                }

                .navbar{
                    height: 80px;
                    width: 100%;
                    position: fixed;
                    background-color: rgb(255, 255, 255);
                    box-shadow: 0px 2px 3px 0px rgba(187, 187, 187, 0.5);
                    z-index: 1;
                }

                .links{
                    position: absolute;
                    top: 28px;
                    left: 630px;
                    position: fixed;
                }

                .logo{
                    position: absolute;
                    top: -122px;
                    left: -40px;
                }

                .cart{
                    position: absolute;
                    top: 29px;
                    left: 1330px;
                }

                .heart{
                    position: absolute;
                    top: 29px;
                    left: 1375px;
                }

                .profile{
                    position: absolute;
                    top: 18px;
                    left: 1430px;
                }

                .cont-counter{
                    position: absolute;
                    text-decoration: none;
                    position: absolute;
                    background-color: #f89819;
                    text-align: center;
                    width: 10px;
                    height: 10px;
                    padding: 5px;
                    top: 18px;
                    left: 1345px;
                    border-radius: 50%;
                }

                .counters{
                    position: absolute;
                    color: white;
                    font-size: small;
                    top: -13px;
                    left: 5.7px;
                }

                .dropbtn {
                background-color: transparent;
                color: #40596b;
                margin-left: 33px;
                font-size: 16px;
                border: none;
                cursor: pointer;
                text-decoration: none;            
                }

                /* Basic styling for the dropdown */
        .dropdown2 {
        position: relative;
        display: inline-block;
        
        }

        /* Style the button that will be clicked to show/hide the dropdown content */
        .profile-dropdown {
            background-color: transparent;
            color: #40596b;
            margin-left: 1400px;
            margin-top: 15px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            border-radius: 50%;
        }

        .cont-profile{
            position:absolute;
            width: 10px;
            
        }

        /* Style the actual dropdown content */
        .dropdown-content2 {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            margin-left: 1345px;
            margin-top: 60px;
            min-height: 60px;
            min-width: 160px;
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
            z-index: 1;
            text-align: center;
        }

        /* Style the links inside the dropdown */
        .dropdown-content2 a {
            color: #40596b;
            padding: 10px 12px;
            text-decoration: none;            
            font-size: 14px;
        }

        /* Change color on hover */
        .dropdown-content2 a:hover {
            background-color: #f1f1f1;
        }

        /* Show the dropdown when the button is hovered over */
        .dropdown2:hover .dropdown-content2 {
            display: block;
        }
        
        </style>
    </head>

    <body>
    <div class="nav">
            <div class="navbar">
                <div class="links">
                    <a class="anchnav" id="navhome" href="index.php">Home</a>
                    <a href="product-category.php?category=Eyeglasses" class="dropbtn">Shop</a>                  
                    
                    <a class="anchnav" id="about" href="about.php">About</a>
                    <a class="anchnav" id="tryOn" href="try-on.php">Virtual Try-On</a>
                    <a class="anchnavbtn" id="appointment" href="appointment.php">Book an Appointment</a>
                </div>
                
                <a href="index.php"><img class="logo" src=".\\imagesfinal\OptimalOpticsLogo.png" alt="" height="350px"></a>
                <a href="cart.php"><img class="cart" src=".\\imagesfinal\cart.png" alt="" height="22px">
                
                

                <!-- Profile dropdown HTML structure -->
                <div class="dropdown2">
                    <a class = "cont-profile" href="account.php"><img class="profile-dropdown" src="<?php echo $_SESSION['pImage']; ?>" alt="" height="40px"></a>
                    <div class="dropdown-content2">                                            
                        <?php if (isset($user)): ?>
                
                            <p>Hello, <?= htmlspecialchars($user["name"]) ?>!</p>
                            <hr>
                            <p><a href="account-settings.php">Account Settings</a></p>
                            <p><a href="logout.php">Log out</a></p>
                            
                        <?php else: ?>
                            
                            <p class="loginlink" style="font-weight: 550;"><a href="login.php">LOGIN</a></p>
                            <hr>
                            <p class="signuplink" style="font-weight: 550;"><a href="signup.html">SIGN UP</a></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
    

        