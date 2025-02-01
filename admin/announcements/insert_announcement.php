<?php
session_start();
include "../include/db_conn.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and escape form data
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $link = mysqli_real_escape_string($conn, $_POST['link']);
    $inserted_at = isset($_POST['inserted_at']) ? mysqli_real_escape_string($conn, $_POST['inserted_at']) : date('Y-m-d H:i:s');

    // Handle image announcement upload
    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        // Define allowed file types
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        // Validate file type and size
        if (in_array($file_ext, $allowed_ext) && $file_size <= 5000000) { // 5MB limit
            $upload_dir = '../../uploads/announcements/';
            $hashed_name = md5(uniqid(rand(), true)) . '.' . $file_ext;
            $upload_file = $upload_dir . $hashed_name;

            // Move uploaded file to the designated directory
            if (move_uploaded_file($file_tmp, $upload_file)) {
                $image = $hashed_name;
            } else {
                $_SESSION['status'] = "Failed to upload profile picture.";
                $_SESSION['status_code'] = "error";
                header('Location: announcements.php');
                exit();
            }
        } else {
            $_SESSION['status'] = "Invalid file type or file size too large.";
            $_SESSION['status_code'] = "error";
            header('Location: announcements.php');
            exit();
        }
    }

    // Prepare SQL statement for announcements
    $sql = "INSERT INTO `announcements` (title, content, link, `image`, inserted_at) 
            VALUES (?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, 'sssss', 
            $title, 
            $content, 
            $link, 
            $image, 
            $inserted_at
        );

        // Execute the statement
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            // Log the admin's action
            $user_id = $_SESSION['user_id']; // Assuming `user_id` is stored in the session
            $action = "Added a new announcement titled: " . $title;
            $franchise_no = null; // Assuming no franchise number is applicable here
            $date_time = date('Y-m-d H:i:s');
            $account_type = $_SESSION['account_type']; // Assuming `account_type` is stored in the session
            $username = $_SESSION['username']; // Assuming `username` is stored in the session

            $logQuery = "INSERT INTO logs_history (user_id, action, franchise_no, date_time, account_type, username) VALUES (?, ?, ?, ?, ?, ?)";
            $logStmt = $conn->prepare($logQuery);
            if ($logStmt) {
                $logStmt->bind_param('isssss', $user_id, $action, $franchise_no, $date_time, $account_type, $username);
                $logStmt->execute();
                $logStmt->close();
            }

            $_SESSION['status'] = "Announcements Added Successfully!";
            $_SESSION['status_code'] = "success";
            header('Location: announcements.php');
        } else {
            $_SESSION['status'] = "Connection error: " . mysqli_stmt_error($stmt);
            $_SESSION['status_code'] = "error";
            header('Location: announcements.php');
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['status'] = "Failed to prepare the statement.";
        $_SESSION['status_code'] = "error";
        header('Location: announcements.php');
    }
}


?>
