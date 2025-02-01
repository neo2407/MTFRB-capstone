<?php
session_start();
include "../include/db_conn.php";
date_default_timezone_set('Asia/Manila');

// Function to generate hashed file name
function generateHashedFileName($file) {
    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $hashedFileName = md5(uniqid(rand(), true)) . '.' . $fileExtension;
    return $hashedFileName;
}

// Function to handle file uploads and return hashed file name or NULL
function handleFileUpload($file, $uploadDir) {
    if (isset($file) && !empty($file['tmp_name'])) {
        $hashedFileName = generateHashedFileName($file);
        $filePath = $uploadDir . $hashedFileName;
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            return $hashedFileName;
        }
    }
    return null; // No file uploaded or upload failed
}

if (isset($_POST["submit"])) {
    // Personal Information
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $b_date = mysqli_real_escape_string($conn, $_POST['b_date']);
    $street = mysqli_real_escape_string($conn, $_POST['street']);
    $brgy = mysqli_real_escape_string($conn, $_POST['brgy']);
    $sex = mysqli_real_escape_string($conn, $_POST['sex']);
    $d1_last_name = mysqli_real_escape_string($conn, $_POST['d1_last_name']);
    $d1_first_name = mysqli_real_escape_string($conn, $_POST['d1_first_name']);
    $d1_m_name = mysqli_real_escape_string($conn, $_POST['d1_m_name']);
    $d2_last_name = mysqli_real_escape_string($conn, $_POST['d2_last_name']);
    $d2_first_name = mysqli_real_escape_string($conn, $_POST['d2_first_name']);
    $d2_m_name = mysqli_real_escape_string($conn, $_POST['d2_m_name']);

    // Concatenate street address and barangay
    $address = $street . ', ' . $brgy;

    // Tricycle Information
    $driver1_name = $d1_first_name . ' ' . $d1_m_name . ' ' . $d1_last_name;
    $driver2_name = !empty($d2_first_name) && !empty($d2_m_name) && !empty($d2_last_name) ? $d2_first_name . ' ' . $d2_m_name . ' ' . $d2_last_name : NULL;

    $tricColor = mysqli_real_escape_string($conn, $_POST['tricColor']);
    $tricType = mysqli_real_escape_string($conn, $_POST['tricType']);
    $toda = mysqli_real_escape_string($conn, $_POST['toda']);
    $license_no = mysqli_real_escape_string($conn, $_POST['license_no']);
    $license_class = mysqli_real_escape_string($conn, $_POST['license_class']);
    $license_exp = mysqli_real_escape_string($conn, $_POST['license_exp']);

    $applicationDate = date("Y-m-d h:i A");

    // Check if the applicant's email is stored in the session
    if (!isset($_SESSION['email'])) {
        $_SESSION['status'] = "User is not logged in.";
        $_SESSION['status_code'] = "error";
        header('Location: ../index.php');
        exit();
    }

    $email = $_SESSION['email']; // Accessing the stored applicant email

    // Directories for file uploads
    $uploadDirs = [
        'driver1' => '../uploads/driver1/',
        'license' => '../uploads/license/',
        //'tricyclePics' => '../uploads/tricyclePics/',
        'operator' => '../uploads/operator/',
        'valid_id' => '../uploads/valid_id/',
        'cr' => '../uploads/cr/',
        'or' => '../uploads/or/'
    ];

    // Handle individual file uploads
    $driversPic1Hashed = handleFileUpload($_FILES['driversPic1'], $uploadDirs['driver1']);
    $licenseHashed = handleFileUpload($_FILES['license'], $uploadDirs['license']);
    $operatorsPicHashed = handleFileUpload($_FILES['operatorsPic'], $uploadDirs['operator']);
    $validIDHashed = handleFileUpload($_FILES['valid_id'], $uploadDirs['valid_id']);
    $crHashed = handleFileUpload($_FILES['cr'], $uploadDirs['cr']);
    $orHashed = handleFileUpload($_FILES['or'], $uploadDirs['or']);

   // Ensure proper array structure for multiple file uploads
    /**$tricyclePicsHashed = [];
    if (isset($_FILES['tricyclePics']) && !empty($_FILES['tricyclePics']['name'][0])) {
        // Loop through each uploaded file
        foreach ($_FILES['tricyclePics']['name'] as $key => $name) {
            if (!empty($_FILES['tricyclePics']['tmp_name'][$key])) {
                $file = [
                    'name' => $name,
                    'tmp_name' => $_FILES['tricyclePics']['tmp_name'][$key]
                ];
    
                // Generate hashed file name and move the file
                $tricyclePicHashed = generateHashedFileName($file);
                $filePath = $uploadDirs['tricyclePics'] . $tricyclePicHashed;
    
                // Move the file to the desired directory
                if (move_uploaded_file($file['tmp_name'], $filePath)) {
                    // Store the hashed file name
                    $tricyclePicsHashed[] = $tricyclePicHashed;
                }
            }
        }
    }
    
    // If pictures were uploaded, store their hashed names as JSON
    $tricyclePicsJson = !empty($tricyclePicsHashed) ? json_encode($tricyclePicsHashed) : null;**/



    // Prepare the SQL UPDATE statement
    $sql = "UPDATE applicants SET 
         age = ?, b_date = ?, address = ?, sex = ?, 
        driver1_name = ?, driver2_name = ?, tricColor = ?, tricType = ?, toda = ?, license_no = ?, license_class = ?, license_exp = ?,
       `or` = ?, cr = ?, operatorsPic = ?, valid_id = ?, license = ?, driversPic1 = ?,  
         applicationDate = ?, 
        new_acc = 0, is_new = 1 
        WHERE email = ?";

    // Prepare the statement
    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind parameters to update the existing record
        mysqli_stmt_bind_param($stmt, 'ssssssssssssssssssss', 
            $age, $b_date, $address, $sex,  
            $driver1_name, $driver2_name, $tricColor, $tricType, $toda, $license_no, $license_class, $license_exp, 
            $orHashed,  $crHashed, $operatorsPicHashed, $validIDHashed, $licenseHashed, 
            $driversPic1Hashed,
            $applicationDate, $email
        );

        // Execute the statement
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            $_SESSION['status'] = "Your application has been submitted successfully!";
            $_SESSION['status_code'] = "success";
            header('Location: submission-confirmation.php');
        } else {
            $_SESSION['status'] = "Connection error: " . mysqli_stmt_error($stmt);
            $_SESSION['status_code'] = "error";
            header('Location: franchiseApplication.php');
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['status'] = "Failed to prepare the statement";
        $_SESSION['status_code'] = "error";
        header('Location: franchiseApplication.php');
    }
}
?>
