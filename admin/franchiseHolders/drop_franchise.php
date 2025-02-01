<?php
// For error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include "../include/db_conn.php";

// Check if POST data is set
if (isset($_POST['id']) && isset($_POST['drop_franchise'])) {
    $id = $_POST['id'];
    $dropFranchise = $_POST['drop_franchise'];

    // Get the current date
    $droppingDate = date('Y-m-d');

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
        // Prepare the query
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

    if ($success) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'errors' => $errors]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Missing parameters']);
}

$conn->close();
