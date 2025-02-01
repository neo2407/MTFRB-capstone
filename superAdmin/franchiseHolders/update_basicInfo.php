<?php
session_start(); // Start the session
include "../include/db_conn.php";

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST["submit"])) {
    $id = $_POST['id'];
    $TFno = $_POST['TFno'];
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $m_name = trim($_POST['m_name'] ?? '');
    $b_date = trim($_POST['b_date'] ?? '');
    $age = trim($_POST['age'] ?? '0');
    $address = trim($_POST['address'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $sex = trim($_POST['sex'] ?? '');
    $contact_num = trim($_POST['contact_num'] ?? '');
    $driver1_name = trim($_POST['driver1_name'] ?? '');
    $driver2_name = trim($_POST['driver2_name'] ?? '');
    $tricColor = trim($_POST['tricColor'] ?? '');
    $tricType = trim($_POST['tricType'] ?? '');
    $toda = trim($_POST['toda'] ?? '');
    $license_no = trim($_POST['license_no'] ?? '');
    $license_class = trim($_POST['license_class'] ?? '');
    $license_exp = trim($_POST['license_exp'] ?? '');

    // Fetch existing data
    $query = "SELECT * FROM `jan_operators` WHERE id = ? UNION 
              SELECT * FROM `feb_operators` WHERE id = ? UNION 
              SELECT * FROM `march_operators` WHERE id = ? UNION 
              SELECT * FROM `apr_operators` WHERE id = ? UNION 
              SELECT * FROM `may_operators` WHERE id = ? UNION 
              SELECT * FROM `jun_operators` WHERE id = ? UNION 
              SELECT * FROM `jul_operators` WHERE id = ? UNION 
              SELECT * FROM `aug_operators` WHERE id = ? UNION 
              SELECT * FROM `sep_operators` WHERE id = ? UNION 
              SELECT * FROM `oct_operators` WHERE id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("iiiiiiiiii", $id, $id, $id, $id, $id, $id, $id, $id, $id, $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$result) {
        $_SESSION['status'] = "No record found for ID: $id";
        $_SESSION['status_code'] = "error";
        header("Location: edit_operatorDash.php?id=$id");
        exit;
    }

    // Variables to track changes
    $fieldsToCheck = [
        'last_name', 'first_name', 'm_name', 'age', 'contact_num', 'email', 
        'b_date', 'address', 'driver1_name', 'driver2_name', 'tricColor', 
        'tricType', 'toda',  'license_no', 'license_class', 'license_exp'
    ];
    $changeDetails = [];

    foreach ($fieldsToCheck as $field) {
        $newValue = $$field;
        $oldValue = trim($result[$field] ?? '');

        if ($newValue !== $oldValue) {
            $changeDetails[] = "$field: '$oldValue' -> '$newValue'";
        }
    }

    if (empty($changeDetails)) {
        $_SESSION['status'] = "No changes detected";
        $_SESSION['status_code'] = "info";
        header("Location: edit_operatorDash.php?id=$id");
        exit;
    }

    // Update records in all tables
    $tables = ['jan_operators', 'feb_operators', 'march_operators', 'apr_operators', 'may_operators', 'jun_operators', 'jul_operators', 'aug_operators', 'sep_operators', 'oct_operators'];
    $updateSuccessful = false;

    foreach ($tables as $table) {
        $query = "UPDATE $table SET last_name=?, first_name=?, m_name=?, age=?, contact_num=?, email=?, b_date=?, address=?, driver1_name=?, driver2_name=?, tricColor=?, tricType=?, toda=?,  license_no=?, license_class=?, license_exp=? WHERE id=?";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param("ssssssssssssssssi", $last_name, $first_name, $m_name, $age, $contact_num, $email, $b_date, $address, $driver1_name, $driver2_name, $tricColor, $tricType, $toda,  $license_no, $license_class, $license_exp, $id);
            $updateSuccessful = $stmt->execute() || $updateSuccessful;
            $stmt->close();
        }
    }

    if ($updateSuccessful) {
        // Log the changes
        $action = "Tricycle Operator Information updated for TFno $TFno: " . implode(', ', $changeDetails);
        $user_id = $_SESSION['user_id'];
        $account_type = $_SESSION['account_type'];
        $username = $_SESSION['username'];
        $date_time = date('Y-m-d H:i:s');
        $franchise_no = $_SESSION['franchise_no'] ?? null;

        $logQuery = "INSERT INTO logs_history (user_id, action, franchise_no, date_time, account_type, username) VALUES (?, ?, ?, ?, ?, ?)";
        $logStmt = $conn->prepare($logQuery);
        if ($logStmt) {
            $logStmt->bind_param("isssss", $user_id, $action, $franchise_no, $date_time, $account_type, $username);
            $logStmt->execute();
            $logStmt->close();
        }

        $_SESSION['status'] = "Tricycle Operator Information Updated Successfully";
        $_SESSION['status_code'] = "success";
    } else {
        $_SESSION['status'] = "Update Failed";
        $_SESSION['status_code'] = "error";
    }

    header("Location: edit_operatorDash.php?id=$id");
    exit;
}
?>
