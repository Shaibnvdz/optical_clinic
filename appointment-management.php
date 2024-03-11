<?php
// admin.php
include ('config.php');
// Include necessary files and start the session if not already started
session_start();
include("admin-sidebar.php");


// Include database connection and other required files
$mysqli = require __DIR__ . "/database.php";
require 'vendor/autoload.php';

// Fetch pending appointments from the database
$pending_appointments_sql = "SELECT id, name, email, date, time, purpose FROM appointments WHERE status = 'pending'";
$stmt_pending_appointments = $mysqli->prepare($pending_appointments_sql);
$stmt_pending_appointments->execute();
$stmt_pending_appointments->bind_result($appointment_id, $name, $email, $date, $time, $purpose);
$pending_appointments = [];
while ($stmt_pending_appointments->fetch()) {
    $pending_appointments[] = [
        'id' => $appointment_id,
        'name' => $name,
        'email' => $email,
        'date' => $date,
        'time' => $time,
        'purpose' => $purpose,
    ];
}


if(isset($_POST['approved'])){
    mysqli_query($conn, "UPDATE appointments SET status = 'approved' WHERE id IN (".implode(', ', $_POST['id']).")");
    echo "<script> alert('Appointment approved successfully.'), window.location.href='appointment-management.php' </script>";  
}
if(isset($_POST['reject'])){
    mysqli_query($conn, "UPDATE appointments SET status = 'rejected' WHERE id IN (".implode(', ', $_POST['id']).")");
    echo "<script> alert('Appointment rejected successfully.'), window.location.href='appointment-management.php' </script>";  
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    <!-- Include any additional CSS or JS files if needed -->

    <style>
        /* Add your custom styles here */
        body{
            margin: 0;
            background-color: white;
            color: #40596b;
        }
        #no-pending{
            position: absolute;
            margin-left: 820px;
            margin-top: 330px;
        }

        #text1{
            position:absolute;
            margin-left: 580px;
            margin-top: 100px;
        }

        #appointments{
            background-color: #f4f4f4;
            font-weight: 600;
        }

        table {
            position:absolute;
            border-collapse: collapse;
            margin-left: 450px;
            margin-top: 250px;
        }
        
        .approved-reject{
            font-weight: 500;
        }

        .button-container{
            position: absolute;
            margin-left: 435px;
            margin-top: 200px;
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
        
        .admin-panel{
            margin-left:90px;
        }

        
    </style>
</head>
<body>
    <div class="admin-panel">
        <h1 class="text-appointment" id="text1">Admin Panel - Appointments</h1>

        <?php if (!empty($pending_appointments)): ?>
           
            <form method="POST">
                <div class="button-container">
                    <button class="approved-reject" name="approved">Approve</button>
                    <button class="approved-reject" name="reject">Reject</button>
                </div>
                

                <table border="1" cellspacing="0" cellpadding="10" >
                    <thead>
                        <tr>
                            <th></th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Purpose</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pending_appointments as $appointment): ?>
                            <tr>
                                <td><input type="checkbox" name="id[]" value="<?php echo $appointment['id']; ?>"></td>
                                <td><?php echo $appointment['id']; ?></td>
                                <td><?php echo $appointment['name']; ?></td>
                                <td><?php echo $appointment['email']; ?></td>
                                <td><?php echo $appointment['date']; ?></td>
                                <td><?php echo $appointment['time']; ?></td>
                                <td><?php echo $appointment['purpose']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </form>
        <?php else: ?>
            <p class="text-appointment" id="no-pending">No pending appointments.</p>
        <?php endif; ?>
    </div>
</body>
</html>
