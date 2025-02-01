<?php
include "../../include/db_conn.php";

if (isset($_POST['id']) && isset($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Fetch the interview date and current status from the database
    $sql = "SELECT interview_sched, interviewStatus FROM applicants WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($interview_sched, $current_status);
    $stmt->fetch();

    if (!$stmt->num_rows) {
        echo json_encode(["status" => "error", "message" => "Applicant not found."]);
        $stmt->close();
        $conn->close();
        exit();
    }

    // Convert interview_sched to DateTime object
    $interview_date = DateTime::createFromFormat('Y-m-d H:i:s', $interview_sched);
    $current_date = new DateTime();

    // Auto-update status if necessary
    if ($interview_date < $current_date && $status !== 'Done') {
        $status = 'Missed';
    }

    // Update the status in the database
    $update_sql = "UPDATE applicants SET interviewStatus = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("si", $status, $id);

    if ($update_stmt->execute()) {
        // Log the action
        session_start();
        $user_id = $_SESSION['user_id'];
        $account_type = $_SESSION['account_type'];
        $username = $_SESSION['username'];
        $date_time = date('Y-m-d H:i:s');
        $action = "Interview status updated to '$status' for applicant ID $id.";
        $franchise_no = isset($_SESSION['franchise_no']) ? $_SESSION['franchise_no'] : null;

        $logQuery = "INSERT INTO logs_history (user_id, action, franchise_no, date_time, account_type, username) VALUES (?, ?, ?, ?, ?, ?)";
        $logStmt = $conn->prepare($logQuery);
        $logStmt->bind_param("isssss", $user_id, $action, $franchise_no, $date_time, $account_type, $username);

        if ($logStmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Status updated and action logged successfully", "newStatus" => $status]);
        } else {
            echo json_encode(["status" => "error", "message" => "Status updated but failed to log the action."]);
        }

        $logStmt->close();
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
