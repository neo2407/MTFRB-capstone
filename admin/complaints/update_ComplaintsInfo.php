<?php
session_start(); // Start the session
include "../../include/db_conn.php";

date_default_timezone_set('Asia/Manila'); // Set the timezone to Asia/Manila

if (isset($_POST["submit"])) {
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $first_name = isset($_POST['first_name']) ? trim(mysqli_real_escape_string($conn, $_POST['first_name'])) : '';
    $last_name = isset($_POST['last_name']) ? trim(mysqli_real_escape_string($conn, $_POST['last_name'])) : '';
    $m_name = isset($_POST['m_name']) ? trim(mysqli_real_escape_string($conn, $_POST['m_name'])) : '';
    $contactNum = isset($_POST['contactNum']) ? trim(mysqli_real_escape_string($conn, $_POST['contactNum'])) : '';
    $email = isset($_POST['email']) ? trim(mysqli_real_escape_string($conn, $_POST['email'])) : '';
    $dateOfincident = isset($_POST['dateOfincident']) ? trim(mysqli_real_escape_string($conn, $_POST['dateOfincident'])) : '';
    $descOfincident = isset($_POST['descOfincident']) ? trim(mysqli_real_escape_string($conn, $_POST['descOfincident'])) : '';
    $TFno = isset($_POST['TFno']) ? trim(mysqli_real_escape_string($conn, $_POST['TFno'])) : '';
    $colorOftric = isset($_POST['colorOftric']) ? trim(mysqli_real_escape_string($conn, $_POST['colorOftric'])) : '';
    $madeOf = isset($_POST['madeOf']) ? trim(mysqli_real_escape_string($conn, $_POST['madeOf'])) : '';
    $descOfdriver = isset($_POST['descOfdriver']) ? trim(mysqli_real_escape_string($conn, $_POST['descOfdriver'])) : '';
    $dtOfcontact = isset($_POST['dtOfcontact']) ? trim(mysqli_real_escape_string($conn, $_POST['dtOfcontact'])) : '';
    $interview_dt = isset($_POST['interview_dt']) ? trim(mysqli_real_escape_string($conn, $_POST['interview_dt'])) : '';

    // Convert interview_dt to Asia/Manila timezone and 12-hour format
    $formatted_interview_dt = $interview_dt ? date('Y-m-d h:i A', strtotime($interview_dt)) : null;

    // Fetch existing data
    $updateData = "SELECT * FROM complaints WHERE id = '$id'";
    $updateData_run = mysqli_query($conn, $updateData);

    if ($updateData_run) {
        $result = mysqli_fetch_assoc($updateData_run);
        $changes = false;
        $change_log = []; // Array to store changes

        // Check for changes in the fields
        $fields = ['first_name', 'last_name', 'm_name', 'contactNum', 'email', 'dateOfincident', 'descOfincident', 'TFno', 'colorOftric', 'madeOf', 'descOfdriver', 'dtOfcontact', 'interview_dt'];

        foreach ($fields as $field) {
            $form_value = $$field;
            $db_value = isset($result[$field]) ? trim($result[$field]) : '';

            if ($field === 'interview_dt') {
                $db_value = $db_value ? date('Y-m-d h:i A', strtotime($db_value)) : null;
                if (!$form_value) {
                    $formatted_interview_dt = $db_value;
                }
            }

            if ($form_value !== $db_value) {
                $changes = true;
                $change_log[] = "$field: '$db_value' -> '$form_value'";
            }
        }

        // Update if there are changes
        if ($changes) {
            $sql = "UPDATE complaints SET 
                        first_name = ?, 
                        last_name = ?, 
                        m_name = ?, 
                        contactNum = ?, 
                        email = ?, 
                        dateOfincident = ?, 
                        descOfincident = ?, 
                        TFno = ?, 
                        colorOftric = ?, 
                        madeOf = ?, 
                        descOfdriver = ?, 
                        dtOfcontact = ?, 
                        interview_dt = ? 
                    WHERE id = ?";

            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, 'sssssssssssssi', 
                    $first_name, 
                    $last_name, 
                    $m_name, 
                    $contactNum, 
                    $email, 
                    $dateOfincident, 
                    $descOfincident, 
                    $TFno, 
                    $colorOftric, 
                    $madeOf, 
                    $descOfdriver, 
                    $dtOfcontact, 
                    $formatted_interview_dt, 
                    $id
                );

                $sql_run = mysqli_stmt_execute($stmt);

                if ($sql_run) {
                    $_SESSION['status'] = "Complaint Information Updated Successfully!";
                    $_SESSION['status_code'] = "success";

                    // Log the action in logs_history table
                    $user_id = $_SESSION['user_id'];
                    $account_type = $_SESSION['account_type'];
                    $username = $_SESSION['username'];
                    $date_time = date('Y-m-d H:i:s');
                    $action = "Updated complaint information for complaint ID $id. Changes: " . implode(", ", $change_log);

                    $logQuery = "INSERT INTO logs_history (user_id, action, franchise_no, date_time, account_type, username) VALUES (?, ?, ?, ?, ?, ?)";
                    if ($logStmt = $conn->prepare($logQuery)) {
                        $logStmt->bind_param("isssss", $user_id, $action, $TFno, $date_time, $account_type, $username);
                        $logStmt->execute();
                        $logStmt->close();
                    }
                } else {
                    $_SESSION['status'] = "Data not updated";
                    $_SESSION['status_code'] = "error";
                }

                mysqli_stmt_close($stmt);
            } else {
                $_SESSION['status'] = "Failed to prepare the statement";
                $_SESSION['status_code'] = "error";
            }
        } else {
            $_SESSION['status'] = "No changes detected";
            $_SESSION['status_code'] = "info";
        }
    } else {
        $_SESSION['status'] = "Failed to fetch existing data";
        $_SESSION['status_code'] = "error";
    }

    // Redirect to the edit page after updating
    header("Location: view_complaint.php?id=$id");
    exit();
}
?>
