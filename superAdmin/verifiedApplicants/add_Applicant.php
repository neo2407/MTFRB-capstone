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

if (isset($_POST["submit"])) {
    // Personal Information
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $m_name = mysqli_real_escape_string($conn, $_POST['m_name']);
    $b_date = mysqli_real_escape_string($conn, $_POST['b_date']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $sex = mysqli_real_escape_string($conn, $_POST['sex']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact_num = mysqli_real_escape_string($conn, $_POST['contact_num']);
    $password = password_hash(mysqli_real_escape_string($conn, $_POST['password']), PASSWORD_BCRYPT);

    // Tricycle Information
    $driver1_name = mysqli_real_escape_string($conn, $_POST['driver1_name']);
    $driver2_name = mysqli_real_escape_string($conn, $_POST['driver2_name']);
    $tricColor = mysqli_real_escape_string($conn, $_POST['tricColor']);
    $tricType = mysqli_real_escape_string($conn, $_POST['tricType']);
    $toda = mysqli_real_escape_string($conn, $_POST['toda']);
    
    
    $applicationDate = date("m/d/Y h:i A");// Use MySQL format for datetime

    // Check if the applicant already exists
    $checkQuery = "SELECT * FROM applicants WHERE email = '$email' AND first_name = '$first_name' AND last_name = '$last_name'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        $_SESSION['status'] = "Applicant already exists. Please check your details.";
        $_SESSION['status_code'] = "warning";
        header('Location: listApplicants.php');
        exit();
    }

    // Handle file uploads
    $uploadDirDriver1 = '../../uploads/driver1/';
    $uploadDirDriver2 = '../../uploads/driver2/';
    $uploadDirLicense = '../../uploads/license/';
    $uploadDirTricycle = '../../uploads/tricyclePics/';
    $uploadDirOperator = '../../uploads/operator/';
    $uploadDirTodaCert = '../../uploads/toda_cert/';
    $uploadDirValidId = '../../uploads/valid_id/';
    $uploadDirSedula = '../../uploads/sedula/';
    $uploadDirCr = '../../uploads/cr/';
    $uploadDirOr = '../../uploads/or/';
    $uploadDirDeedSale = '../../uploads/deedSale/';
    $uploadDirMedRes = '../../uploads/med_res/';

    $driversPic1Hashed = generateHashedFileName($_FILES['driversPic1']);
    $driversPic2Hashed = generateHashedFileName($_FILES['driversPic2']);
    $licenseHashed = generateHashedFileName($_FILES['license']); // License upload
   
    $operatorsPicHashed = generateHashedFileName($_FILES['operatorsPic']);
    $todaCertHashed = generateHashedFileName($_FILES['toda_cert']);
    $validIDHashed = generateHashedFileName($_FILES['valid_id']);
    $sedulaHashed = generateHashedFileName($_FILES['sedula']);
    $crHashed = generateHashedFileName($_FILES['cr']);
    $orHashed = generateHashedFileName($_FILES['or']);
    $deedSaleHashed = generateHashedFileName($_FILES['deedSale']);
    $medResHashed = generateHashedFileName($_FILES['med_res']);

    // Paths for each file
    $driversPic1Path = $uploadDirDriver1 . $driversPic1Hashed;
    $driversPic2Path = $uploadDirDriver2 . $driversPic2Hashed;
    $licensePath = $uploadDirLicense . $licenseHashed; // License path

    $operatorsPicPath = $uploadDirOperator . $operatorsPicHashed;
    $todaCertPath = $uploadDirTodaCert . $todaCertHashed;
    $validIDPath = $uploadDirValidId . $validIDHashed;
    $sedulaPath = $uploadDirSedula . $sedulaHashed;
    $crPath = $uploadDirCr . $crHashed;
    $orPath = $uploadDirOr . $orHashed;
    $deedSalePath = $uploadDirDeedSale . $deedSaleHashed;
    $medResPath = $uploadDirMedRes . $medResHashed;

    // Process each tricycle picture
    $tricyclePicsHashed = [];
    foreach ($_FILES['tricyclePics']['name'] as $key => $name) {
        $file = [
            'name' => $name,
            'tmp_name' => $_FILES['tricyclePics']['tmp_name'][$key]
        ];
        $tricyclePicHashed = generateHashedFileName($file);
        $tricyclePicPath = $uploadDirTricycle . $tricyclePicHashed;
        if (move_uploaded_file($file['tmp_name'], $tricyclePicPath)) {
            $tricyclePicsHashed[] = $tricyclePicHashed;
        }
    }

    // Move uploaded files to the target directory
    if (
        move_uploaded_file($_FILES['driversPic1']['tmp_name'], $driversPic1Path) &&
        move_uploaded_file($_FILES['driversPic2']['tmp_name'], $driversPic2Path) &&
        move_uploaded_file($_FILES['license']['tmp_name'], $licensePath) && // License move_uploaded_file
        move_uploaded_file($_FILES['operatorsPic']['tmp_name'], $operatorsPicPath) &&
        move_uploaded_file($_FILES['toda_cert']['tmp_name'], $todaCertPath) &&
        move_uploaded_file($_FILES['valid_id']['tmp_name'], $validIDPath) &&
        move_uploaded_file($_FILES['sedula']['tmp_name'], $sedulaPath) &&
        move_uploaded_file($_FILES['cr']['tmp_name'], $crPath) &&
        move_uploaded_file($_FILES['or']['tmp_name'], $orPath) &&
        move_uploaded_file($_FILES['deedSale']['tmp_name'], $deedSalePath) &&
        move_uploaded_file($_FILES['med_res']['tmp_name'], $medResPath)
    ) {
        // Convert the array of hashed tricycle picture names to a JSON string
        $tricyclePicsJson = json_encode($tricyclePicsHashed);

       // Insert data into the database
       $sql = "INSERT INTO applicants(id, first_name, last_name, m_name, b_date, age, address, email, contact_num, password, sex, driver1_name, driver2_name, tricColor, tricType, toda, driversPic1, driversPic2, license, operatorsPic, toda_cert, valid_id, sedula, cr, `or`, tricyclePics, deedSale, med_res, applicationDate, is_new) 
       VALUES (NULL, '$first_name', '$last_name', '$m_name', '$b_date', '$age', '$address', '$email', '$contact_num', '$password', '$sex', '$driver1_name', '$driver2_name', '$tricColor', '$tricType', '$toda', '$driversPic1Hashed', '$driversPic2Hashed', '$licenseHashed', '$operatorsPicHashed', '$todaCertHashed', '$validIDHashed', '$sedulaHashed', '$crHashed', '$orHashed', '$tricyclePicsJson', '$deedSaleHashed', '$medResHashed', '$applicationDate', 1)";


        $result = mysqli_query($conn, $sql);

        if ($result) {
            $_SESSION['status'] = "Application Inserted.";
            $_SESSION['status_code'] = "success";
            header('Location: listApplicants.php');
        } else {
            $_SESSION['status'] = "Connection error: " . mysqli_error($conn); // Added error message for debugging
            $_SESSION['status_code'] = "error";
            header('Location: listApplicants.php');
        }
    } else {
        $_SESSION['status'] = "Failed to upload file.";
        $_SESSION['status_code'] = "error";
        header('Location: listApplicants.php');
    }
}
?>
