<?php
// Include database connection
include "../../include/db_conn.php";

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set content type to JSON
header('Content-Type: application/json');

// Check if id and month are set and not empty
if (isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['month']) && !empty($_POST['month'])) {
    $id = $_POST['id'];
    $month = $_POST['month'];

    // Mapping month to table names
    $tableMap = [
        'January' => 'jan_operators',
        'February' => 'feb_operators',
        'March' => 'mar_operators',
        'April' => 'apr_operators',
        'May' => 'may_operators',
        'June' => 'jun_operators',
        'July' => 'jul_operators',
        'August' => 'aug_operators',
        'September' => 'sep_operators',
        'October' => 'oct_operators'
    ];

    // Determine the table based on the month
    if (array_key_exists($month, $tableMap)) {
        $table = $tableMap[$month];
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid month"]);
        exit;
    }

    // Prepare SQL statement to update specific columns
    $sql = "UPDATE $table 
            SET complaint_interview_stat = NULL, complaint_description = NULL, complaintStatus = 'For Validation', complaint_date = NULL, interview_schedule = NULL 
            WHERE id = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Record updated successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error updating record: " . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Error preparing statement: " . $conn->error]);
    }

    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request: ID or month not set or empty"]);
}
?>
