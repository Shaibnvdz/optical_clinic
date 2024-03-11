<?php
    @include 'config.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    // Logout logic
    if (isset($_GET['logout'])) {
        unset($_SESSION[$user_id]);
        header('Location: login.php'); // Redirect to your login page after logout
        exit();
    }

    if (isset($_SESSION["user_id"])) {
            
        $mysqli = require __DIR__ . "/database.php";
        
        $sql = "SELECT * FROM user
                WHERE id = {$_SESSION["user_id"]}";
                
        $result = $mysqli->query($sql);
        
        $user = $result->fetch_assoc();
    }

    $sqlI = mysqli_query($conn, "SELECT * FROM user WHERE id = '$_SESSION[user_id]'");
    while($row = mysqli_fetch_assoc($sqlI)){
        $_SESSION['pImage'] = $row['profileImage'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>

    <style>
        body {
            background-color: #f4f4f4;
            margin: 0;            
        }

        *{
            font-family: poppins;
            
        }

        .sidebar-container{
            position: fixed;
            width: 300px;
            height: 775px;
            background-color: white;
            box-shadow: 3px 2px 3px 0px rgba(187, 187, 187, 0.5);
            color: #40596b;
        }

        .sidebar-content{
            margin-top: 30px;
            margin-left: 55px;
        }

        a{
            text-decoration: none;
            color: #40596b;
        }

        .link{            
            display: flex;
            margin-top: 18px;
            padding: 2px;
            width: 200px;            
        }

        .link:hover {
        background-color: #f4f4f4;
        }

        .link img{
            margin-right: 15px;
        }

        .logout{
            padding: 2px;
            display: flex;
            margin-top: 40px;
            width: 200px;
            border-radius: 5px;
            align-items: center;            
        }

        .logout:hover {
        background-color: #f4f4f4;
        }

        .logout img{
            margin-right: 15px;
        }

        hr{
            
            height: 2px;
            width: 260px;
            background-color: #d4d4d4;
            border: none;
            margin-top: 20px;
        }

        .profile{
            margin-top: 30px;
            margin-left: 110px;
            
        }

        .hellotxt{
            text-align: center;
        }

        .settings{
            margin-left: 250px;
            margin-top: 20px;
        }

        .sidebar-profile{
            border-radius: 50%;
        }

        .admin-name{
            text-align: center;
        }

    </style>
</head>
<body>
    
    <div class="sidebar-container">
        <div class="profile">
            <img class="sidebar-profile" src="<?php echo $_SESSION['pImage']; ?>" alt="" height="80px">
        </div>

        <p class="admin-name">Admin <?= htmlspecialchars($user["name"]) ?></p>
        <hr>
        <div class="sidebar-content" >
            <div class="link" id="appointments">
                <img src=".\\imagesfinal\schedule.png" alt="" height="23">
                <a href="appointment-management.php">Appointments</a>
            </div>

            <div class="link" id="manageaccounts">
                <img src=".\\imagesfinal\user1.png" alt="" height="21">
                <a href="admin-password2.php" >Manage Accounts</a>
            </div>

            <div class="link" id="category">
                <img src=".\\imagesfinal\category.png" alt="" height="20">
                <a href="category-management.php" >Manage Category</a>
            </div>

            <div class="link" id="product">
                <img src=".\\imagesfinal\box.png" alt="" height="24">
                <a href="add-product.php" >Manage Product</a>
            </div>

            <div class="link" id="manage-ui">
                <img src=".\\imagesfinal\edit.png" alt="" height="21">
                <a href="admin-password.php" >Manage UI</a>
            </div>

            <div class="link" id="patient-history">
                <img src=".\\imagesfinal\medical-checkup.png" alt="" height="23">
                <a href="patient-history.php" >Patient History</a>
            </div>
            
            <div class="link" id="pos">
                <img src=".\\imagesfinal\point-of-sale.png" alt="" height="24">
                <a href="pos.php" >Point of Sale</a>
            </div>

            <div class="link" id="reports">
                <img src=".\\imagesfinal\report.png" alt="" height="22">
                <a href="generate_reports.php" >Reports</a>
            </div>

        <div class="link" id="payment-history">
                <img src=".\\imagesfinal\transaction-history1.png" alt="" height="22">
                <a href="payment-history.php" >Payment History</a>
            </div>

            <div class="link">
                <img src=".\\imagesfinal\gear.png" alt="" height="22">
                <a href="admin-account-settings.php" >Settings</a>
            </div>

            <div class="logout">
                <img src=".\\imagesfinal\logout.png" alt="" height="21">
                <a href="?logout" >Logout</a>
            </div>
        </div>
    </div>
</body>
</html>