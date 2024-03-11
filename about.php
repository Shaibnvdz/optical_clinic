<?php
    include("navbar.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>

    <style>
        body{
                margin: 0px;
                background-color: #f4f4f4;
            }

            *{
                font-family: poppins !important;
                color: #40596b ;
            }
            .about-container{
                position: absolute;
                width: 1000px;
                left: 400px;
                top: 435px;
                color: #40596b;
            }

            .abouttxt-container{
                position: absolute;
                width: 500px;
                top: 0px;
                left: 470px;
            }

            .abouttxt1{
                position: absolute;
                width: 500px;
                top: 20px;
                left: 0px;
            }

            .abouttxt2{
                position: absolute;
                width: 500px;
                top: 80px;
                font-weight: 500;
                text-align: justify;
            }

            #shoptxt{
                position: absolute;
                top: 450px;
                color: #ffffff;
                background-color: #54c0eb;
                padding: 10px;
                border-radius: 8px;
                width: 200px;
                font-size: 18px;
                text-align:left;
                font-weight: 600;
                left: 430px;
            }

            #shoptxt img{
                position: absolute;
                top: 9px;
                left: 185px;
            }

            #shoptxt:hover{
                background-color: #40596b;
                border-radius: 8px;
            }

            .story-container{
                position: absolute;
                top: 500px;
                left: -130px;
                width: 800px;
                text-align: justify;
                background-color: #f89819;
                padding: 10px;
                border-radius: 15px;
                
            }

            .storytxt1{
                width: 500px;
                color: white;
                margin-left: 25px;
            }

            .storytxt2{
                width: 500px;
                font-weight: 500;
                color: white;
                margin-left: 25px;
                text-indent: 70px;
            }

            .storyphoto{
                position: absolute;
                top: -35px;
                left: 793px;
            }

            .mission-container{
                position: absolute;
                top: 950px;
                left: 50px;
                width: 800px;
                text-align: justify;    
                background-color: #54c0eb;
                padding: 10px;
                border-radius: 15px;
            }

            .missiontxt1{
                width: 500px;
                color: white;
                margin-left: 275px;
            }

            .missiontxt2{
                width: 500px;
                font-weight: 500;
                color: white;
                margin-left: 275px;
                text-indent: 70px;
                text-align: justify;
            }

            .missionphoto{
                position: absolute;
                top: -35px;
                left: -180px;
            }

            .container{
                position: absolute;
                width: 85vmin;
                margin-top: 100px;
                transform: translate(-50%, -50%);
                overflow: hidden;
                left: 90px;
            }

            .wrapper{
                width: 100%;
                display: flex;
                animation: slide 15s infinite;
            }

            .imageslide{
                width: 100%;
            }

            @keyframes slide{
                0%{
                transform: translateX(0);
                }
                25%{
                transform: translateX(0);
                }

                30%{
                transform: translateX(-100%);
                }

                50%{
                transform: translateX(-100%);
                }

                55%{
                transform: translateX(-200%);
                }

                75%{
                transform: translateX(-200%);
                }

                80%{
                transform: translateX(-300%);
                }

                100%{
                transform: translateX(-300%);
                }
            }

            .yoptimal-container{
            position: absolute;
            top: 1350px;
            left: -238px;
            padding: 20px;
            border-radius: 15px;
            font-weight: 500;
            }

            .firstrow {
            display: flex;
            }

            .secondrow {
            display: flex;
            }

            .thirdrow {
            display: flex;
            }

            .why  {
            text-align: center;
            }

            .five{
            margin-left: 40px;
            }

            .six{
            position: absolute;
            margin-left: 700px;
            }

            .three{
            width: 650px;
            }

            .visit-container{
            position: absolute;
            top: 1970px;
            left: -238px;
            }

            .visitUs{
            text-align: center;
            
            }

            .visit{
            text-align: center;
            font-weight: 500;
            }

            .bannerphoto{
            position: absolute;
            width: 100%;
            top: 90px;
            }

            .footer{
                position: absolute;
                background-color: white;
                height: 200px;
                width: 100%;
                margin-top: 2700px;
            }

            .footer-links{
                position: absolute;
                margin-left: 240px;
                margin-top: 25px;
            }

            .products a{
                display: block;
                color: #40596b;
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
                color: #40596b;
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
                color: #40596b;
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
                color: #40596b;
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
    </style>
</head>
<body>
    <div class="about-container">
        <div class="abouttxt-container">
            <h2 class="abouttxt1">About Optimal Optics Shop</h2>
            <p class="abouttxt2">Welcome to Optimal Optics, your trusted destination for high-quality eyewear and professional eye care. We are dedicated to enhancing your vision and style, all while ensuring your eye health is our top priority.</p>
        </div>

        
        <div class="story-container">
            <h2 class="storytxt1">Our Story</h2>
            <p class="storytxt2">Optimal Optics was founded with a passion for providing top-notch eye care services and offering a curated selection of eyeglasses and sunglasses to meet the diverse needs and preferences of our customers. With years of experience in the optical industry, we have established ourselves as a reputable and customer-centric eyewear provider.</p>
                <div>
                    <img class="storyphoto" src=".\\imagesfinal\asset5.jpg" alt="" height="350px">
                </div>
        </div>

        <div class="mission-container">
            <h2 class="missiontxt1">Our Mission</h2>
            <p class="missiontxt2">Our mission is simple: to help you see the world more clearly and express your unique style through our wide range of eyewear options. We believe that eyeglasses are not just a vision correction tool but also a fashion statement. That's why we offer a carefully curated collection of eyeglasses and sunglasses from leading brands, ensuring you look and feel your best.</p>
                <div>
                    <img class="missionphoto" src=".\\imagesfinal\asset4.jpg" alt="" height="350px">
                </div>
        </div>

        <div class="container">
            <div class="wrapper">
                <img class="imageslide" src=".\\imagesfinal\asset16.jpg" alt="">
                <img class="imageslide"  src=".\\imagesfinal\asset15.jpg" alt="">
                <img class="imageslide" src=".\\imagesfinal\asset14.jpg" alt="">            
                <img class="imageslide" src=".\\imagesfinal\asset17.jpg" alt="">
            </div>
        </div>

        <div class="yoptimal-container">
            <h1 class="why">WHY CHOOSE OPTIMAL OPTICS?</h1>
            <div class="firstrow">
                <div class="one">
                    <h3 class="title1">1. Expertise</h3>
                    <p class="description1">Our team of licensed and experienced eye care professionals is dedicated to providing top-quality services and guidance for your eye health and visual needs.</p>
                </div>

                <div class="four">
                    <h3 class="title4">4. Cutting-Edge Technology</h3>
                    <p class="description4">Our commitment to the latest technology and practices ensures you receive the best care and eyewear available.</p>
                </div>
                
            </div>

            <div class="secondrow">
                <div class="two">
                    <h3 class="title2">2. Fashionable Selection</h3>
                    <p class="description2">Discover a wide range of fashionable frames and sunglasses from top brands and exclusive collections, ensuring you find the perfect style.</p>
                </div>

                <div class="five">
                    <h3 class="title5">5. Customer-Centric Approach</h3>
                    <p class="description5">Your satisfaction and eye health are our top priorities. We strive to exceed your expectations at every visit.</p>
                </div>
                
            </div>

            <div class="thirdrow">
                <div class="three">
                    <h3 class="title3">3. Cutting-Edge Technology</h3>
                    <p class="description3">At Optimal Optics, we stay at the forefront of technological advancements in the eyecare industry. We invest in the latest equipment to guarantee your eye health is in the best hands.</p>
                </div>

                <div class="six">
                    <h3 class="title6">6. Personalized Care</h3>
                    <p class="description6">We take the time to understand your unique needs and preferences, offering personalized solutions to help you look and see your best.</p>
                </div>                              
            </div>
        </div>

        <div class="visit-container">
            <h1 class="visitUs"> Visit Us Today!</h1>
            <p class="visit">Optimal Optics is more than just an eyewear store; we are your partners in eye care and fashion. Whether you need a new pair of glasses, an eye exam, or expert advice, we're here for you. Come visit us today, and let's embark on a journey to better vision and style together.</p>
        </div>     
    </div>

    <div class="banner-container">
        <img class="bannerphoto" src=".\\imagesfinal\BannerOptical2.png" alt="">
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
</body>
</html>