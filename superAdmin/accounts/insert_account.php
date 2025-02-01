<?php
session_start();
include "../include/db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and escape form data
    $f_name = mysqli_real_escape_string($conn, $_POST['f_name']);
    $l_name = mysqli_real_escape_string($conn, $_POST['l_name']);
    $m_name = mysqli_real_escape_string($conn, $_POST['m_name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $job_position = mysqli_real_escape_string($conn, $_POST['job_position']);
    $account_type = mysqli_real_escape_string($conn, $_POST['account_type']); 
    $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Handle file upload
    $profile_picture = null;
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['profile_picture']['tmp_name'];
        $file_name = $_FILES['profile_picture']['name'];
        $file_size = $_FILES['profile_picture']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        // Define allowed file types
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        // Validate file type and size
        if (in_array($file_ext, $allowed_ext) && $file_size <= 5000000) { // 5MB limit
            $upload_dir = '../../uploads/profile_pics/';
            $hashed_name = md5(uniqid(rand(), true)) . '.' . $file_ext;
            $upload_file = $upload_dir . $hashed_name;

            // Move uploaded file to the designated directory
            if (move_uploaded_file($file_tmp, $upload_file)) {
                $profile_picture = $hashed_name;
            } else {
                $_SESSION['status'] = "Failed to upload profile picture.";
                $_SESSION['status_code'] = "error";
                header('Location: accounts.php');
                exit();
            }
        } else {
            $_SESSION['status'] = "Invalid file type or file size too large.";
            $_SESSION['status_code'] = "error";
            header('Location: accounts.php');
            exit();
        }
    }

    // Check if the email already exists in the database
    $check_email_sql = "SELECT * FROM `accounts` WHERE email = '$email'";
    $email_result = mysqli_query($conn, $check_email_sql);

    if (mysqli_num_rows($email_result) > 0) {
        // Email already exists
        $_SESSION['status'] = "Email is already in use.";
        $_SESSION['status_code'] = "error";
        header('Location: accounts.php');
        exit();
    }

    // Check if the username already exists in the table
    $check_sql = "SELECT * FROM `accounts` WHERE username = '$username'";
    $result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($result) > 0) {
        // Username already exists
        $_SESSION['status'] = "Username already exists.";
        $_SESSION['status_code'] = "error";
        header('Location: accounts.php');
        exit();
    } else {
        // Prepare SQL statement for inserting the new account
        $sql = "INSERT INTO `accounts` (f_name, l_name, m_name, username, email, password, job_position, account_type, profile_picture, contact_number, address) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($conn, $sql)) {  
            mysqli_stmt_bind_param($stmt, 'sssssssssss', 
                $f_name, 
                $l_name, 
                $m_name, 
                $username, 
                $email,  
                $hashed_password,  
                $job_position, 
                $account_type, 
                $profile_picture,   
                $contact_number,
                $address
            );

            // Execute the statement
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                // Log the action into log_history
                $user_id = $_SESSION['user_id']; // Assuming the admin performing the action is in the session
                $admin_account_type = $_SESSION['account_type']; // The account type of the admin performing the action
                $admin_username = $_SESSION['username'];
                $action = "Created new account for user: $username with email: $email as $account_type ";
                
                $date_time = date('Y-m-d H:i:s');
                $franchise_no = isset($_SESSION['franchise_no']) ? $_SESSION['franchise_no'] : null;

                $logQuery = "INSERT INTO logs_history (user_id, username, action, franchise_no, account_type, date_time) 
                             VALUES (?, ?, ?, ?, ?, ?)";

                if ($logStmt = mysqli_prepare($conn, $logQuery)) {
                    $logStmt->bind_param("isssss", $user_id, $admin_username, $action, $franchise_no, $admin_account_type, $date_time );
                    $logStmt->execute();
                    $logStmt->close();
                }

                $_SESSION['status'] = "Account Added Successfully!";
                $_SESSION['status_code'] = "success";
                header('Location: accounts.php');
            } else {
                $_SESSION['status'] = "Connection error: " . mysqli_stmt_error($stmt);
                $_SESSION['status_code'] = "error";
                header('Location: accounts.php');
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            $_SESSION['status'] = "Failed to prepare the statement.";
            $_SESSION['status_code'] = "error";
            header('Location: accounts.php');
        }
    }
}
?>
