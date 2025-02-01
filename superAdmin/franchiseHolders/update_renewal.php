<?php
session_start(); // Start the session
include "../include/db_conn.php";

if (isset($_POST["submit"])) {
    $id = $_POST['id'];
    $TFno = $_POST['TFno'];
    $status = isset($_POST['status']) ? trim($_POST['status']) : '';
    $expDate = isset($_POST['expDate']) ? trim($_POST['expDate']) : '';
    $dtOfrenewal = isset($_POST['dtOfrenewal']) ? trim($_POST['dtOfrenewal']) : '';
    $renewal_payment = isset($_POST['renewal_payment']) ? trim($_POST['renewal_payment']) : '0';
    $penalty = isset($_POST['penalty']) ? trim($_POST['penalty']) : '0';

    // Fetch existing data
    $updateData = "SELECT * FROM `jan_operators` WHERE id = ? UNION 
                   SELECT * FROM `feb_operators` WHERE id = ? UNION 
                   SELECT * FROM `march_operators` WHERE id = ? UNION 
                   SELECT * FROM `apr_operators` WHERE id = ? UNION 
                   SELECT * FROM `may_operators` WHERE id = ? UNION 
                   SELECT * FROM `jun_operators` WHERE id = ? UNION 
                   SELECT * FROM `jul_operators` WHERE id = ? UNION 
                   SELECT * FROM `aug_operators` WHERE id = ? UNION 
                   SELECT * FROM `sep_operators` WHERE id = ? UNION 
                   SELECT * FROM `oct_operators` WHERE id = ?";

    $stmt = $conn->prepare($updateData);
    $stmt->bind_param("iiiiiiiiii", $id, $id, $id, $id, $id, $id, $id, $id, $id, $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    // Variables to track changes
    $changesDetected = false;
    $changeDetails = [];

    // Compare fields and record changes
    $fieldsToCheck = ['status', 'expDate', 'dtOfrenewal', 'renewal_payment', 'penalty'];
    foreach ($fieldsToCheck as $field) {
        if ($$field !== $result[$field]) {
            $changesDetected = true;
            $changeDetails[] = "$field: '{$result[$field]}' -> '{$$field}'";
        }
    }

    if ($changesDetected) {
        $tables = ['jan_operators', 'feb_operators', 'march_operators', 'apr_operators', 'may_operators', 'jun_operators', 'jul_operators', 'aug_operators', 'sep_operators', 'oct_operators'];
        $updateQuery = "UPDATE %s SET status=?, expDate=?, dtOfrenewal=?, renewal_payment=?, penalty=? WHERE id=?";
        $updateSuccessful = false;

        foreach ($tables as $table) {
            $query = sprintf($updateQuery, $table);
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("sssiii", $status, $expDate, $dtOfrenewal, $renewal_payment, $penalty, $id);
                $result = $stmt->execute();
                if ($result) {
                    $updateSuccessful = true;
                }
                $stmt->close();
            }
        }

        if ($updateSuccessful) {
            // Log the changes in logs_history
            $action = "Franchise Renewal Information updated for TFno $TFno: " . implode(', ', $changeDetails);
            $user_id = $_SESSION['user_id'];
            $account_type = $_SESSION['account_type'];
            $username = $_SESSION['username'];
            $date_time = date('Y-m-d H:i:s');
            $franchise_no = $_SESSION['franchise_no'] ?? null;

            $logQuery = "INSERT INTO logs_history (user_id, action, franchise_no, date_time, account_type, username) VALUES (?, ?, ?, ?, ?, ?)";
            if ($logStmt = $conn->prepare($logQuery)) {
                $logStmt->bind_param("isssss", $user_id, $action, $franchise_no, $date_time, $account_type, $username);
                $logStmt->execute();
                $logStmt->close();
            }

            $_SESSION['status'] = "Franchise Renewal Information Updated Successfully";
            $_SESSION['status_code'] = "success";
        } else {
            $_SESSION['status'] = "Franchise Renewal Information not updated";
            $_SESSION['status_code'] = "error";
        }
    } else {
        $_SESSION['status'] = "No changes detected";
        $_SESSION['status_code'] = "info";
    }

    header("Location: edit_operatorDash.php?id=$id");
    exit;
}
?>
