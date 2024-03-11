<?php
    include("config.php");
    
    session_start();
    $sql = mysqli_query($conn, "SELECT * FROM user WHERE id = '$_SESSION[user_id]'");
    while($row = mysqli_fetch_assoc($sql)){
        $_SESSION['name'] = $row['name'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['phoneNumber'] = $row['phone_number'];
        $_SESSION['address'] = $row['e_address'];
        $_SESSION['pImage'] = $row['profileImage'];
    }

    if(isset($_POST['btnsave'])){
        mysqli_query($conn, "UPDATE user SET name = '$_POST[name]', email = '$_POST[email]', phone_number = '$_POST[phoneNumber]', e_address = '$_POST[address]' WHERE id = '$_SESSION[user_id]'");
        $_SESSION['name'] =$_POST['name'];
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['phoneNumber'] = $_POST['phoneNumber'];
        $_SESSION['address'] = $_POST['address'];
        echo "<script>alert('Successfully Updated');</script>";
    }

    if(isset($_POST['btnupload'])){
        $targetF = "uploadedphoto/";
        $targetfile = $targetF . basename($_FILES["image"]["name"]);

        if(move_uploaded_file($_FILES["image"]["tmp_name"], $targetfile)){
            mysqli_query($conn, "UPDATE user SET profileImage = '$targetfile' WHERE id = '$_SESSION[user_id]'");
            $_SESSION['pImage'] = $targetfile;
            echo "<script>alert('Successfully Updated');</script>";
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

        #editprofile{
            font-weight: 600;
        }

        .profile{
            margin-left: 295px;
            margin-top: 40px;
            border-radius: 50%;
        }

        .account-setting-form{
            margin-left: 295px;
            margin-top: 40px
        }

        .name{
            height: 28px;
            width: 300px;
            background: #dedede;
            border:none;
            border-radius:8px;
        }

        .email{
            margin-top: 35px;
            height: 28px;
            width: 300px;
            background: #dedede;
            border:none;
            border-radius:8px;
        }

        .phone{
            margin-top: 35px;
            height: 28px;
            width: 300px;
            background: #dedede;
            border:none;
            border-radius:8px;
        }

        .address{
            margin-top: 35px;
            height: 28px;
            width: 300px;
            background: #dedede;
            border:none;
            border-radius:8px;
        }

        .btnsave{
            margin-left: 90px;
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

        .lblname{
            position: absolute;
            font-size: small;
            margin-top: -22px;
        }

        .lblemail{
            position: absolute;
            margin-top: 15px;
            font-size: small;
        }

        .lblphone{
            position: absolute;
            margin-top: 15px;
            font-size: small;
        }

        .lbladdress{
            position: absolute;
            margin-top: 15px;
            font-size: small;
        }

        input::placeholder {
        font-size: 12px; /* Adjust the size as needed */
        }

        .back-arrow{
            margin-left: 30px;
            margin-top: 25px;
        }

        .imginput{
            position: absolute;
            margin-left: 20px;
            margin-top: 50px;
        }

        .btnupload{
            margin-left: 20px;
            margin-top: 20px;
            border: none;
            background-color: #f89819;
            color: white;
            font-weight: 500;
            padding: 3px;
            border-radius: 8px;
        }
    </style>
</head>


<body>

    <div class="whole-container">
        <h1> Admin Account Settings</h1>

        <div class="account-setting-container">
            <div class="account-setting-sidebar">
            <a href="category-management.php"><img class="back-arrow" src=".\\imagesfinal\back-arrow.png" alt="" height="20px"></a> 
                <div class="text-position"> 
                    <a href="admin-account-settings.php"><p id="editprofile">Edit Profile</p></a> 
                    <a href="admin-change-password.php"><p>Change Password</p></a> 
                </div>
                
            </div>

            <div >
                <form method="POST" enctype="multipart/form-data">
                    <a href="account.php"><img class="profile" src="<?php echo $_SESSION['pImage']; ?>" alt="" height="80px"></a>
                    <input class="imginput" type="file" name="image" id="image" accept=".jpg, .jpeg, .png, .webp, .avif" autocomplete="file" onchange="previewImage(this);" value="">
                    <input type="submit" name="btnupload" class="btnupload" value="Upload">
                </form>
                
            </div>


            
            <div class="account-setting-form">
                <form action="" method="post">
                    <label class="lblname" for="name" >Name</label>
                    <input class="name" type="text" name="name" value="<?php echo $_SESSION['name']; ?>"> <br> 

                    <label class="lblemail" for="email">Email</label>
                    <input class="email" type="text" name="email" value="<?php echo $_SESSION['email']; ?>"> <br>

                    <label class="lblphone" for="phoneNumber">Phone Number</label>
                    <input class="phone" name="phoneNumber" type="text" placeholder="09XXXXXXXX" value="<?php echo $_SESSION['phoneNumber']; ?>"> <br>
                    
                    <label class="lbladdress" for="address"> Address</label>
                    <input class="address" name="address" type="text" placeholder="Enter Address" value="<?php echo $_SESSION['address']; ?>"> <br>
                
                    <input type="submit" name="btnsave" class="btnsave" value="Save Changes">
                </form>
                
            </div>
        </div>
    </div>
    
</body>
</html>