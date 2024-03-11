<?php
// Assuming you have a database connection
require 'config.php';
include('admin-sidebar.php');

// Fetch payment history from the database
$paymentHistoryQuery = "SELECT * FROM payment_history";
$paymentHistoryResult = mysqli_query($conn, $paymentHistoryQuery);

if (!$paymentHistoryResult) {
    die("Error in SQL query: " . mysqli_error($conn));
}

// Check if the search form is submitted
if(isset($_POST['search_button'])){
    // Retrieve search parameters
    $search_tag = mysqli_real_escape_string($conn, $_POST['search_tag']);
    $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);

    // Build the query with filters
    $query = "SELECT * FROM payment_history WHERE user_id = '$search_tag'";

    // Add start date filter if provided
    if (!empty($start_date)) {
        $query .= " AND orderDate >= '$start_date'";
    }

    // Add end date filter if provided
    if (!empty($end_date)) {
        $query .= " AND orderDate <= '$end_date'";
    }

    // Execute the query
    $result = mysqli_query($conn, $query);
}

else{
    $paymentHistoryQuery = "SELECT * FROM payment_history";
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
            margin-left: 375px;
            margin-top: 200px;
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
            margin-left: 620px;
            position: absolute;
            color: #f89819;
            background-color: white;
            box-shadow: 0px 2px 3px 0px rgba(187, 187, 187, 0.5);
            padding: 10px;
            border-bottom-right-radius: 30px;                
            border-bottom-left-radius: 30px;
            font-size: 60px;
        }

        #payment-history{
            background-color: #f4f4f4;
            font-weight: 600;
            }

            .search-container{
                position: absolute;
                margin-left: 376px;
                margin-top: 160px;
            }

            button{
            border-radius: 5px;
                border: none;
                color: white !important;
                background-color: #f89819;
                font-weight: 600;
                height:30px ;
                width: 90px;
                text-transform: uppercase;
                margin-left: 15px;
        }
    </style>
</head>
<body>

    <h2 class="text1">PAYMENT HISTORY</h2>

    <table>
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Date</th>
                <th>Time</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total Amount</th>
                <th>User ID</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Display payment history dynamically
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['transactionID']}</td>";
                echo "<td>{$row['orderDate']}</td>";
                echo "<td>{$row['time']}</td>";
                echo "<td>{$row['product_name']}</td>";
                echo "<td>₱{$row['price']}.00</td>";
                echo "<td>{$row['quantity']}</td>";
                echo "<td>₱{$row['total_amount']}.00</td>";
                echo "<td>{$row['user_id']}</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <form method="post" action="">
        <div class="search-container">
            
        </div>
        </form>

        <form method="post" action="">
        <div class="search-container">
            <input type="text" class="search-input" id="search_tag" placeholder="User ID..." name="search_tag">
            <input type="date" class="date-input" id="start_date" name="start_date" placeholder="Start Date">
            <input type="date" class="date-input" id="end_date" name="end_date" placeholder="End Date">
            <button class="search-button" name="search_button">Search</button>
        </div>
    </form>
</body>
</html>
