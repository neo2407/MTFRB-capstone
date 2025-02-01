<?php
session_start();
include "../include/db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and escape form data
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $m_name = mysqli_real_escape_string($conn, $_POST['m_name']);
    $sex = mysqli_real_escape_string($conn, $_POST['sex']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $operatorMonth = mysqli_real_escape_string($conn, $_POST['operatorMonth']);
    $contact_num = mysqli_real_escape_string($conn, $_POST['contact_num']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $tricColor = mysqli_real_escape_string($conn, $_POST['tricColor']);
    $tricType= mysqli_real_escape_string($conn, $_POST['tricType']);
    $toda= mysqli_real_escape_string($conn, $_POST['toda']);
    $driver1_name= mysqli_real_escape_string($conn, $_POST['driver1_name']);
    $driver2_name= mysqli_real_escape_string($conn, $_POST['driver2_name']);
    $grant_date = isset($_POST['grant_date']) ? mysqli_real_escape_string($conn, $_POST['grant_date']) : date('Y-m-d');

    // Set the password to the ID value
    $password = $id;
    
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Handle file upload
    $operatorsPic = null;
    if (isset($_FILES['operatorsPic']) && $_FILES['operatorsPic']['error'] == UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['operatorsPic']['tmp_name'];
        $file_name = $_FILES['operatorsPic']['name'];
        $file_size = $_FILES['operatorsPic']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        // Define allowed file types
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        // Validate file type and size
        if (in_array($file_ext, $allowed_ext) && $file_size <= 2000000) { // 2MB limit
            $upload_dir = '../../uploads/operator/';
            $hashed_name = md5(uniqid(rand(), true)) . '.' . $file_ext;
            $upload_file = $upload_dir . $hashed_name;

            // Move uploaded file to the designated directory
            if (move_uploaded_file($file_tmp, $upload_file)) {
                $operatorsPic = $hashed_name;
            } else {
                $_SESSION['status'] = "Failed to upload profile picture.";
                $_SESSION['status_code'] = "error";
                header('Location: franchiseHolders.php');
                exit();
            }
        } else {
            $_SESSION['status'] = "Invalid file type or file size too large.";
            $_SESSION['status_code'] = "error";
            header('Location: franchiseHolders.php');
            exit();
        }
    }

   // Check if the user already exists in the table
$check_sql = "SELECT * FROM `$operatorMonth` WHERE id = '$id' OR email = '$email'";
$result = mysqli_query($conn, $check_sql);

if (mysqli_num_rows($result) > 0) {
    // User already exists
    $_SESSION['status'] = "ID or email already exists.";
    $_SESSION['status_code'] = "error";
    header('Location: franchiseHolders.php');
    exit();
} else {
    // Prepare SQL statement
    $sql = "INSERT INTO `$operatorMonth` 
            (id, first_name, last_name, m_name, sex, email, password, operatorsPic, contact_num, address, tricColor, tricType, toda, driver1_name, driver2_name, grant_date) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, 'isssssssssssssss', 
            $id, 
            $first_name, 
            $last_name, 
            $m_name, 
            $sex,
            $email,
            $password,        
            $operatorsPic,     
            $contact_num,
            $address,
            $tricColor,
            $tricType,
            $toda,
            $driver1_name,
            $driver2_name,
            $grant_date
        );

        // Execute the statement
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            $_SESSION['status'] = "Tricycle Operator Added Successfully!";
            $_SESSION['status_code'] = "success";
            header('Location: franchiseHolders.php');
        } else {
            $_SESSION['status'] = "Connection error: " . mysqli_stmt_error($stmt);
            $_SESSION['status_code'] = "error";
            header('Location: franchiseHolders.php');
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['status'] = "Failed to prepare the statement.";
        $_SESSION['status_code'] = "error";
        header('Location: franchiseHolders.php');
    }
}
}
?>
