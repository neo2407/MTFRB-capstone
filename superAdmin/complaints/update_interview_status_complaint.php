<?php
include "../../include/db_conn.php";
session_start();

if (isset($_POST['id']) && isset($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Fetch the interview date and current status from the database
    $sql = "SELECT interview_dt, interviewStatus FROM complaints WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($interview_dt, $current_status);
    $stmt->fetch();

    // Convert interview_dt to DateTime object
    $interview_date = DateTime::createFromFormat('Y-m-d H:i:s', $interview_dt);
    $current_date = new DateTime();

    // Auto-update status if necessary
    if ($interview_date < $current_date && $status !== 'Done') {
        $status = 'Missed';
    }

    // Update the status in the database
    $update_sql = "UPDATE complaints SET interviewStatus = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("si", $status, $id);

    if ($update_stmt->execute()) {
        // Log the action into logs_history table
        if (isset($_SESSION['user_id'], $_SESSION['account_type'], $_SESSION['username'])) {
            $user_id = $_SESSION['user_id'];
            $account_type = $_SESSION['account_type'];
            $username = $_SESSION['username'];
            $date_time = date('Y-m-d H:i:s');
            $action = "Updated interview status for complaint ID $id to '$status'.";

            $logQuery = "INSERT INTO logs_history (user_id, action, franchise_no, date_time, account_type, username) VALUES (?, ?, NULL, ?, ?, ?)";
            $logStmt = $conn->prepare($logQuery);
            if ($logStmt) {
                $logStmt->bind_param("issss", $user_id, $action, $date_time, $account_type, $username);
                $logStmt->execute();
                $logStmt->close();
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Session details are missing for logging."]);
            exit;
        }

        echo json_encode(["status" => "success", "message" => "Status updated successfully and logged.", "newStatus" => $status]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update status."]);
    }

    $update_stmt->close();
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
?>
