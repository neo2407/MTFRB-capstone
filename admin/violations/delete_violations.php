<?php
session_start();
include "../../include/db_conn.php";

// Set content type to JSON
header('Content-Type: application/json');

$response = array();

if (isset($_POST["ticketNo"])) { // Use POST instead of GET
    $ticketNo = $_POST["ticketNo"];

    // Prepare the SQL statement for deletion
    $sqlDelete = "DELETE FROM `violations` WHERE ticketNo = ?";
    $stmtDelete = mysqli_prepare($conn, $sqlDelete);

    if ($stmtDelete) {
        // Bind the parameter
        mysqli_stmt_bind_param($stmtDelete, "i", $ticketNo);

        // Execute the statement
        mysqli_stmt_execute($stmtDelete);

        // Check if the deletion was successful
        if (mysqli_stmt_affected_rows($stmtDelete) > 0) {
            $response['success'] = true;
            $response['message'] = 'Data deleted successfully';

            // Log the action in logs_history table
            if (isset($_SESSION['user_id'], $_SESSION['account_type'], $_SESSION['username'])) {
                $user_id = $_SESSION['user_id'];
                $account_type = $_SESSION['account_type'];
                $username = $_SESSION['username'];
                $date_time = date('Y-m-d H:i:s');
                $action = "Violation record with ticketNo $ticketNo was deleted.";
                $franchise_no = isset($_SESSION['franchise_no']) ? $_SESSION['franchise_no'] : null;

                $logQuery = "INSERT INTO logs_history (user_id, action, franchise_no, date_time, account_type, username) VALUES (?, ?, ?, ?, ?, ?)";
                if ($logStmt = $conn->prepare($logQuery)) {
                    $logStmt->bind_param("isssss", $user_id, $action, $franchise_no, $date_time, $account_type, $username);
                    $logStmt->execute();
                    $logStmt->close();
                } else {
                    $response['log_error'] = 'Failed to log the action: ' . $conn->error;
                }
            } else {
                $response['log_error'] = 'Session data missing for logging.';
            }
        } else {
            $response['success'] = false;
            $response['message'] = 'Data not deleted';
        }

        // Close the statement
        mysqli_stmt_close($stmtDelete);
    } else {
        $response['success'] = false;
        $response['message'] = 'Failed: ' . mysqli_error($conn);
    }
} else {
    $response['success'] = false;
    $response['message'] = 'Invalid request.';
}

// Close the database connection
mysqli_close($conn);

// Send the JSON response
echo json_encode($response);
?>
