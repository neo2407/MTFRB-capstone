<?php
session_start();
include "../../include/db_conn.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $uploadDirComplaints = '../../uploads/complaints/';
   
    // Retrieve the file paths from the database
    $sqlSelect = "SELECT evidence FROM `complaints` WHERE id = ?";
    $stmtSelect = mysqli_prepare($conn, $sqlSelect);

    if ($stmtSelect) {
        mysqli_stmt_bind_param($stmtSelect, "i", $id);
        mysqli_stmt_execute($stmtSelect);
        mysqli_stmt_bind_result($stmtSelect, $evidence);
        mysqli_stmt_fetch($stmtSelect);
        mysqli_stmt_close($stmtSelect);

        $complaintsPath =  $uploadDirComplaints . $evidence;
      
        // Unlink (delete) the complaint file
        if (file_exists($complaintsPath)) {
            unlink($complaintsPath);
        }
       
        // Prepare the SQL statement for deletion
        $sqlDelete = "DELETE FROM `complaints` WHERE id = ?";
        $stmtDelete = mysqli_prepare($conn, $sqlDelete);

        if ($stmtDelete) {
            // Bind the parameter
            mysqli_stmt_bind_param($stmtDelete, "i", $id);

            // Execute the statement
            mysqli_stmt_execute($stmtDelete);

            // Check if the deletion was successful
            if (mysqli_stmt_affected_rows($stmtDelete) > 0) {
                $_SESSION['status'] = "Data deleted successfully";
                $_SESSION['status_code'] = "success";

                // Log the action in logs_history
                $user_id = $_SESSION['user_id'];
                $account_type = $_SESSION['account_type'];
                $username = $_SESSION['username'];
                $date_time = date('Y-m-d H:i:s');
                $action = "Complaint deleted for applicant ID:$id";

                $franchise_no = isset($_SESSION['franchise_no']) ? $_SESSION['franchise_no'] : null;

                // Insert log entry into logs_history
                $logQuery = "INSERT INTO logs_history (user_id, action, franchise_no, date_time, account_type, username) VALUES (?, ?, ?, ?, ?, ?)";
                if ($logStmt = $conn->prepare($logQuery)) {
                    $logStmt->bind_param("isssss", $user_id, $action, $franchise_no, $date_time, $account_type, $username);
                    $logStmt->execute();
                    $logStmt->close();
                }

                header('Location: complaintsList.php');
                exit();
            } else {
                $_SESSION['status'] = "Data not deleted";
                $_SESSION['status_code'] = "error";
                header('Location: complaintsList.php');
                exit();
            }

            // Close the statement
            mysqli_stmt_close($stmtDelete);
        } else {
            $_SESSION['msg'] = "Failed: " . mysqli_error($conn);
            header("Location: complaintsList.php");
            exit();
        }
    } else {
        $_SESSION['msg'] = "Failed to retrieve file paths: " . mysqli_error($conn);
        header("Location: complaintsList.php");
        exit();
    }
} else {
    $_SESSION['msg'] = "Invalid request.";
    header("Location: complaintsList.php");
    exit();
}

// Close the database connection
mysqli_close($conn);
?>
