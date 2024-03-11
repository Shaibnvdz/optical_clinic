<?php
// Assuming you have a database connection
require 'config.php';
include('admin-sidebar.php');

// Fetch payment history from the database
$paymentHistoryQuery = "SELECT * FROM appointments";
$paymentHistoryResult = mysqli_query($conn, $paymentHistoryQuery);

if (!$paymentHistoryResult) {
    die("Error in SQL query: " . mysqli_error($conn));
}

if(isset($_POST['search_button'])){
    $search_tag = $_POST['search_tag'];
    $query = "SELECT * FROM appointments WHERE user_id = '$search_tag'";
    $result = mysqli_query($conn, $query);
}

else{
    $paymentHistoryQuery = "SELECT * FROM appointments";
    $result = mysqli_query($conn, $paymentHistoryQuery);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment History</title>
    <style>
        body {
            margin: 0;
            color: #40596b;
            background-color: white;
        }

        *{
            font-family: poppins;
        }

        table {
            position: absolute;
            border-collapse: collapse;
            width: 70%;
            margin-left: 380px;
            margin-top: 250px;
            padding: 8px;
            text-align: center
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        .text1{
            margin-top: 0px;
            margin-left: 650px;
            position: absolute;
            color: #f89819;
            background-color: white;
            box-shadow: 0px 2px 3px 0px rgba(187, 187, 187, 0.5);
            padding: 10px;
            border-bottom-right-radius: 30px;                
            border-bottom-left-radius: 30px;
            font-size: 60px;
        }

        #patient-history{
                background-color: #f4f4f4;
                font-weight: 600;
            }
        
            .search-container{
                position: absolute;
                margin-left: 380px;
                margin-top: 210px;
            }

    </style>
</head>
<body>

    <h2 class="text1">PATIENT HISTORY</h2>

    <table>
        <thead>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Date</th>
                <th>Time</th>
                <th>Purpose</th>
                <th>Status</th>
                
            </tr>
        </thead>
        <tbody>
            <?php
            // Display patient history dynamically
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['user_id']}</td>";
                echo "<td>{$row['name']}</td>";
                echo "<td>{$row['email']}</td>";
                echo "<td>{$row['date']}</td>";
                echo "<td>{$row['time']}</td>";
                echo "<td>{$row['purpose']}</td>";
                echo "<td>{$row['status']}</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <form method="post" action="">
        <div class="search-container">
            <input type="text" class="search-input" id="search_tag" placeholder="Search..." name="search_tag">
            <button class="search-button" name="search_button">Search</button>
        </div>
        </form>
</body>
</html>
