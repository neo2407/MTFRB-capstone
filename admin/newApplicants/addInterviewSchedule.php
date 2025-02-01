<?php
include "../include/db_conn.php";

// Check if session variables are set
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['account_type']) || !isset($_SESSION['username'])) {
    echo "Session variables are not set properly.";
    exit();
}

if (isset($_POST['id']) && isset($_POST['interview_sched'])) {
    $id = $_POST['id'];
    $interview_sched = $_POST['interview_sched'];

    if (!empty($interview_sched)) {
        try {
            // Create a DateTime object from the input
            $dateTime = new DateTime($interview_sched);
            // Format the DateTime object to 12-hour format with AM/PM
            $formattedDateTime = $dateTime->format('Y-m-d h:i A');

            // Prepare the SQL statement to update the interview schedule
            $stmt = $conn->prepare("UPDATE applicants SET interview_sched = ? WHERE id = ?");
            if ($stmt === false) {
                echo "Error preparing statement: " . $conn->error;
                exit();
            }
            $stmt->bind_param("si", $formattedDateTime, $id);

            if ($stmt->execute()) {
                echo "Interview schedule added successfully";

                // Prepare the log entry
                $action = "Interview schedule:($formattedDateTime) for Applicant ID: ($id) added";
                $user_id = $_SESSION['user_id']; // Assuming user_id is stored in the session
                $franchise_no = NULL; // Replace with the appropriate value if applicable
                $account_type = $_SESSION['account_type']; // Assuming account_type is stored in the session
                $username = $_SESSION['username']; // Assuming username is stored in the session
                $currentDateTime = date('Y-m-d H:i:s'); // Current timestamp

                // Insert into logs_history table
                $log_stmt = $conn->prepare("INSERT INTO logs_history (user_id, action, franchise_no, date_time, account_type, username) VALUES (?, ?, ?, ?, ?, ?)");
                if ($log_stmt === false) {
                    echo "Error preparing log statement: " . $conn->error;
                    exit();
                }
                $log_stmt->bind_param("isssss", $user_id, $action, $franchise_no, $currentDateTime, $account_type, $username);

                if ($log_stmt->execute()) {
                    echo "Log added successfully";
                } else {
                    echo "Error logging action: " . $conn->error;
                }

                $log_stmt->close();
            } else {
                echo "Error updating record: " . $conn->error;
            }

            $stmt->close();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Interview schedule is empty";
    }
} else {
    echo "Required POST variables are missing.";
}

$conn->close();
?>
