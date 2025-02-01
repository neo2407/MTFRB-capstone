<?php
session_start();
include "../../include/db_conn.php";

// Get form data
$ticketNo = $_POST['ticketNo'];
$receiptNumber = $_POST['receiptNumber'];
$operator_name = $_POST['operator_name'];
$violationDate = $_POST['violationDate'];
$violationType = $_POST['violationType'];
$TFno = $_POST['TFno'];
$penaltyCharged = $_POST['penaltyCharged'];
$offenseType = $_POST['offenseType'];
$enforcer = $_POST['enforcer'];

// Check if the generated ticket number or receipt number already exists in the database using prepared statement
$sqlCheck = "SELECT * FROM violations WHERE ticketNo = ? OR receiptNumber = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param("ss", $ticketNo, $receiptNumber);  // "ss" means both parameters are strings
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();

if ($resultCheck->num_rows > 0) {
    // Ticket number or receipt number already exists
    $_SESSION['status'] = "Ticket number or receipt number already exists.";
    $_SESSION['status_code'] = "error";
    header('Location: manageViolations.php');
    exit();
}

// Construct SQL query using prepared statement
$sql = "INSERT INTO violations (ticketNo, receiptNumber, violationDate, operator_name, violationType, TFno, penaltyCharged, offenseType, enforcer) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssss", $ticketNo, $receiptNumber, $violationDate, $operator_name, $violationType, $TFno, $penaltyCharged, $offenseType, $enforcer);

// Execute the query
if ($stmt->execute()) {
    // Success message
    $_SESSION['status'] = "Violation Added Successfully";
    $_SESSION['status_code'] = "success";

    // Log the action in logs_history
    if (isset($_SESSION['user_id'], $_SESSION['account_type'], $_SESSION['username'])) {
        $user_id = $_SESSION['user_id'];
        $account_type = $_SESSION['account_type'];
        $username = $_SESSION['username'];
        $date_time = date('Y-m-d H:i:s');
        $action = "Added a violation record with ticketNo: $ticketNo and receiptNumber: $receiptNumber.";
        $franchise_no = isset($_SESSION['franchise_no']) ? $_SESSION['franchise_no'] : null;

        $logQuery = "INSERT INTO logs_history (user_id, action, franchise_no, date_time, account_type, username) VALUES (?, ?, ?, ?, ?, ?)";
        if ($logStmt = $conn->prepare($logQuery)) {
            $logStmt->bind_param("isssss", $user_id, $action, $franchise_no, $date_time, $account_type, $username);
            $logStmt->execute();
            $logStmt->close();
        } else {
            $_SESSION['status'] = "Violation added, but logging failed: " . $conn->error;
            $_SESSION['status_code'] = "warning";
        }
    } else {
        $_SESSION['status'] = "Violation added, but session data missing for logging.";
        $_SESSION['status_code'] = "warning";
    }

    header('Location: manageViolations.php');
    exit();
} else {
    // Error message
    $_SESSION['status'] = "Connection error.";
    $_SESSION['status_code'] = "error";
    header('Location: manageViolations.php');
    exit();
}

// Close the statement and connection
$stmt->close();
$stmtCheck->close();
$conn->close();
?>
