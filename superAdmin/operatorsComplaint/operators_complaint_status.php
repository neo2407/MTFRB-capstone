<?php
session_start();
// Include database connection
include "../../include/db_conn.php";

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if id, status, and month are set
if (isset($_POST['id']) && isset($_POST['newstatus']) && isset($_POST['month'])) {
    $id = $_POST['id'];
    $newstatus = $_POST['newstatus'];
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
        // Prepare the SQL to fetch existing data
        $fetch_sql = "SELECT complaint_description, complaint_date, complaintStatus, complaints FROM $table WHERE id = ?";
        if ($fetch_stmt = $conn->prepare($fetch_sql)) {
            $fetch_stmt->bind_param("i", $id);
            $fetch_stmt->execute();
            $result = $fetch_stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $complaint_description = $row['complaint_description'];
                $complaint_date = $row['complaint_date'];
                $complaintStatus = $row['complaintStatus'];
                $existing_complaints = $row['complaints'] ? json_decode($row['complaints'], true) : [];

                // Check if a complaint with the same description exists and update its status
                $updated = false;
                foreach ($existing_complaints as &$complaint) {
                    if ($complaint['description'] == $complaint_description) {
                        $complaint['status'] = $newstatus; // Update status with the new value
                        $updated = true;
                        break;
                    }
                }

                // If no matching complaint found, add a new one
                if (!$updated) {
                    $new_complaint = [
                        "description" => $complaint_description,
                        "date" => $complaint_date,
                        "status" => $newstatus
                    ];
                    $existing_complaints[] = $new_complaint;
                }

                $updated_complaints_json = json_encode($existing_complaints);
            } else {
                echo json_encode(["status" => "error", "message" => "Record not found"]);
                exit;
            }
            $fetch_stmt->close();
        } else {
            echo json_encode(["status" => "error", "message" => "Error fetching data: " . $conn->error]);
            exit;
        }

        // Update complaintStatus and complaints
        $update_sql = "UPDATE $table SET complaintStatus = ?, complaints = ? WHERE id = ?";
        if ($update_stmt = $conn->prepare($update_sql)) {
            $update_stmt->bind_param("ssi", $newstatus, $updated_complaints_json, $id);
            if ($update_stmt->execute()) {
                
                 // Log the action in logs_history table
            $user_id = $_SESSION['user_id'];
            $account_type = $_SESSION['account_type'];
            $username = $_SESSION['username'];
            $date_time = date('Y-m-d H:i:s');
            $action = "Updated Complaint Status with complaint ID $id";
            $franchise_no = isset($_SESSION['franchise_no']) ? $_SESSION['franchise_no'] : null;

            $logQuery = "INSERT INTO logs_history (user_id, action, franchise_no, date_time, account_type, username) VALUES (?, ?, ?, ?, ?, ?)";
            if ($logStmt = $conn->prepare($logQuery)) {
                $logStmt->bind_param("isssss", $user_id, $action, $franchise_no, $date_time, $account_type, $username);
                $logStmt->execute();
                $logStmt->close();
            }
                echo json_encode(["status" => "success", "message" => "Complaint Status updated successfully"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error updating data: " . $update_stmt->error]);
            }
            $update_stmt->close();
        } else {
            echo json_encode(["status" => "error", "message" => "Error preparing update statement: " . $conn->error]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid month"]);
    }

    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}
?>
