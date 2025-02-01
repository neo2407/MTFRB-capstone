<?php
session_start();
include "../../include/db_conn.php";

if (isset($_POST["submit"])) {
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $first_name = isset($_POST['first_name']) ? trim(mysqli_real_escape_string($conn, $_POST['first_name'])) : '';
    $last_name = isset($_POST['last_name']) ? trim(mysqli_real_escape_string($conn, $_POST['last_name'])) : '';
    $m_name = isset($_POST['m_name']) ? trim(mysqli_real_escape_string($conn, $_POST['m_name'])) : '';
    $b_date = isset($_POST['b_date']) ? trim(mysqli_real_escape_string($conn, $_POST['b_date'])) : '';
    $age = isset($_POST['age']) ? trim(mysqli_real_escape_string($conn, $_POST['age'])) : '0';
    $address = isset($_POST['address']) ? trim(mysqli_real_escape_string($conn, $_POST['address'])) : '';
    $email = isset($_POST['email']) ? trim(mysqli_real_escape_string($conn, $_POST['email'])) : '';
    $sex = isset($_POST['sex']) ? trim(mysqli_real_escape_string($conn, $_POST['sex'])) : '';
    $contact_num = isset($_POST['contact_num']) ? trim(mysqli_real_escape_string($conn, $_POST['contact_num'])) : '';
    $driver1_name = isset($_POST['driver1_name']) ? trim(mysqli_real_escape_string($conn, $_POST['driver1_name'])) : '';
    $driver2_name = isset($_POST['driver2_name']) ? trim(mysqli_real_escape_string($conn, $_POST['driver2_name'])) : '';
    $tricColor = isset($_POST['tricColor']) ? trim(mysqli_real_escape_string($conn, $_POST['tricColor'])) : '';
    $tricType = isset($_POST['tricType']) ? trim(mysqli_real_escape_string($conn, $_POST['tricType'])) : '';
    $toda = isset($_POST['toda']) ? trim(mysqli_real_escape_string($conn, $_POST['toda'])) : '';
    $license_no = isset($_POST['license_no']) ? trim(mysqli_real_escape_string($conn, $_POST['license_no'])) : '';
    $license_class = isset($_POST['license_class']) ? trim(mysqli_real_escape_string($conn, $_POST['license_class'])) : '';
    $license_exp = isset($_POST['license_exp']) ? trim(mysqli_real_escape_string($conn, $_POST['license_exp'])) : '';
    
     // Check if the email already exists in the database
    $emailCheck = "SELECT id FROM applicants WHERE email = ? AND id != ?";
    if ($stmt = mysqli_prepare($conn, $emailCheck)) {
        mysqli_stmt_bind_param($stmt, 'si', $email, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            // Email already exists
            $_SESSION['status'] = "The email address is already in use. Please use a different one.";
            $_SESSION['status_code'] = "error";
            header("Location: applicantDash.php"); // Redirect to the edit page
            exit();
        }

        mysqli_stmt_close($stmt);
    }
    // Fetch existing data
    $updateData = "SELECT * FROM applicants WHERE id = '$id'";
    $updateData_run = mysqli_query($conn, $updateData);
    if ($updateData_run && mysqli_num_rows($updateData_run) > 0) {
        $result = mysqli_fetch_assoc($updateData_run);
    } else {
        $_SESSION['status'] = "Record not found";
        $_SESSION['status_code'] = "error";
        header("Location: applicantDash.php");
        exit();
    }

    $changes = false;
    $fields = ['first_name', 'last_name', 'm_name', 'b_date','age', 'address', 'email', 'sex', 'contact_num', 'driver1_name', 'driver2_name', 'tricColor', 'tricType', 'toda', 'license_no', 'license_class', 'license_exp'];

    foreach ($fields as $field) {
        $form_value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
        $db_value = isset($result[$field]) ? trim($result[$field]) : '';

        if ($form_value !== $db_value) {
            $changes = true;
            break;
        }
    }

    // Update if changes exist
    if ($changes) {
        $sql = "UPDATE applicants SET 
                    first_name = ?, 
                    last_name = ?, 
                    m_name = ?, 
                    b_date= ?, 
                    age = ?, 
                    address = ?, 
                    email = ?, 
                    sex = ?, 
                    contact_num = ?, 
                    driver1_name = ?, 
                    driver2_name = ?, 
                    tricColor = ?, 
                    tricType = ?, 
                    toda = ?,
                    license_no = ?,
                    license_class = ?,
                    license_exp = ?
                WHERE id = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, 'ssssissssssssssssi', 
                $first_name, $last_name, $m_name, $b_date, $age, $address, $email, 
                $sex, $contact_num, $driver1_name, $driver2_name, $tricColor, 
                $tricType, $toda, $license_no, $license_class, $license_exp, $id
            );

            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['status'] = "Information Updated Successfully!";
                $_SESSION['status_code'] = "success";
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

    header("Location: applicantDash.php");
    exit();
}
?>
