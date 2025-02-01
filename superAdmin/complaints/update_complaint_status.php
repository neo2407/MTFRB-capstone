<?php
include "../../include/db_conn.php";
session_start();

if (isset($_POST['id']) && isset($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $dismissalReason = isset($_POST['dismissalReason']) ? $_POST['dismissalReason'] : null;

    // Fetch the complainant's first name and last name
    $complaint_sql = "SELECT first_name, last_name FROM complaints WHERE id = ?";
    $complaint_stmt = $conn->prepare($complaint_sql);
    if (!$complaint_stmt) {
        echo json_encode(["status" => "error", "message" => "Failed to prepare fetch query"]);
        exit;
    }
    $complaint_stmt->bind_param("i", $id);
    $complaint_stmt->execute();
    $complaint_stmt->bind_result($first_name, $last_name);
    $complaint_stmt->fetch();
    $complaint_stmt->close();

    // Update the status and reason_dismissal (if applicable)
    $sql = "UPDATE complaints SET complaintStatus = ?, reason_dismissal = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => "Failed to prepare update query"]);
        exit;
    }

    $stmt->bind_param("ssi", $status, $dismissalReason, $id);

    if (!$stmt->execute()) {
        echo json_encode(["status" => "error", "message" => "Failed to execute update query"]);
        exit;
    }

    $stmt->close();

    // Log the action in the logs_history table
    if (isset($_SESSION['user_id'], $_SESSION['account_type'], $_SESSION['username'])) {
        $user_id = $_SESSION['user_id'];
        $account_type = $_SESSION['account_type'];
        $username = $_SESSION['username'];
        $date_time = date('Y-m-d H:i:s');
        $action = "Complaint status updated for ID $id to '$status'.";
        $franchise_no = isset($_SESSION['franchise_no']) ? $_SESSION['franchise_no'] : null;

        $logQuery = "INSERT INTO logs_history (user_id, action, franchise_no, date_time, account_type, username) VALUES (?, ?, ?, ?, ?, ?)";
        $logStmt = $conn->prepare($logQuery);
        if ($logStmt) {
            $logStmt->bind_param("isssss", $user_id, $action, $franchise_no, $date_time, $account_type, $username);
            $logStmt->execute();
            $logStmt->close();
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to prepare log insertion query"]);
            exit;
        }
    } else {
        echo json_encode(["status" => "error", "message" => "User session details are missing"]);
        exit;
    }

    $conn->close();
    echo json_encode(["status" => "success", "message" => "Complaint status updated and logged successfully!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}
?>
