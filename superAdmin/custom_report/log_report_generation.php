<?php

session_start();
include "../include/db_conn.php";

// Get the POST data
$data = json_decode(file_get_contents('php://input'), true);

$user_id = $data['user_id'];
$account_type = $data['account_type'];
$username = $data['username'];
$action = $data['action']; // This will be "Report generated: reportType"
$startDate = $data['startDate'];
$endDate = $data['endDate'];
$reportType = $data['reportType'];
$date_time = date('Y-m-d H:i:s');
$franchise_no = isset($_SESSION['franchise_no']) ? $_SESSION['franchise_no'] : null;

// Prepare the SQL query to log the action
$logQuery = "INSERT INTO logs_history (user_id, action, franchise_no, date_time, account_type, username) VALUES (?, ?, ?, ?, ?, ?)";
if ($logStmt = $conn->prepare($logQuery)) {
    $logStmt->bind_param("isssss", $user_id, $action, $franchise_no, $date_time, $account_type, $username);
    $logStmt->execute();
    $logStmt->close();
    echo json_encode(['success' => true]); // Send success response
} else {
    echo json_encode(['success' => false]); // Send failure response
}
?>