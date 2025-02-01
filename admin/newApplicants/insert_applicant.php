<?php
session_start();
include "../include/db_conn.php";

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('Asia/Manila');

// Function to generate hashed file name
function generateHashedFileName($file) {
    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
    return md5(uniqid(rand(), true)) . '.' . $fileExtension;
}

if (isset($_POST["submit"])) {
    // Personal Information
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name'] ?? '');
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name'] ?? '');
    $m_name = mysqli_real_escape_string($conn, $_POST['m_name'] ?? '');
    $b_date = mysqli_real_escape_string($conn, $_POST['b_date'] ?? '');
    $age = mysqli_real_escape_string($conn, $_POST['age'] ?? '');
    $address = mysqli_real_escape_string($conn, $_POST['address'] ?? '');
    $sex = mysqli_real_escape_string($conn, $_POST['sex'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $contact_num = mysqli_real_escape_string($conn, $_POST['contact_num'] ?? '');
    $password = password_hash(mysqli_real_escape_string($conn, $_POST['password'] ?? ''), PASSWORD_BCRYPT);

    // Tricycle Information
    $driver1_name = mysqli_real_escape_string($conn, $_POST['driver1_name'] ?? '');
    $driver2_name = mysqli_real_escape_string($conn, $_POST['driver2_name'] ?? '');
    $tricColor = mysqli_real_escape_string($conn, $_POST['tricColor'] ?? '');
    $tricType = mysqli_real_escape_string($conn, $_POST['tricType'] ?? '');
    $toda = mysqli_real_escape_string($conn, $_POST['toda'] ?? '');
    $license_no = mysqli_real_escape_string($conn, $_POST['license_no'] ?? '');
    $license_class = mysqli_real_escape_string($conn, $_POST['license_class'] ?? '');
    $license_exp = mysqli_real_escape_string($conn, $_POST['license_exp'] ?? '');

    // Format date and time to 12-hour format with AM/PM
    $applicationDate = date("Y-m-d h:i A");
    $account_created_at = date("d/m/y h:i A");

    // Default values for new columns
    $new_acc = 0;
    $acc_status = 'verified';
    $code = 0;

    // Check if the applicant already exists
    $checkQuery = "SELECT * FROM applicants WHERE email = ? AND first_name = ? AND last_name = ?";
    $stmtCheck = $conn->prepare($checkQuery);
    $stmtCheck->bind_param("sss", $email, $first_name, $last_name);
    $stmtCheck->execute();
    $checkResult = $stmtCheck->get_result();

    if ($checkResult->num_rows > 0) {
        $_SESSION['status'] = "Applicant already exists. Review applicant details.";
        $_SESSION['status_code'] = "warning";
        header('Location: listApplicants.php');
        exit();
    }

    // Insert data into the database using a prepared statement
    $insertQuery = "INSERT INTO applicants (first_name, last_name, m_name, b_date, age, address, email, contact_num, password, sex, driver1_name, driver2_name, tricColor, tricType, toda, license_no, license_class, license_exp, applicationDate, account_created_at, new_acc, acc_status, code) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);

    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param(
        "ssssissssssssssssssisss",
        $first_name, $last_name, $m_name, $b_date, $age, $address, $email, $contact_num, $password, $sex,
        $driver1_name, $driver2_name, $tricColor, $tricType, $toda, $license_no, $license_class, $license_exp, $applicationDate, $account_created_at,
        $new_acc, $acc_status, $code
    );

    $result = $stmt->execute();

    if ($result) {
        // Get the ID of the inserted applicant
        $applicant_id = $conn->insert_id;

        // Log the action in logs_history table
        $user_id = $_SESSION['user_id'];
        $account_type = $_SESSION['account_type'];
        $username = $_SESSION['username'];
        $date_time = date('Y-m-d H:i:s');
        $action = "Applicant ID $applicant_id added.";
        $franchise_no = isset($_SESSION['franchise_no']) ? $_SESSION['franchise_no'] : null;

        $logQuery = "INSERT INTO logs_history (user_id, action, franchise_no, date_time, account_type, username) VALUES (?, ?, ?, ?, ?, ?)";
        if ($logStmt = $conn->prepare($logQuery)) {
            $logStmt->bind_param("isssss", $user_id, $action, $franchise_no, $date_time, $account_type, $username);
            $logStmt->execute();
            $logStmt->close();
        }

        $_SESSION['status'] = "Application Inserted";
        $_SESSION['status_code'] = "success";
        header('Location: listApplicants.php');
    } else {
        $_SESSION['status'] = "Error inserting data: " . $stmt->error;
        $_SESSION['status_code'] = "error";
        header('Location: listApplicants.php');
    }

    $stmt->close();
}
?>
