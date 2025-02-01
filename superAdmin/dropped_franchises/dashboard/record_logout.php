<?php
session_start();
date_default_timezone_set('Asia/Manila');
include '../include/db_conn.php'; 

if (isset($_SESSION['user_id'])) {
    if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
        $user_id = $_SESSION['user_id'];
        $logout_time = date('Y-m-d H:i:s');

        // Update logout time in the logs
        $stmt = $conn->prepare("
            UPDATE logs 
            SET logout_time = ? 
            WHERE user_id = ? AND login_status = 'Success' 
            ORDER BY login_time DESC LIMIT 1
        ");

        if ($stmt) {
            $stmt->bind_param("si", $logout_time, $user_id);
            if ($stmt->execute()) {
                error_log("Logout time recorded for user ID: $user_id at $logout_time.");
            } else {
                error_log("Error updating logout time: " . $stmt->error);
            }
            $stmt->close(); // Close the prepared statement
        } else {
            error_log("Prepare failed: " . $conn->error);
        }

        // Optional: Destroy the session or handle post-logout redirection here
         session_destroy();
    }
} else {
    // Redirect if there is no active session
    header('Location: ../superAdmin_login.php');
    exit();
}
?>
