<?php
session_start();
include "../include/db_conn.php";

function areAllFilesValid($conn, $id) {
    $sql = "SELECT operatorsPicStatus, valid_idStatus, driversPic1Status, 
             licenseStatus, crStatus, orStatus, tricyclePicsStatus
            FROM applicants WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    foreach ($row as $status) {
        if ($status !== 'Valid') {
            return false;
        }
    }
    return true;
}


if (isset($_POST['id']) && isset($_POST['status']) ) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $denialReason = isset($_POST['denialReason']) ? $_POST['denialReason'] : null; // Check if denialReason is provided

    if ($status === 'Verified') {
        // Check if files are valid
        if (!areAllFilesValid($conn, $id)) {
            $response = ["status" => "warning", "message" => "Primary Requirements must be marked as valid before updating the applicant status to Verified."];
            error_log(json_encode($response)); 
            echo json_encode($response);
            exit();
        }
        
        
        
        // Check if interview_sched is not null
        $interview_sql = "SELECT interview_sched FROM applicants WHERE id = ?";
        $interview_stmt = $conn->prepare($interview_sql);
        $interview_stmt->bind_param("i", $id);
        $interview_stmt->execute();
        $interview_stmt->bind_result($interview_sched);
        $interview_stmt->fetch();
        $interview_stmt->close();

        if (empty($interview_sched)) {
            $response = ["status" => "warning", "message" => "Interview schedule must be set before updating the applicant status to Verified."];
            error_log(json_encode($response));
            echo json_encode($response);
            exit();
        }
    }

    // Fetch the applicant's first name and last name
    $applicant_sql = "SELECT first_name, last_name FROM applicants WHERE id = ?";
    $applicant_stmt = $conn->prepare($applicant_sql);
    $applicant_stmt->bind_param("i", $id);
    $applicant_stmt->execute();
    $applicant_stmt->bind_result($first_name, $last_name);
    $applicant_stmt->fetch();
    $applicant_stmt->close();

    // Update the status and reason_denial (if applicable) in the database
    $sql = "UPDATE applicants SET applicantStatus = ?, reason_denial = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    // If the status is "Denied", we add the denial reason; otherwise, we pass NULL
    $stmt->bind_param("ssi", $status, $denialReason, $id); // Binding the denial reason if available

    if ($stmt->execute()) {
        // Insert a notification for the status update
        $notification_message = "Applicant $first_name $last_name's status updated to $status";
        $notification_sql = "INSERT INTO notifications (message, seen) VALUES (?, 0)";
        $notif_stmt = $conn->prepare($notification_sql);
        $notif_stmt->bind_param("s", $notification_message);

        if ($notif_stmt->execute()) {
            // Insert into logs_history
            $user_id = $_SESSION['user_id']; // Get the logged-in user id (you should adjust this based on your session or auth system)
            $action = "Applicant ID:'$id' application status updated to '$status'";
            $franchise_no = ''; // If needed, set the franchise number or leave empty
            $date_time = date('Y-m-d H:i:s');
            $account_type = $_SESSION['account_type']; // If needed, set the account type or leave empty
            $username = $_SESSION['username']; // If needed, set the username or leave empty

            $log_sql = "INSERT INTO logs_history (user_id, action, franchise_no, date_time, account_type, username) 
                        VALUES (?, ?, ?, ?, ?, ?)";
            $log_stmt = $conn->prepare($log_sql);
            $log_stmt->bind_param("isssss", $user_id, $action, $franchise_no, $date_time, $account_type, $username);

            if ($log_stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Applicant status updated successfully and logged"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Status updated, but error adding log: " . $conn->error]);
            }

            $log_stmt->close();
        } else {
            echo json_encode(["status" => "error", "message" => "Status updated, but error adding notification: " . $conn->error]);
        }

        $notif_stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Error updating status: " . $conn->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}
?>
