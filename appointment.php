                                                                          
<?php
include("navbar.php");
session_start();
 
if (!isset($_SESSION["user_id"])) {
    echo "<script> alert('Please Login To Book an Appointment.'), window.location.href='index.php' </script>";
    exit;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mysqli = require __DIR__ . "/database.php"; // Replace with your database connection code

// Include the Composer autoloader
require 'vendor/autoload.php';

$user_id = $_SESSION["user_id"];

// Fetch user data from the database
$sql = "SELECT * FROM user WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();


$is_appointment_booked = false;
$error_message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $appointment_date = $_POST["appointment_date"];
    $appointment_time = $_POST["appointment_time"];
    $appointment_purpose = $mysqli->real_escape_string($_POST["appointment_purpose"]);

    // Check if the selected date is in the past
    if (strtotime($appointment_date) < strtotime(date('Y-m-d'))) {
        $error_message = "<script> alert('Cannot book appointments for past dates. Please choose a future date.'), window.location.href='appointment.php' </script>";
    } else {
        // Check if the selected date is a weekend (Saturday or Sunday)
        $selected_day = date('N', strtotime($appointment_date));
        if ($selected_day >= 6) {
            $error_message = "<script> alert('Appointments cannot be booked on weekends. Please choose a weekday.'), window.location.href='appointment.php' </script>";
        } else {
            // Calculate the end time of the appointment (2 hours duration)
            $end_time = date('H:i:s', strtotime($appointment_time) + 2 * 60 * 60);

            // Check if the selected date and time are available and meet the constraints
            $availability_query = "
                SELECT * FROM appointments
                WHERE user_id = ? AND date = ? AND
                ((TIME(time) <= ? AND ADDTIME(TIME(time), '02:00:00') > ?) OR (TIME(time) >= ? AND TIME(time) < ?))
                AND DAYOFWEEK(date) BETWEEN 2 AND 6 -- Monday to Friday
            ";
            $availability_stmt = $mysqli->prepare($availability_query);
            $availability_stmt->bind_param("isssss", $user_id, $appointment_date, $appointment_time, $appointment_time, $appointment_time, $end_time);
            $availability_stmt->execute();
            $availability_result = $availability_stmt->get_result();

            if ($availability_result->num_rows > 0) {
                $error_message = "<script> alert('You already have an appointment at the selected date and time. Please choose another slot.'), window.location.href='appointment.php' </script>";
            } else {
                // Insert appointment into the database with status 'pending'
                $insert_query = "INSERT INTO appointments (user_id, name, email, date, time, purpose, status) VALUES (?, ?, ?, ?, ?, ?, 'pending')";
                $insert_stmt = $mysqli->prepare($insert_query);
                $insert_stmt->bind_param("isssss", $user_id, $user["name"], $user["email"], $appointment_date, $appointment_time, $appointment_purpose);

                if ($insert_stmt->execute()) {
                    $is_appointment_booked = true;

                    // Send email to admin using PHPMailer with SMTP
                    $mail = new PHPMailer(true);

                    try {
                        $mail->isSMTP();  // Set mailer to use SMTP
                        $mail->Host = 'smtp.gmail.com';  // Specify your SMTP server
                        $mail->SMTPAuth = true;
                        $mail->Username = 'optimalopticsclinic@gmail.com';  // SMTP username
                        $mail->Password = 'lzakfapcaxpyncbw';  // SMTP password
                        $mail->SMTPSecure = 'tls';  // Enable encryption, 'ssl' also accepted
                        $mail->Port = 587;  // TCP port to connect to

                        $mail->setFrom($user["email"], $user["name"]);
                        $mail->addAddress('shairamae.benavidez.m@bulsu.edu.ph', 'Admin');  // Add the admin's email and name
                        $mail->Subject = 'New Appointment Booked';
                        $mail->Body = 'A new appointment has been booked by ' . $user["name"] . '. Check the admin panel for details.';

                        $mail->send();
                    } catch (Exception $e) {
                        echo "Error sending email: " . $mail->ErrorInfo;
                    }
                } else {
                    $error_message = "Error booking appointment: " . $insert_stmt->error;
                }
            }
        }
    }
}

// Fetch all approved appointments
$approved_appointments_sql = "SELECT date, time, name, purpose FROM appointments WHERE status = 'approved'";
$stmt_approved_appointments = $mysqli->prepare($approved_appointments_sql);
$stmt_approved_appointments->execute();
$stmt_approved_appointments->bind_result($date, $time, $name, $purpose);
$approved_appointments = [];
while ($stmt_approved_appointments->fetch()) {
    $approved_appointments[] = [
        'title' => "Booked",
        'start' => "$date $time",
        'end' => date('Y-m-d H:i:s', strtotime("$date $time +2 hours")), // Set the end time 2 hours after the start time
        'allDay' => false,
        'className' => 'booked-event'
    ];
}

$host = "localhost";
$username = "root";
$password = "";
$dbname = "opticaldb";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM `design` WHERE `id` = 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>

    
    <!-- Include FullCalendar CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.css" />

    <!-- Include FullCalendar JS dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.js"></script>

    <!-- Include FullCalendar Scheduler extension -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@5.x.x/dist/scheduler.css" />

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <!-- Include Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    

    <style>
        #calendar {
        height: 550px; /* Set the height to your desired value (e.g., 600px) */
        width: 500px;
        background-color: white;
        padding: 5px;
        box-shadow: 0px 2px 3px 0px rgba(187, 187, 187, 0.5);
    }

    .calendar{
        margin-left: 300px;
        margin-top: 50px;
    }

    form{
        position: absolute;
        margin-left: 600px;
        margin-top: -500px;
        line-height: 3;
        background-color: white;
        padding: 10px;
        box-shadow: 0px 2px 3px 0px rgba(187, 187, 187, 0.5);
    }

    .btn-appointment{
            margin-left: 95px;
            margin-top: 20px;
            border: none;
            background-color: #f89819;
            color: white;
            font-weight: 500;
            padding: 10px;
            border-radius: 8px;
    }

    label{
            font-weight: 500;
    }

    h2{
            line-height: 1;
    }

    </style>
</head>
<body>
    
       
<div class="calendar">
    <h1>Book Appointment</h1>

    <?php if ($is_appointment_booked): ?>
        <script> alert('Appointment booked successfully! Wait for the admin approval.'), window.location.href='appointment.php' </script>
    <?php elseif ($error_message): ?>
        <p class="error"><?php echo $error_message; ?></p>
    <?php endif; ?>
<div id="calendar"></div>
    <form method="post">
        <h2>Appointment Request Form</h2>
        <hr>
        <label for="appointment_date">Appointment Date:</label>
        <!-- Replace input type="date" with Flatpickr -->
        <input type="text" id="appointment_date" class="flatpickr" name="appointment_date" required>

        <br>

<label for="appointment_time">Appointment Time:</label>
<!-- Use a dropdown select for appointment time -->
<select name="appointment_time" required>
    <?php
    // Generate time slots from 8 am to 5 pm with a 2-hour interval
    $start_time = strtotime("08:00:00");
    $end_time = strtotime("17:00:00");
    $interval = 2 * 60 * 60; // 2 hours in seconds

    while ($start_time < $end_time) {
        $formatted_start_time = date("H:i:s", $start_time);
        $formatted_end_time = date("H:i:s", $start_time + $interval);
        $formatted_range = "$formatted_start_time - $formatted_end_time";

        echo "<option value=\"$formatted_range\">$formatted_range</option>";
        $start_time += $interval;
    }
    ?>
</select>

<br>


        <label for="appointment_purpose">Appointment Purpose:</label>
        <textarea name="appointment_purpose" rows="4" required></textarea>
        <br>

        <input class="btn-appointment" type="submit" value="Book Appointment">
    </form>
    </div>

    

    <!-- Initialize FullCalendar -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                selectable: true,
                select: function (arg) {
                    var formattedStart = moment(arg.start).format("YYYY-MM-DD");
                    document.getElementById('appointment_date').value = formattedStart;
                },
                events: <?php echo json_encode($approved_appointments); ?>,
                eventContent: function (arg) {
                    var div = document.createElement('div');
                    div.innerHTML = arg.event.title;
                    div.classList.add('booked-event');
                    return { domNodes: [div] };
                }
            });

            calendar.render();
        });
        console.log(<?php echo json_encode($approved_appointments); ?>);
    </script>
</body>
</html>
