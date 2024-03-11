<?php
// reject_appointment.php

// Include necessary files and start the session if not already started
session_start();

// Include database connection
$mysqli = require __DIR__ . "/database.php";

// Include PHPMailer for sending emails
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Check if the appointment ID is provided in the URL
if (isset($_GET["id"])) {
    $appointment_id = $_GET["id"];

    // Fetch appointment details from the database
    $fetch_appointment_sql = "SELECT user_id, name, email, date, time, purpose FROM appointments WHERE id = ?";
    $stmt_fetch_appointment = $mysqli->prepare($fetch_appointment_sql);
    $stmt_fetch_appointment->bind_param("i", $appointment_id);
    $stmt_fetch_appointment->execute();
    $stmt_fetch_appointment->bind_result($user_id, $name, $email, $date, $time, $purpose);

    if ($stmt_fetch_appointment->fetch()) {
        // Close the first statement
        $stmt_fetch_appointment->close();

        // Update the status of the appointment to 'rejected' in the database
        $update_query = "UPDATE appointments SET status = 'rejected' WHERE id = ?";
        $update_stmt = $mysqli->prepare($update_query);
        $update_stmt->bind_param("i", $appointment_id);

        if ($update_stmt->execute()) {
            // Send email to the user using PHPMailer with SMTP
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();  // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com';  // Specify your SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = 'optimalopticsclinic@gmail.com';  // SMTP username
                $mail->Password = 'lzakfapcaxpyncbw';  // SMTP password
                $mail->SMTPSecure = 'tls';  // Enable encryption, 'ssl' also accepted
                $mail->Port = 587;  // TCP port to connect to

                $mail->setFrom('optimalopticsclinic@gmail.com', 'Admin');  // Replace with your information
                $mail->addAddress($email, $name);  // Add the user's email and name
                $mail->Subject = 'Appointment Rejected';
                $mail->Body = 'Dear Valued Customer, Your appointment on ' . $date . ' at ' . $time . ' has been rejected.';

                $mail->send();

                echo "<script> alert('Appointment rejected successfully. Email sent to user.'), window.location.href='appointment-management.php' </script>";
                exit;
            } catch (Exception $e) {
                echo "Error sending email: " . $mail->ErrorInfo;
            }
        } else {
            echo "Error updating appointment status: " . $update_stmt->error;
        }
    } else {
        echo "Invalid appointment ID.";
    }
} else {
    echo "Invalid appointment ID.";
}
?>
