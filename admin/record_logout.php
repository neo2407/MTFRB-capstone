<?php
if (!include 'db_conn.php') {
    die('Error including db_conn.php');
}
session_start();
include 'include/db_conn.php'; // Ensure this points to your DB connection setup

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $logout_time = date('Y-m-d H:i:s'); // Current time

    $stmt = $conn->prepare("
        UPDATE logs 
        SET logout_time = ? 
        WHERE user_id = ? AND login_status = 'Success' 
        ORDER BY login_time DESC LIMIT 1
    ");
    if ($stmt) {
        $stmt->bind_param("si", $logout_time, $user_id);
        $stmt->execute();
    } else {
        error_log("Prepare failed: " . $conn->error);
    }
    
    // Destroy session
    session_destroy();
}
?>
