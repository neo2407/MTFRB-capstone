<?php
// Include database connection
session_start();
include "../../include/db_conn.php";

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if id, status, and month are set
if (isset($_POST['id']) && isset($_POST['status']) && isset($_POST['month'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $month = ucfirst(strtolower($_POST['month'])); // Capitalize first letter

    // Define table names with full month names
    $tables = [
        'January' => 'jan_operators',
        'February' => 'feb_operators',
        'March' => 'march_operators',
        'April' => 'apr_operators',
        'May' => 'may_operators',
        'June' => 'jun_operators',
        'July' => 'jul_operators',
        'August' => 'aug_operators',
        'September' => 'sep_operators',
        'October' => 'oct_operators'
    ];

    // Get the table name based on the month
    $table = isset($tables[$month]) ? $tables[$month] : null;

    if ($table) {
        // Prepare the SQL statement
        $sql = "UPDATE $table SET complaint_interview_stat = ? WHERE id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("si", $status, $id);

            if ($stmt->execute()) {
                
                     // Log the action in logs_history table
            $user_id = $_SESSION['user_id'];
            $account_type = $_SESSION['account_type'];
            $username = $_SESSION['username'];
            $date_time = date('Y-m-d H:i:s');
            $action = "Updated Complaint Interview Status for complaint  ID $id";
            $franchise_no = isset($_SESSION['franchise_no']) ? $_SESSION['franchise_no'] : null;

            $logQuery = "INSERT INTO logs_history (user_id, action, franchise_no, date_time, account_type, username) VALUES (?, ?, ?, ?, ?, ?)";
            if ($logStmt = $conn->prepare($logQuery)) {
                $logStmt->bind_param("isssss", $user_id, $action, $franchise_no, $date_time, $account_type, $username);
                $logStmt->execute();
                $logStmt->close();
            }
                echo json_encode(["status" => "success", "message" => "Interview Status updated successfully"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error executing query: " . $stmt->error]);
            }

            $stmt->close();
        } else {
            echo json_encode(["status" => "error", "message" => "Error preparing statement: " . $conn->error]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid month"]);
    }

    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}
?>
