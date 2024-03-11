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



        

        $sql = "SELECT * FROM `design` WHERE `id` = 1";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        

    ?>


<html>
    <head>
        <title>HOME</title>

        <style>
            body{
                margin: 0px;
                background-color: <?php echo htmlspecialchars($row['background']); ?>;                
            }

            *{
                font-family: poppins;
                color: <?php echo htmlspecialchars($row['font']); ?>;
                }

            .anchnav{
                text-decoration: none;
                margin-left: 30px;
                color: <?php echo htmlspecialchars($row['font']); ?>;
                padding: 5px;    
            }

            .anchnavbtn{
                text-decoration: none;
                margin-left: 30px;
                padding: 5px;
                color: <?php echo htmlspecialchars($row['font']); ?>;
                border-radius: 8px;
            }

            .navbar{
                height: 80px;
                width: 100%;
                position: fixed;
                background-color: rgb(255, 255, 255);
                box-shadow: 0px 2px 3px 0px rgba(187, 187, 187, 0.5);
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
                border: none;
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

            .counter{
                position: absolute;
                color: white;
                font-size: small;
                top: -13px;
                left: 5.7px;
            }

            .footer{
                position: absolute;
                background-color: white;
                height: 200px;
                width: 100%;
                top: 2500px;
            }

            .footer-links{
                position: absolute;
                margin-left: 240px;
                margin-top: 25px;
            }

            .products a{
                display: block;
                color: <?php echo htmlspecialchars($row['font']); ?>;
                text-decoration: none;
                font-size: 13px;                
                margin-left: 100px;
            }

            .products p{
                margin-left: 100px;
                font-size: 15px;
                font-weight: bold;
            }

            .help a{
                display: block;
                color: <?php echo htmlspecialchars($row['font']); ?>;
                text-decoration: none;
                font-size: 13px;                
                margin-left: 100px;
            }

            .help{
                margin-left: 200px;
                margin-top: -135px;
            }

            .help p{
                margin-left: 100px;
                font-size: 15px;
                font-weight: bold;
            }

            .terms a{
                display: block;
                color: <?php echo htmlspecialchars($row['font']); ?>;
                text-decoration: none;
                font-size: 13px;                
                margin-left: 100px;
            }

            .terms{
                margin-left:450px;
                margin-top: -135px;
            }

            .terms p{
                margin-left: 100px;
                font-size: 15px;
                font-weight: bold;
            }

            .social a{
                display: block;
                color: <?php echo htmlspecialchars($row['font']); ?>;
                text-decoration: none;
                font-size: 13px;                
                margin-left: 100px;
            }

            .social{
                margin-left: 750px;
                margin-top: -115px;
            }

            .social p{
                margin-left: 100px;
                font-size: 15px;
                font-weight: bold;
            }
 
            .copyright p{
                position: absolute;
                margin-left: 130px;
                margin-top: 170px;
                font-size: 12px;
            }

            #payment1{
                position: absolute;
                margin-top: 170px;
                margin-left: 1070px;
            }

            #payment2{
                position: absolute;
                margin-top: 167px;
                margin-left: 1150px;
            }

            #payment3{
                position: absolute;
                margin-top: 155px;
                margin-left: 1240px;
            }

            #payment4{
                position: absolute;
                margin-top: 146px;
                margin-left: 1300px;
            }

            /* Basic styling for the dropdown */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        /* Style the button that will be clicked to show/hide the dropdown content */
        .dropbtn {
            background-color: transparent;
            color: <?php echo htmlspecialchars($row['font']); ?>;
            margin-left: 33px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            text-decoration: none;            
        }

        /* Style the actual dropdown content */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 140px;
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
            z-index: 1;
        }

        /* Style the links inside the dropdown */
        .dropdown-content a {
            color: #40596b;
            padding: 10px 12px;
            text-decoration: none;
            display: block;
            font-size: 13px;
        }

        /* Change color on hover */
        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        /* Show the dropdown when the button is hovered over */
        .dropdown:hover .dropdown-content {
            display: block;
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

        .slideshow-container {
            position: absolute;
            top: 80px;
            left: 21.7%;
            margin-left: -330px;
            width: 100%;
        }

        .dot {
            height: 10px;
            width: 10px;
            margin: 0 2px;
            background-color: white;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.6s ease;
        }

        .dotCon{
            position: absolute;
            top: 590px;
            left: 50%;
            margin-left: -90px;
            width: 160px;
        }

        .active {
            background-color: #717171;
        }
        
        /* Fading animation */
        .fade {
            animation-name: fade;
            animation-duration: 1.5s;
        }
        
        @keyframes fade {
            from {opacity: .4} 
            to {opacity: 1}
        }

        .welcome-container{
            position: absolute;
            height: 500px;
            width: 1180px;
            background-color: #ffffff;
            top: 1180px;
            left: 170px;
        }

        .welcome-text-container{
            position: absolute;
            width: 1090px;
            top: 30px;
        }

        .welcometxt{
            position: absolute;
            font-family: montserrat;
            font-weight: 500;
            left: 640px;
            top: 55px;
            color: #40596b;
        }

        .welcometxt2{
            position: absolute;
            font-family: montserrat;
            font-weight: 600;
            left: 640px;
            top: 80px;
            color: #40596b;
        }

        .welcometxt3{
            position: absolute;
            font-family: montserrat;
            left: 640px;
            top: 250px;
            color: #40596b;
        }

        .welcomephoto2{
            position: absolute;
            left: 280px;
            top: 48px;
        }

        .featured-container{
            position: absolute;
            height: 500px;
            width: 900px;
            background-color: #ffffff;
            top: 1850px;
            left:320px;
            background-color: #ffffff;
            box-shadow: 0px 2px 3px 0px rgba(187, 187, 187, 0.5);
        }

        .featuredtxt{
            position: absolute;
            font-weight: 600;
            left: 300px;
            top: 30px;
            color: #40596b;
        }

        .featuredlink{
            position: absolute;
            font-weight: 600;
            left: 490px;
            top: 450px;
            text-decoration: none;
        }

        .featured-image-container{
            position: absolute;
            left: 60px;
        }

        .featuredimage1{
            position: absolute;
            top: 150px;
            left: 25px;
            box-shadow: 0px 2px 3px 0px rgba(187, 187, 187, 0.5);
        }

        .featuredimage2{
            position: absolute;
            top: 150px;
            left: 287px;
            box-shadow: 0px 2px 3px 0px rgba(187, 187, 187, 0.5);
        }

        .featuredimage3{
            position: absolute;
            top: 150px;
            left: 550px;
            box-shadow: 0px 2px 3px 0px rgba(187, 187, 187, 0.5);
        }

        .product1txt{
            position: absolute;
            font-weight: 600;
            left: 75px;
            top: 350px;
            color: #40596b;
        }

        .product2txt{
            position: absolute;
            font-weight: 600;
            left: 325px;
            top: 350px;
            color: #40596b;
            width:150px;
        }

        .product3txt{
            position: absolute;
            font-weight: 600;
            left: 595px;
            top: 350px;
            color: #40596b;
            width: 200px;
        }

        #shoptxt{
            position: absolute;
            top: 430px;
            color: #ffffff;
            background-color: #f89819;
            padding: 10px;
            border-radius: 8px;
            width: 200px;
            font-size: 18px;
            text-align:left;
            font-weight: 600;
            left: 350px;
        }

        #shoptxt img{
            position: absolute;
            top: 12px;
            left: 175px;
        }

        .doctors-container{
            position: absolute;
            height: 400px;
            width: 100%;
            top: 650px;
            
        }

        .doctorstxt{
            position: absolute;
            top: 10px;
            font-family: montserrat;
            font-weight: 550;
            left: 650px;
            color: #40596b;
        }

        .doctorstxt2{
            position: absolute;
            font-family: montserrat;
            font-weight: 600;
            left: 450px;
            top: 30px;
            color: #40596b;
        }

        .doctor-parent-container{
            position: absolute;
            left: 220px;
        }

        .doctor-image-container1{
            position: absolute;
            height: 250px;
            width: 177px;
            background-color: white;
            top: 120px;
            left: 250px;
        }

        .doctor-image-container2{
            position: absolute;
            height: 250px;
            width: 177px;
            background-color: white;
            top: 120px;
            left: 50px;
        }

        .doctor-image-container3{
            position: absolute;
            height: 250px;
            width: 177px;
            background-color: white;
            top: 120px;
            left: 450px;
        }

        .doctor-image-container4{
            position: absolute;
            height: 250px;
            width: 177px;
            background-color: white;
            top: 120px;
            left: 650px;
        }

        .doctor-image-container5{
            position: absolute;
            height: 250px;
            width: 177px;
            background-color: white;
            top: 120px;
            left: 850px;
        }

        .doctor1{
            position: absolute;
        }

        .name-container{
            position: absolute;
            height: 45px;
            width: 160px;
            top: 200px;
            background-color: #f89819;
        }

        .drname{
            position: absolute;
            font-family: montserrat;
            top: -15px;
            left: 10px;
            color: #ffffff;
        }

        .drtitle{
            position: absolute;
            font-family: montserrat;
            font-size: 10px;
            font-weight: 500;
            top: 15px;
            left: 10px;
            color: #ffffff;
        }
        </style>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;0,400;0,500;1,300;1,400&display=swap" rel="stylesheet">
    </head>

    <body>
        
        
        <div class="doctors-container">
            <p class= "doctorstxt" id="doctorstxt">MEET OUR DOCTORS</p>
            <h1 class="doctorstxt2" >Our Specialist Doctors To Serve You</h1>
            
            <div class="doctor-parent-container">
                <div class="doctor-image-container1">
                    <img class="doctor1" src=".\\imagesfinal\doctor1.jpg" alt="" height="210px">
                    <div class="name-container">
                        <h5 class="drname">Dr. Hayley</h5>
                        <p class="drtitle"> Consultant Eye Specialist</p>
                    </div>
                </div>

                <div class="doctor-image-container2">
                    <img class="doctor1" src=".\\imagesfinal\doctor2.jpg" alt="" height="210px">
                    <div class="name-container">
                        <h5 class="drname">Dr. Lucky</h5>
                        <p class="drtitle"> Optician</p>
                    </div>
                </div>

                <div class="doctor-image-container3">
                    <img class="doctor1" src=".\\imagesfinal\doctor3.jpg" alt="" height="210px">
                    <div class="name-container">
                        <h5 class="drname">Dr. Cha</h5>
                        <p class="drtitle"> Optometrist</p>
                    </div>
                </div>

                <div class="doctor-image-container4">
                    <img class="doctor1" src=".\\imagesfinal\doctor4.jpg" alt="" height="210px">
                    <div class="name-container">
                        <h5 class="drname">Dr. Rizz</h5>
                        <p class="drtitle"> Ophthalmologist</p>
                    </div>
                </div>

                <div class="doctor-image-container5">
                    <img class="doctor1" src=".\\imagesfinal\doctor5.jpg" alt="" height="210px">
                    <div class="name-container">
                        <h5 class="drname">Dr. Langston</h5>
                        <p class="drtitle"> Optometrist</p>
                    </div>
                </div>
            </div>   
        </div>

        <div class="featured-container">
            <h1 class= "featuredtxt">Featured Collections</h1>
            <a class="featuredlink" id="shoptxt" href="product-category.php?category=Eyeglasses">SHOP NOW <img src=".\\imagesfinal\arrowright-white.png" alt="" height="25px"> </a>

            <div class="featured-image-container">
                <img class="featuredimage1" src=".\\imagesfinal\asset21.jpg" alt="" height="200px">
                <img class="featuredimage2" src=".\\imagesfinal\asset18.jpg" alt="" height="200px">
                <img class="featuredimage3" src=".\\imagesfinal\asset20.jpg" alt="" height="200px">
                
                <div class="product-name">
                    <h3 class="product1txt">Eyeglasses</h3>
                    <h3 class="product2txt">Contact Lens</h3>
                    <h3 class="product3txt">Accessories</h3>
                </div>
            </div>
        </div>


        <div class="welcome-container" id="welcome">
            <div class="welcome-text-container">
                <p class= "welcometxt">WELCOME TO OUR CLINIC</p>
                <h1 class= "welcometxt2" >We offer comprehensive and thorough medical procedures to our patients</h1>
                <p class= "welcometxt3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolores aut reprehenderit perferendis quisquam recusandae maxime cum blanditiis mollitia, fugiat quis obcaecati fuga fugit, enim amet placeat, ipsam magnam! Minus, saepe.</p>
            </div>

            <img class="welcomephoto" src=".\\imagesfinal\asset7wcolor.jpg" alt="" height="500px">
            <img class="welcomephoto2" src=".\\imagesfinal\asset6.jpg" alt="" height="400px">
        </div>


        <div class="slideshow-container">

            <div class="mySlides fade">
            <img src="<?php echo htmlspecialchars($row['ads1']); ?>" style="width:100%">
            </div>

            <div class="mySlides fade">
            <img src="<?php echo htmlspecialchars($row['ads2']); ?>" style="width:100%">
            </div>

            <div class="mySlides fade">
            <img src="<?php echo htmlspecialchars($row['ads3']); ?>" style="width:100%">
            </div>
        </div>

        <div style="text-align:center" class="dotCon">
            <span class="dot"></span> 
            <span class="dot"></span> 
            <span class="dot"></span> 
        </div>


        

        <div class="nav">
            <div class="navbar">
                <div class="links">
                    <a class="anchnav" id="navhome" href="index.php">Home</a>
                    <a href="product-category.php?category=Eyeglasses" class="dropbtn">Shop</a>                  
                    
                    <a class="anchnav" id="about" href="about.php">About</a>
                    <a class="anchnav" id="tryOn" href="try-on.php">Virtual Try-On</a>
                    <a class="anchnavbtn" id="appointment" href="appointment.php">Book an Appointment</a>
                </div>
                
                <a href="index.php"><img class="logo" src="<?php echo htmlspecialchars($row['logo']); ?>" alt="" height="350px"></a>
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

        <div class="footer">
            <div class= "footer-links">
                <div class="products">
                    <p>Products</p>
                        <div class="productlinks">
                            <a href="#">Eyeglasses</a>
                            <a href="#">Contact Lens</a>
                            <a href="#">Solutions</a>
                            <a href="#">Accessories</a>
                        </div>                
                </div>

                <div class="help">
                    <p>Help</p>
                        <div class="helplinks">
                            <a href="#">Book an appointment</a>
                            <a href="#">About Us</a>
                            <a href="#">Contact Us</a>
                            <a href="#">FAQ</a>
                        </div>                
                </div>

                <div class="terms">
                    <p>Terms & Conditions</p>
                        <div class="termslinks">
                            <a href="#">Terms and Condition</a>
                            <a href="#">Privacy Policy</a>
                            <a href="#">Privacy Notice</a>
                        </div>                
                </div>

                <div class="social">
                    <p>Socials</p>
                        <div class="sociallinks">
                            <a href="#">Facebook</a>
                            <a href="#">Instagram</a>
                            <a href="#">Twitter</a>
                            <a href="#">Tiktok</a>
                        </div>                
                </div>
            </div>

            <div class="copyright"> 
                <p>Copyright © 2023 Optimal Optics. All Rights Reserved.</p>
                <div class="onlinepayment">
                    <img class="payment" id="payment1" src=".\\imagesfinal\maya_logo.png" alt="" height="18px">
                    <img class="payment" id="payment2" src=".\\imagesfinal\gcash_logo.png" alt="" height="18px">
                    <img class="payment" id="payment3" src=".\\imagesfinal\mastercard.png" alt="" height="45px">
                    <img class="payment" id="payment4" src=".\\imagesfinal\paypal.png" alt="" height="60px">
                </div>
            </div>
        </div>

        

        <script>
            let slideIndex = 0;
            showSlides();
            
            function showSlides() {
              let i;
              let slides = document.getElementsByClassName("mySlides");
              let dots = document.getElementsByClassName("dot");
              for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";  
              }
              slideIndex++;
              if (slideIndex > slides.length) {slideIndex = 1}    
              for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
              }
              slides[slideIndex-1].style.display = "block";  
              dots[slideIndex-1].className += " active";
              setTimeout(showSlides, 3000); // Change image every 3 seconds
            }
        </script>
    </body>
</html>