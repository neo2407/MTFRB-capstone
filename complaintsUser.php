<?php
session_start();
include "include/db_conn.php";

// Function to generate hashed file name
function generateHashedFileName($file) {
    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $hashedFileName = md5(uniqid(rand(), true)) . '.' . $fileExtension;
    return $hashedFileName;
}

// Function to validate file type
function isValidFileType($file) {
    $validFileTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'video/mp4', 'video/mkv'];
    return in_array($file['type'], $validFileTypes);
}

if (isset($_POST["submit"])) {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $m_name = mysqli_real_escape_string($conn, $_POST['m_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contactNum = mysqli_real_escape_string($conn, $_POST['contactNum']);
    $dateOfincident = mysqli_real_escape_string($conn, $_POST['dateOfincident']);
    $descOfincident = mysqli_real_escape_string($conn, $_POST['descOfincident']);
    $TFno = mysqli_real_escape_string($conn, $_POST['TFno']);
    $colorOftric = mysqli_real_escape_string($conn, $_POST['colorOftric']);
    $madeOf = mysqli_real_escape_string($conn, $_POST['madeOf']);
    $descOfdriver = mysqli_real_escape_string($conn, $_POST['descOfdriver']);
    $dtOfcontact = mysqli_real_escape_string($conn, $_POST['dtOfcontact']);
   
    // Format date and time
    $dateTime = new DateTime($dateOfincident);  
    $formattedDateOfincident = $dateTime->format('Y-m-d h:i A');
    $dateTime = new DateTime($dtOfcontact);
    $formattedDtOfcontact = $dateTime->format('Y-m-d h:i A');

    // Handle file uploads
    if (isset($_FILES['evidence']) && $_FILES['evidence']['error'] == UPLOAD_ERR_OK) {
        if (isValidFileType($_FILES['evidence'])) {
            $uploadDirComplaints = 'uploads/complaints/';
            $complaintsFileHashed = generateHashedFileName($_FILES['evidence']);
            $complaintsPath = $uploadDirComplaints . $complaintsFileHashed;

            // Move uploaded file to the target directory
            if (move_uploaded_file($_FILES['evidence']['tmp_name'], $complaintsPath)) {
                // Insert data into the database
                $sql = "INSERT INTO `complaints`(`id`, `first_name`, `last_name`, `m_name`, `email`, `contactNum`, `dateOfincident`, `descOfincident`, `TFno`, `colorOftric`, `madeOf`, `descOfdriver`, `evidence`, `dtOfcontact`, `is_new`) 
        VALUES (NULL, '$first_name', '$last_name', '$m_name', '$email', '$contactNum', '$formattedDateOfincident', '$descOfincident', '$TFno', '$colorOftric', '$madeOf', '$descOfdriver', '$complaintsFileHashed', '$formattedDtOfcontact', 1)";

                $result = mysqli_query($conn, $sql);

                if ($result) {
                    $_SESSION['status'] = "Complaint Submitted Successfully";
                    $_SESSION['status_code'] = "success";
                    header('Location: complaint-submission.php?TFno=' . urlencode($TFno));
                    
                } else {
                    $_SESSION['status'] = "Connection error.";
                    $_SESSION['status_code'] = "error";
                    header('Location: complaintForm.php');
                    exit();
                }
            } else {
                $_SESSION['status'] = "Failed to upload file.";
                $_SESSION['status_code'] = "error";
                header('Location: complaintForm.php');
                exit();
            }
        } else {
            $_SESSION['status'] = "Invalid file type.";
            $_SESSION['status_code'] = "error";
            header('Location: complaintForm.php');
            exit();
        }
    } else {
        $_SESSION['status'] = "No file uploaded or upload error.";
        $_SESSION['status_code'] = "error";
        header('Location: complaintForm.php');
        exit();
    }
}
?>
