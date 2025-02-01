<?php
session_start();

$isRegistered = false;

include "../include/db_conn.php";

date_default_timezone_set('Asia/Manila');

if (isset($_POST["submit"])) {
    // Sanitize user input
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $m_name = mysqli_real_escape_string($conn, $_POST['m_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact_num = mysqli_real_escape_string($conn, $_POST['contact_num']);
    $password = password_hash(mysqli_real_escape_string($conn, $_POST['password']), PASSWORD_BCRYPT);

    $account_created_at = date("m/d/Y h:i A");
    $new_acc = 1;

   // Prepare the statement to check for the existing email.
        $stmtEmail = $conn->prepare("SELECT * FROM applicants WHERE email = ?");
        $stmtEmail->bind_param("s", $email);
        $stmtEmail->execute();
        $resultEmail = $stmtEmail->get_result();

        // Check if the email exists.
        if ($resultEmail->num_rows > 0) {
            // Email already exists.
            $_SESSION['status_code'] = "error";
            $_SESSION['status'] = "An account with this email is already registered!";
            header("Location: account-registration.php");
            exit();
        }

        // Prepare the statement to check for the existing first and last name.
        $stmtName = $conn->prepare("SELECT * FROM applicants WHERE first_name = ? AND last_name = ?");
        $stmtName->bind_param("ss", $first_name, $last_name);
        $stmtName->execute();
        $resultName = $stmtName->get_result();

        // Check if both first name and last name exist.
        if ($resultName->num_rows > 0) {
            // First name and last name already exist.
            $_SESSION['status_code'] = "error";
            $_SESSION['status'] = "An account with this name is already registered!";
            header("Location: account-registration.php");
            exit();
        }

  
    // Insert new applicant if no duplicate found
    $stmt = $conn->prepare(
        "INSERT INTO `applicants` (`first_name`, `last_name`, `m_name`, `email`, `contact_num`, `password`, `account_created_at`, `new_acc`) 
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
    );

    if ($stmt) {
        $stmt->bind_param("sssssssi", $first_name, $last_name, $m_name, $email, $contact_num, $password, $account_created_at, $new_acc);

        if ($stmt->execute()) {
            $_SESSION['status'] = "Account Successfully Registered!";
            $_SESSION['status_code'] = "success";
            $_SESSION['id'] = $conn->insert_id; 
            header("Location: franchiseApplication.php");
            exit();
        } else {
            $_SESSION['error'] = "Registration failed: " . $stmt->error;
            error_log("Execution error: " . $stmt->error);
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = "Statement preparation failed: " . $conn->error;
        error_log("Preparation error: " . $conn->error);
    }
}
?>
