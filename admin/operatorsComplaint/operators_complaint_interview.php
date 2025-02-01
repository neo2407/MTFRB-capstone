<?php
// Include database connection
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
