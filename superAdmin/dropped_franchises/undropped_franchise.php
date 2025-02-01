<?php
// For error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include "../include/db_conn.php";

// Check if POST data is set
if (isset($_POST['id']) && isset($_POST['TFno'])) {
    $id = $_POST['id'];
    $TFno = $_POST['TFno']; // TFno should be passed from the frontend

    // Get the current user (admin/super admin) from session
    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'unknown_user';
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'username';
    $accountType = isset($_SESSION['account_type']) ? $_SESSION['account_type'] : 'admin'; // Default to 'admin' if not set

    $tables = [
        'jan_operators',
        'feb_operators',
        'march_operators',
        'apr_operators',
        'may_operators',
        'jun_operators',
        'jul_operators',
        'aug_operators',
        'sep_operators',
        'oct_operators'
    ];

    $success = true;
    $errors = [];

    foreach ($tables as $table) {
        // Prepare query
        $query = "UPDATE $table SET drop_franchise = NULL, reason_drop = NULL, dropping_date = NULL WHERE id = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            $errors[] = "Failed to prepare statement for table $table: " . $conn->error;
            $success = false;
            continue;
        }

        // Bind the single 'id' parameter
        $stmt->bind_param('i', $id);

        // Execute the query and check if it was successful
        if (!$stmt->execute()) {
            $errors[] = "Failed to execute query for table $table: " . $stmt->error;
            $success = false;
        }

        $stmt->close();
    }

    // Log the action in logs_history table
    if ($success) {
        // Concatenate franchise number in the action description
        $action = "UnDropped Franchise No: $TFno"; // Action performed
        $dateTime = date('Y-m-d H:i:s'); // Current date and time

        // Prepare the log query
        $logQuery = "INSERT INTO logs_history (user_id, action, franchise_no, date_time, username, account_type) VALUES (?, ?, ?, ?, ?, ?)";
        $logStmt = $conn->prepare($logQuery);

        if ($logStmt) {
            // Bind parameters for the log insertion
            $logStmt->bind_param('ssssss', $userId, $action, $TFno, $dateTime, $username, $accountType);

            // Execute the log statement
            if (!$logStmt->execute()) {
                $errors[] = "Failed to insert log entry: " . $logStmt->error;
                $success = false;
            }

            $logStmt->close();
        } else {
            $errors[] = "Failed to prepare log statement: " . $conn->error;
            $success = false;
        }

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'errors' => $errors]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Missing parameters']);
}

$conn->close();
?>
