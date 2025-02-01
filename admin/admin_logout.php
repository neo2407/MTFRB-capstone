<?php
// Set time zone
date_default_timezone_set('Asia/Manila');

// database connection
include "include/db_conn.php";

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $logout_time = date('Y-m-d H:i:s'); // Current date and time

    // Ensure $conn is properly initialized
    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    // Prepare and execute the statement to update logout time
    $stmt = $conn->prepare("UPDATE logs SET logout_time = ? WHERE user_id = ? AND login_time IS NOT NULL ORDER BY login_time DESC LIMIT 1");

    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("si", $logout_time, $user_id);

    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }

    // Close the statement
    $stmt->close();

    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session
    session_unset();
    session_destroy();

    // Redirect to the login page after logout
    header("Location: admin_login.php");
    exit();
} else {
    // Redirect to the login page 
    header("Location: admin_login.php");
    exit();
}
?>