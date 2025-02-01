<?php
session_start();
include "../include/db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and escape form data
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $link = mysqli_real_escape_string($conn, $_POST['link']);
    $inserted_at = isset($_POST['inserted_at']) ? mysqli_real_escape_string($conn, $_POST['inserted_at']) : date('Y-m-d H:i:A');
  

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
            header('Location: anouncements.php');
            exit();
        }
    }

  
        // Prepare SQL statement
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
            $_SESSION['status'] = "Announcements Added Successfully!";
            $_SESSION['status_code'] = "success";
            header('Location: announcements.php');
        } else {
            $_SESSION['status'] = "Connection error: " . mysqli_stmt_error($stmt);
            $_SESSION['status_code'] = "error";
            header('Location: announcement.php');
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['status'] = "Failed to prepare the statement.";
        $_SESSION['status_code'] = "error";
        header('Location: accounts.php');
    }
}

?>
