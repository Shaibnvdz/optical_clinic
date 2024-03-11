<?php
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include("admin-sidebar.php");

    $mysqli = require __DIR__ . "/database.php";

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $user_id = $_SESSION["user_id"];

    // Fetch user data from the database
    $sql = "SELECT * FROM user WHERE id = $user_id";
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();

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
    <title>Customer Page Setting</title>
    <style>
        body{
                margin: 0px;
                background-color: white;
            }

        *{
            font-family: poppins;    
            }

        .text1{
            margin-top: 0px;
            margin-left: 585px;
            position: absolute;
            padding: 10px;
            border-bottom-right-radius: 30px;
            border-bottom-left-radius: 30px;
            font-size: 60px;
            background-color: white;
            box-shadow: 0px 2px 3px 0px rgba(187, 187, 187, 0.5);
            color: #f89819;
        }

        .all{
            position: absolute;
            margin-top:200px;
            margin-left: 400px;
            line-height: 40px;
            }
        
        .slideshow{
            margin-left: 600px;
            margin-top: -400px;
        }
        
        #changeButton{
            border-radius: 5px;
            border: none;
            color: white !important;
            background-color: #f89819;
            font-weight: 600;
            height:50px ;
            width: 150px;
            text-transform: uppercase;
            margin-left: 350px;
        }

        #manage-ui{
            background-color: #f4f4f4;
            font-weight: 600;
        }

       .logo-img{
        box-shadow: 0px 2px 3px 0px rgba(187, 187, 187, 0.5);
       }
        
    </style>
</head>
<body>
    
<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "opticaldb";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM design "; 
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<h1 class="text1">Modify Design</h1>
<div class="all">
    <form method="post" action="update_style.php" enctype="multipart/form-data">
        
    <div class="font-logo-bg">
        <label for="font">Font Color:</label>
        <input type="color" name="font" value="<?php echo htmlspecialchars($row['font']); ?>"> <br>

        <label for="background">Background Color:</label>
        <input type="color" name="background" value="<?php echo htmlspecialchars($row['background']); ?>"><br>

        <label for="logo">Logo</label>
        <img class="logo-img" src="<?php echo htmlspecialchars($row['logo']); ?>" alt="Logo" width="250px"> <br>
        <input type="file" name="logo"> <br>
    </div>
    
    
    <div class="slideshow">
        <label for="ads1">Slideshow 1:</label>
        <img src="<?php echo htmlspecialchars($row['ads1']); ?>" alt="Advertisement 1" width="250px">
        <input type="file" name="ads1"> <br>

        <label for="ads2">Slideshow 2:</label>
        <img src="<?php echo htmlspecialchars($row['ads2']); ?>" alt="Advertisement 2" width="250px">
        <input type="file" name="ads2"> <br> 

        <label for="ads3">Slideshow 3:</label>
        <img src="<?php echo htmlspecialchars($row['ads3']); ?>" alt="Advertisement 3" width="250px">
        <input type="file" name="ads3"> <br>
    </div>
    

    <button id="changeButton" type="submit">Change Style</button>
</form>
</div>





</body>
</html>
