<?php
session_start();
include "../../include/db_conn.php";

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    if (!isset($_POST['ticketNo']) || !isset($_POST['status'])) {
        throw new Exception("Missing required parameters: ticketNo or status");
    }

    $ticketNo = $_POST['ticketNo'];
    $status = $_POST['status'];

    // Log received parameters
    error_log("Received request - ticketNo: $ticketNo, status: $status");

    // Verify database connection
    if (!$conn) {
        throw new Exception("Database connection failed: " . mysqli_connect_error());
    }

    // Fetch violation details based on ticketNo
    $fetch_sql = "SELECT * FROM violations WHERE ticketNo = ?";
    $fetch_stmt = $conn->prepare($fetch_sql);
    if (!$fetch_stmt) {
        throw new Exception("Failed to prepare fetch statement: " . $conn->error);
    }

    $fetch_stmt->bind_param("i", $ticketNo);
    if (!$fetch_stmt->execute()) {
        throw new Exception("Failed to execute fetch statement: " . $fetch_stmt->error);
    }

    $result = $fetch_stmt->get_result();
    $violation = $result->fetch_assoc();
    $fetch_stmt->close();

    if (!$violation) {
        throw new Exception("No violation found for ticket number: $ticketNo");
    }

    // Prepare violation summary
    $summary = [
        'receiptNumber' => $violation['receiptNumber'],
        'ticketNo' => $ticketNo,
        'violationDate' => $violation['violationDate'],
        'TFno' => $violation['TFno'],
        'operator_name' => $violation['operator_name'],
        'violationType' => $violation['violationType'],
        'penaltyCharged' => $violation['penaltyCharged'],
        'offenseType' => $violation['offenseType'],
        'enforcer' => $violation['enforcer'],
        'penaltyStatus' => $status
    ];

    // Update penaltyStatus
    $sql = "UPDATE violations SET penaltyStatus = ? WHERE ticketNo = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Failed to prepare update statement: " . $conn->error);
    }

    $stmt->bind_param("si", $status, $ticketNo);
    if (!$stmt->execute()) {
        throw new Exception("Failed to update penalty status: " . $stmt->error);
    }

    if ($stmt->affected_rows <= 0) {
        throw new Exception("No rows were updated in violations table");
    }

    // Determine target table
    $lastDigit = substr($violation['TFno'], -1);
    $target_table = match ($lastDigit) {
        '1' => 'jan_operators',
        '2' => 'feb_operators',
        '3' => 'march_operators',
        '4' => 'apr_operators',
        '5' => 'may_operators',
        '6' => 'jun_operators',
        '7' => 'jul_operators',
        '8' => 'aug_operators',
        '9' => 'sep_operators',
        '0' => 'oct_operators',
        default => null,
    };

    if (!$target_table) {
        throw new Exception("Invalid TFno last digit: $lastDigit");
    }

    // Fetch existing violations
    $fetch_target_sql = "SELECT violations FROM $target_table WHERE TFno = ?";
    $fetch_target_stmt = $conn->prepare($fetch_target_sql);
    if (!$fetch_target_stmt) {
        throw new Exception("Failed to prepare target fetch statement: " . $conn->error);
    }

    $fetch_target_stmt->bind_param("i", $violation['TFno']);
    if (!$fetch_target_stmt->execute()) {
        throw new Exception("Failed to fetch from target table: " . $fetch_target_stmt->error);
    }

    $result = $fetch_target_stmt->get_result();
    $target_data = $result->fetch_assoc();
    $fetch_target_stmt->close();

    // Handle violations array
    $existing_violations = [];
    if ($target_data && $target_data['violations']) {
        $existing_violations = json_decode($target_data['violations'], true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Failed to decode existing violations: " . json_last_error_msg());
        }
    }

    $existing_violations[] = $summary;
    $new_violations_json = json_encode($existing_violations);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Failed to encode new violations: " . json_last_error_msg());
    }

    // Update target table
    $update_target_sql = "UPDATE $target_table SET violations = ? WHERE TFno = ?";
    $update_target_stmt = $conn->prepare($update_target_sql);
    if (!$update_target_stmt) {
        throw new Exception("Failed to prepare target update statement: " . $conn->error);
    }

    $update_target_stmt->bind_param("si", $new_violations_json, $violation['TFno']);
    if (!$update_target_stmt->execute()) {
        throw new Exception("Failed to update target table: " . $update_target_stmt->error);
    }

    if ($update_target_stmt->affected_rows <= 0) {
        throw new Exception("No rows were updated in $target_table");
    }

    // Log the successful update
    try {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['account_type']) || !isset($_SESSION['username'])) {
            throw new Exception("Missing session data");
        }

        $user_id = $_SESSION['user_id'];
        $account_type = $_SESSION['account_type'];
        $username = $_SESSION['username'];
        $date_time = date('Y-m-d H:i:s');
        $action = "Updated penalty status to '$status' for ticket number $ticketNo";
        $franchise_no = isset($_SESSION['franchise_no']) ? $_SESSION['franchise_no'] : null;

        $logQuery = "INSERT INTO logs_history (user_id, action, franchise_no, date_time, account_type, username) VALUES (?, ?, ?, ?, ?, ?)";
        $logStmt = $conn->prepare($logQuery);
        if (!$logStmt) {
            throw new Exception("Failed to prepare log statement: " . $conn->error);
        }

        $logStmt->bind_param("isssss", $user_id, $action, $franchise_no, $date_time, $account_type, $username);
        if (!$logStmt->execute()) {
            throw new Exception("Failed to insert log: " . $logStmt->error);
        }
        $logStmt->close();
    } catch (Exception $e) {
        error_log("Warning: Failed to log action: " . $e->getMessage());
        // Continue execution even if logging fails
    }

    echo json_encode([
        "status" => "success",
        "message" => "Penalty Status updated and data updated in $target_table successfully",
        "summary" => $summary
    ]);

} catch (Exception $e) {
    error_log("Error in update_penalty_status.php: " . $e->getMessage());
    echo json_encode([
        "status" => "error",
        "message" => "An error occurred: " . $e->getMessage(),
        "debug_info" => [
            "file" => $e->getFile(),
            "line" => $e->getLine(),
            "trace" => $e->getTraceAsString()
        ]
    ]);
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($update_target_stmt)) {
        $update_target_stmt->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
}
?>