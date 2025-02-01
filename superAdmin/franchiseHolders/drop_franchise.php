<?php
// For error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include "../include/db_conn.php";

// Check if POST data is set
if (isset($_POST['id']) && isset($_POST['drop_franchise']) && isset($_POST['TFno'])) {
    $id = $_POST['id'];
    $TFno = $_POST['TFno'];
    $dropFranchise = $_POST['drop_franchise'];

    // Get the current date and time
    $droppingDate = date('Y-m-d H:i:s');

    // Get the current user (admin/super admin) from session
    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'unknown_user'; // Replace 'unknown_user' if not found

    // Assuming 'account_type' is part of the session or query, if not, set a default value
    $accountType = isset($_SESSION['account_type']) ? $_SESSION['account_type'] : 'admin'; // Default 'admin' or fetch from session
    
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'username'; 

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
        // Prepare the query for updating the franchise status
        $query = "UPDATE $table SET drop_franchise = ?, dropping_date = ? WHERE id = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            $errors[] = "Failed to prepare statement for table $table: " . $conn->error;
            $success = false;
            continue;
        }

        // Bind parameters
        $stmt->bind_param('ssi', $dropFranchise, $droppingDate, $id);

        // Execute the query and check if it was successful
        if (!$stmt->execute()) {
            $errors[] = "Failed to execute query for table $table: " . $stmt->error;
            $success = false;
        }

        $stmt->close();
    }

    // Log the action in the logs history table
    if ($success) {
        $logQuery = "INSERT INTO logs_history (user_id, action, franchise_no, date_time, account_type, username) VALUES (?, ?, ?, ?, ?, ?)";
        $logStmt = $conn->prepare($logQuery);

        if ($logStmt) {
            // Concatenate the franchise number with the action
            $action = "Dropped Franchise No: $TFno";
            $logStmt->bind_param('ssssss', $userId, $action, $TFno, $droppingDate, $accountType, $username);

            if (!$logStmt->execute()) {
                $errors[] = "Failed to insert log entry: " . $logStmt->error;
                $success = false;
            }

            $logStmt->close();
        } else {
            $errors[] = "Failed to prepare log statement: " . $conn->error;
            $success = false;
        }

        echo json_encode(['success' => $success, 'errors' => $errors]);
    } else {
        echo json_encode(['success' => false, 'errors' => $errors]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Missing parameters']);
}

$conn->close();
