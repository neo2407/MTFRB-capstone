<?php
session_start(); // Start the session
include "../../include/db_conn.php";

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST["submit"])) {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $fields = [
        'first_name', 'last_name', 'm_name', 'age', 'b_date', 'address',
        'email', 'sex', 'contact_num', 'driver1_name', 'driver2_name',
        'tricColor', 'tricType', 'toda', 'license_no', 'license_class', 'license_exp'
    ];
    $new_data = [];
    foreach ($fields as $field) {
        $new_data[$field] = isset($_POST[$field]) ? trim(mysqli_real_escape_string($conn, $_POST[$field])) : '';
    }

    // Fetch existing data
    $updateData = "SELECT * FROM applicants WHERE id = ?";
    if ($stmt = mysqli_prepare($conn, $updateData)) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $existing_data = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['status'] = "Failed to fetch existing data.";
        $_SESSION['status_code'] = "error";
        header("Location: edit.php?id=$id");
        exit();
    }

    // Detect changes and record old and new data
    $changes = false;
    $changed_fields = [];
    foreach ($fields as $field) {
        if (isset($existing_data[$field]) && $new_data[$field] !== $existing_data[$field]) {
            $changes = true;
            $changed_fields[] = "$field: '{$existing_data[$field]}' -> '{$new_data[$field]}'";
        }
    }

    if ($changes) {
        $sql = "UPDATE applicants SET 
                    first_name = ?, last_name = ?, m_name = ?, age = ?, b_date = ?, 
                    address = ?, email = ?, sex = ?, contact_num = ?, 
                    driver1_name = ?, driver2_name = ?, tricColor = ?, tricType = ?, toda = ?, 
                    license_no = ?, license_class = ?, license_exp = ?
                WHERE id = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, 'sssisssssssssssssi',
                $new_data['first_name'], $new_data['last_name'], $new_data['m_name'], $new_data['age'], $new_data['b_date'],
                $new_data['address'], $new_data['email'], $new_data['sex'], $new_data['contact_num'], $new_data['driver1_name'],
                $new_data['driver2_name'], $new_data['tricColor'], $new_data['tricType'], $new_data['toda'], $new_data['license_no'],
                $new_data['license_class'], $new_data['license_exp'], $id
            );
            $sql_run = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            if ($sql_run) {
                // Prepare the action log
                $action = "Updated applicant info: " . implode(", ", $changed_fields);

                // Log the changes in logs_history table
                $log_sql = "INSERT INTO logs_history (user_id, action, franchise_no, date_time, account_type, username) 
                            VALUES (?, ?, ?, ?, ?, ?)";
                if ($log_stmt = mysqli_prepare($conn, $log_sql)) {
                    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session
                    $franchise_no = NULL; // Adjust as necessary
                    $date_time = date('Y-m-d H:i:s');
                    $account_type = $_SESSION['account_type']; // Assuming account_type is stored in session
                    $username = $_SESSION['username']; // Assuming username is stored in session

                    mysqli_stmt_bind_param($log_stmt, 'isssss', $user_id, $action, $franchise_no, $date_time, $account_type, $username);
                    mysqli_stmt_execute($log_stmt);
                    mysqli_stmt_close($log_stmt);
                }

                $_SESSION['status'] = "Applicant Information Updated Successfully!";
                $_SESSION['status_code'] = "success";
            } else {
                $_SESSION['status'] = "Failed to update data.";
                $_SESSION['status_code'] = "error";
            }
        } else {
            $_SESSION['status'] = "Failed to prepare the update statement.";
            $_SESSION['status_code'] = "error";
        }
    } else {
        $_SESSION['status'] = "No changes detected.";
        $_SESSION['status_code'] = "info";
    }

    header("Location: edit.php?id=$id");
    exit();
}
?>
