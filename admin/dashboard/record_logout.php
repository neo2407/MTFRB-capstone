<?php
// Set time zone
date_default_timezone_set('Asia/Manila');

// Database connection
include "../include/db_conn.php";
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $logout_time = date('Y-m-d H:i:s'); // Current date and time

    if ($conn) {
        // Update the logout time
        $stmt = $conn->prepare("
            UPDATE logs 
            SET logout_time = ? 
            WHERE user_id = ? 
            AND login_time IS NOT NULL 
            ORDER BY login_time DESC LIMIT 1
        ");

        if ($stmt) {
            $stmt->bind_param("si", $logout_time, $user_id);
            $stmt->execute();
            $stmt->close();
        }
    }
}
?>
