<?php
// get_appointment_history.php

// Assuming you have a database connection
require 'config.php';

// Check if user_id is set in the request
if (isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];

    // Fetch appointment history for the specified user
    $appointmentHistoryQuery = "SELECT * FROM appointments WHERE user_id = '$userId'";
    $appointmentHistoryResult = mysqli_query($conn, $appointmentHistoryQuery);

    if ($appointmentHistoryResult) {
        echo '<h2>Appointment History</h2>';
        echo '<table>';
        echo '<thead><tr><th>Appointment ID</th><th>Date</th><th>Details</th></tr></thead>';
        echo '<tbody>';

        while ($row = mysqli_fetch_assoc($appointmentHistoryResult)) {
            echo '<tr>';
            echo '<td>' . $row['appointment_id'] . '</td>';
            echo '<td>' . $row['appointment_date'] . '</td>';
            echo '<td>' . $row['appointment_details'] . '</td>';
            echo '</tr>';
        }

        echo '</tbody></table>';
    } else {
        echo 'Error in SQL query: ' . mysqli_error($conn);
    }
} else {
    echo 'User ID not provided.';
}
?>
