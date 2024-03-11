<?php 
session_start();
include("config.php");
include("functions.php");

	
	$pic = '';
	$query = mysqli_query($conn, "SELECT * FROM admin WHERE email='thevelvet.elegance@gmail.com'");

	
	if (mysqli_num_rows($query) > 0)
	{
		$row = mysqli_fetch_assoc($query);
		$admin = $row['admin_name'];
	}
	if($row['profile'] == '')
	{
		$pic = '<img src="pictures/profile.png" style="width:20px;height:20px;position:relative;top:3px;left:-10px;border-radius:50%;border:1px solid black;">';
	}
	else 
	{
		$pic = '<img src="upload_image/'.$row['profile'].'"style="width:20px;height:20px;position:relative;top:3px;left:-10px;border-radius:50%;border:1px solid white;">';
	}

    
	$pic = '';
	$query = mysqli_query($con, "SELECT * FROM admin WHERE email='thevelvet.elegance@gmail.com'");
	
	if (mysqli_num_rows($query) > 0)
	{
		$row = mysqli_fetch_assoc($query);
		$user_data = $row['admin_name'];
	}
	if($row['profile'] == '')
	{
		$pic = '<img src="pictures/profile.png" style="width:20px;height:20px;position:relative;top:3px;left:-10px;border-radius:50%;border:1px solid white;">';
	}
	else 
	{
		$pic = '<img src="upload_image/'.$row['profile'].'"style="width:20px;height:20px;position:relative;top:3px;left:-10px;border-radius:50%;border:1px solid white;">';
	}

error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost:3306"; // Use the correct server name or IP address
$username = "root"; // Use the correct username
$password = ""; // Use the correct password
$dbname = "try"; // Change the database name to 'try'

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (!(isset($_SESSION['admin_password_verified']) && $_SESSION['admin_password_verified'] === true)) {
    // Redirect to the password verification page or handle the case where verification is not done
    header("Location: verify_password.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitPassword"])) {
    $adminPassword = mysqli_real_escape_string($con, $_POST['adminPassword']);

    // Validate the admin password
    if ($admin_data['password'] === $adminPassword) {
        // Password is correct, allow access to modify customer design settings
        // ... (your existing code for design settings modification)
    } else {
        echo "<script>alert('Incorrect admin password');</script>";
    }
}


// Check kung may existing record na
$sqlCheck = "SELECT * FROM design_settings WHERE id = 1";
$resultCheck = $conn->query($sqlCheck);

if ($resultCheck->num_rows == 0) {

    $sqlInsert = "INSERT INTO design_settings (background_color, font_color,  logo_path, image_one_path, image_two_path, image_three_path)
    VALUES ('#435334', '#FAF1E4',  'default_logo.png', 'default_image1.png', 'default_image2.png', 'default_image3.png')";

    if ($conn->query($sqlInsert) === TRUE) {
        echo "Default record added successfully";
    } else {
        echo "Error adding default record: " . $conn->error;
    }
}

// Kumuha ng design settings mula sa database
$sqlGetSettings = "SELECT * FROM design_settings WHERE id = 1"; // Id 1 assumes there's only one record for design settings
$resultSettings = $conn->query($sqlGetSettings);

if ($resultSettings->num_rows > 0) {
    // Output data ng bawat row
    while ($row = $resultSettings->fetch_assoc()) {
        $bgColor = $row["background_color"];
        $fontColor = $row["font_color"];
       
        $logoPath = $row["logo_path"];
        $imageOnePath = $row["image_one_path"];
        $imageTwoPath = $row["image_two_path"];
        $imageThreePath = $row["image_three_path"];
    
    }
} else {
    echo "0 results";
}


// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["updateColors"])) {
        // Handle color form submission
        $bgColor = $_POST["background_color"];
        $fontColor = $_POST["font_color"];

        $sqlUpdateColors = "UPDATE design_settings SET
            background_color='$bgColor',
            font_color='$fontColor'
        WHERE id = 1";

        if ($conn->query($sqlUpdateColors) === TRUE) {
            echo "<script>alert('Updated Successfully');</script>";
        } else {
            echo "Error updating colors: " . $conn->error;
        }
    } elseif (isset($_POST["clearColors"])) {
        // Clear All Colors
        $bgColor = '#FAF1E4';
        $fontColor = '#435334';

        $sqlClearColors = "UPDATE design_settings SET
            background_color='$bgColor',
            font_color='$fontColor'
        WHERE id = 1";

        if ($conn->query($sqlClearColors) === TRUE) {
            echo "<script>alert('Updated Successfully');</script>";
        } else {
            echo "Error clearing colors: " . $conn->error;
        }
    } elseif (isset($_POST["updateShopDetails"])) {
        // Handle shop details form submission
      
        $logoPath = ''; // Define the default value or handle the update logic for the logo path

        // Check if a new logo file is uploaded
        if ($_FILES["logo_path"]["size"] > 0) {
            $targetDirectory = "upload_image/";
            $logoPath = $targetDirectory . basename($_FILES["logo_path"]["name"]);
            move_uploaded_file($_FILES["logo_path"]["tmp_name"], $logoPath);
        }

        // Update shop details in the database
        $sqlUpdateShopDetails = "UPDATE design_settings SET
           
            logo_path='$logoPath'
        WHERE id = 1";

        if ($conn->query($sqlUpdateShopDetails) === TRUE) {
            echo "<script>alert('Updated Successfully');</script>";
        } else {
            echo "Error updating shop details: " . $conn->error;
        }
    } elseif (isset($_POST["updateImages"])) {
        // Handle images form submission
        handleFileUpload($_FILES["image_one_path"], "image_one_path");
        handleFileUpload($_FILES["image_two_path"], "image_two_path");
        handleFileUpload($_FILES["image_three_path"], "image_three_path");
        
        echo "<script>alert('Images Updated Successfully');</script>";
   
    }

}

$conn->close();

// Function to handle file upload and database update
function handleFileUpload($file, $column) {
    global $conn;

    $targetDirectory = "upload_image/";
    $filePath = $targetDirectory . basename($file["name"]);

    move_uploaded_file($file["tmp_name"], $filePath);

    // Update file path in the database
    $sqlUpdateFile = "UPDATE design_settings SET
        $column='$filePath'
    WHERE id = 1";

    if ($conn->query($sqlUpdateFile) === TRUE) {
        echo "<script>alert(ucfirst($column) . 'Updated Successfully');</script>";
    } else {
        echo "Error updating " . $column . ": " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" href="pictures/icon.png">
    <title><?php echo "".$user_data;?> - Customer Page | The Velvet Elegance</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            list-style: none;
            text-decoration: none;
            font-family: "Lato", sans-serif;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            overflow-x: hidden;
            background-color: #FAF1E4;
            transition: background-color 0.5s ease;

        }

        header {
            width: 100%;
            height: 70px;
            background: #FAF1E4;
            display: flex;
            font-size: 20px;
            align-items: center;
            justify-content: space-between;
            position: fixed;
            top: 0;
        }

        .logo img {
            width: 200px;
        }

        .nav-bar ul {
            display: flex;
        }

        .nav-bar ul li {
            margin-right: 10px;
        }
        .nav-bar ul li a {
    display: block;
    text-transform: uppercase; /* Added property for all caps */
    color: #000;
    font-size: 17px;
    font-weight: bold;
    padding: 10px 25px;
    border-radius: 10px;
    transition: 0.2s;
    margin: 0 5px;
}

.nav-bar ul li a:hover {
    color: white;
    background: #9EB384;
}

.nav-bar ul li a.active {
    color: white;
    background: #9EB384;
}

        @media only screen and (max-width: 1366px) {
            header {
                padding: 0 50px;
            }
        }

        @media only screen and (max-width: 1250px) {
            .hamburger {
                display: block;
                cursor: pointer;
            }

            .hamburger .line {
                width: 30px;
                height: 5px;
                border-radius: 5px;
                background: #000;
                margin: 6px 0;
            }
        }

     
        .form-container {
                margin: 20px auto;
                margin-top: 3.5%;
                width: 80%;
                max-width: 600px;
                padding: 20px;
                border-radius: 10px;
                background-color: #9EB384;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.7);
            }

            h2 {
                margin-bottom: 20px;
                letter-spacing: 3px;
                text-align: center;
                font-size: 35px;
                color: #435334; /* Updated font color */
            }

            label {
                font-size: 20px;
                margin-left: 10px;
                letter-spacing: 3px;
                display: block;
                margin-bottom: 8px;
                color: #435334; /* Updated font color */
            }

            input[type="color"],
            input[type="file"] {
                width: calc(100% - 20px);
                margin-bottom: 15px;
                padding: 10px;
                border: 1px solid #CEDEBD; /* Updated border color */
                border-radius: 5px;
                border: 3px solid #CEDEBD; /* Updated border color */
            }

            button {
                padding: 12px;
                background-color: #FAF1E4; /* Updated background color */
                color: #435334; /* Updated font color */
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 16px;
                transition: background-color 0.3s ease;
            }

            button:hover {
                background-color: #CEDEBD; /* Darker color on hover */
            }

            .logo-container,
            .image-container1,
            .image-container2,
            .image-container3 {
                margin-top: 20px;
                text-align: center;
            }

            .logo-container img,
            .image-container1 img,
            .image-container2 img,
            .image-container3 img {
                max-width: 120%;
                max-height: 180px;
                border: 3px solid #CEDEBD; /* Updated border color */
                overflow: hidden;
                margin-bottom: 10px;
                cursor: pointer;
            }

            span {
                margin-top: 10px;
                display: block;
                font-size: 14px;
                color: #435334; /* Updated font color */
            }

    </style>
</head>

<body>
    <header>
        <div class="logo"><img src="pictures/Logo.png"></div>
        <div class="hamburger">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
        <nav class="nav-bar">
            <ul>
            <li class="navText"><a href="e-table.php" >E-Table</a></li>
                <li class="navText"><a href="addcategories.php">Admin Panel</a></li>
                <li class="navText"><a href="customeraccount.php">Customer Account</a></li>
                <li class="navText"><a href="adminAppointment.php">Table</a></li>
                <li class="navText"><a href="adminSettings.php" class="active"><?php echo $pic; echo $admin; ?></a></li>
                <li class="navText"><a href="logout.php">Log Out</a></li>
            </ul>
        </nav>
    </header>

    <script>
        hamburger = document.querySelector(".hamburger");
        hamburger.onclick = function () {
            navBar = document.querySelector(".nav-bar");
            navBar.classList.toggle("active");
        }
    </script>

    <center>
        <h1 class="text1"> MODIFY THE CUSTOMER </h1>
    </center>

    <div class="form-container">
        <h2> COLOR SETTINGS </h2>
        <form method="post" action="" id="colorForm" enctype="multipart/form-data">
            <label for="background_color">Background Color:</label>
            <input type="color" id="background_color" name="background_color" value="<?php echo $bgColor; ?>">
            <label for="font_color">Font Color:</label>
            <input type="color" id="font_color" name="font_color" value="<?php echo $fontColor; ?>">
            <button type="submit" name="updateColors">SAVE</button>
            <button type="button" onclick="clearColors()">RESET</button>
        </form>

        <h2> LOGO </h2>
        <form method="post" action="" id="shopDetailsForm" enctype="multipart/form-data">
            <label for="logo_path">Logo:</label>
            <input type="file" id="logo_path" name="logo_path">
            <div class="logo-container">
                <img src="upload_image/<?php echo basename($logoPath); ?>" alt="Logo">
            </div>
            <button type="submit" name="updateShopDetails">Update Logo</button>
        </form>

        <h2> SLIDESHOW </h2>
        <form method="post" action="" id="imagesForm" enctype="multipart/form-data">
            <label for="image_one">Image One:</label>
            <input type="file" id="image_one_path" name="image_one_path">
            <div class="image-container1">
                <img src="upload_image/<?php echo basename($imageOnePath); ?>" alt="Image One">
            </div>

            <label for="image_two">Image Two:</label>
            <input type="file" id="image_two_path" name="image_two_path">
            <div class="image-container2">
                <img src="upload_image/<?php echo basename($imageTwoPath); ?>" alt="Image Two">
            </div>

            <label for="image_three">Image Three:</label>
            <input type="file" id="image_three_path" name="image_three_path">
            <div class="image-container3">
                <img src="upload_image/<?php echo basename($imageThreePath); ?>" alt="Image Three">
            </div>
            <button type="submit" name="updateImages">Update Slideshow</button>
        </form>
    </div>

    <script>
        
        function clearColors() {
            // Set default values for background and font colors
            document.getElementById('background_color').value = '#FAF1E4';
            document.getElementById('font_color').value = '#435334';
        }

         // Function to reload the page after updating images
         function reloadPage() {
            location.reload(true);
        }
    </script>

</body>

</html>
