<?php
session_start();
include "../include/db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $TFno = mysqli_real_escape_string($conn, $_POST['TFno']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $m_name = mysqli_real_escape_string($conn, $_POST['m_name']);
    $sex = mysqli_real_escape_string($conn, $_POST['sex']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact_num = mysqli_real_escape_string($conn, $_POST['contact_num']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $tricColor = mysqli_real_escape_string($conn, $_POST['tricColor']);
    $tricType = mysqli_real_escape_string($conn, $_POST['tricType']);
    $toda = mysqli_real_escape_string($conn, $_POST['toda']);
    $driver1_name = mysqli_real_escape_string($conn, $_POST['driver1_name']);
    $driver2_name = mysqli_real_escape_string($conn, $_POST['driver2_name']);
    $grant_date = isset($_POST['grant_date']) ? mysqli_real_escape_string($conn, $_POST['grant_date']) : date('Y-m-d');
    $expDate = mysqli_real_escape_string($conn, $_POST['expDate']);
    $dayBanned = mysqli_real_escape_string($conn, $_POST['dayBan']);

    // Generate default password
    $defaultPassword = $TFno . "_" . $last_name;
    $hashedPassword = password_hash($defaultPassword, PASSWORD_BCRYPT); // Hash the password

    // Map expiration date to table
    $expMonth = (int)date('n', strtotime(str_replace('/', '-', $expDate)));
    $monthTableMap = [
        1 => 'jan_operators',
        2 => 'feb_operators',
        3 => 'mar_operators',
        4 => 'apr_operators',
        5 => 'may_operators',
        6 => 'jun_operators',
        7 => 'jul_operators',
        8 => 'aug_operators',
        9 => 'sep_operators',
        10 => 'oct_operators',
        11 => 'nov_operators',
        12 => 'dec_operators'
    ];
    $targetTable = $monthTableMap[$expMonth] ?? null;

    if (!$targetTable) {
        $_SESSION['status'] = "Invalid expiration date.";
        $_SESSION['status_code'] = "error";
        header('Location: franchiseHolders.php');
        exit();
    }

   // File upload handling
$filePath = null;
if (isset($_FILES['operatorsPic']) && $_FILES['operatorsPic']['error'] == UPLOAD_ERR_OK) {
    $file = $_FILES['operatorsPic'];
    $allowedExtensions = ['jpg', 'jpeg', 'png'];
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    // Check for allowed file types
    if (!in_array($fileExtension, $allowedExtensions)) {
        $_SESSION['status'] = "Invalid file type. Only JPG, JPEG, and PNG are allowed.";
        $_SESSION['status_code'] = "error";
        header('Location: franchiseHolders.php');
        exit();
    }

    // Check for file size limit
    if ($file['size'] > 5 * 1024 * 1024) { // 5 MB
        $_SESSION['status'] = "File size must not exceed 5MB.";
        $_SESSION['status_code'] = "error";
        header('Location: franchiseHolders.php');
        exit();
    }

    $uploadDir = "../../uploads/operator/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Generate unique file name
    $fileName = time() . "_" . basename($file['name']);
    $filePath = $uploadDir . "/" . $fileName;

    // Move uploaded file and check for success
    if (!move_uploaded_file($file['tmp_name'], $filePath)) {
        $_SESSION['status'] = "Failed to upload the file.";
        $_SESSION['status_code'] = "error";
        header('Location: franchiseHolders.php');
        exit();
    }

    // Store only the file name (e.g., `123456_filename.jpg`)
    $filePath = $fileName;
}

    // Check for duplicate records
    $check_sql = "SELECT * FROM `$targetTable` WHERE TFno = '$TFno' OR email = '$email'";
    $result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['status'] = "A record with this Tricycle Franchise Number or email already exists.";
        $_SESSION['status_code'] = "warning";
        header('Location: franchiseHolders.php');
        exit();
    }

    // Insert new record
    $insert_sql = "INSERT INTO `$targetTable` 
        (TFno, first_name, last_name, m_name, sex, email, contact_num, address, tricColor, tricType, toda, driver1_name, driver2_name, grant_date, expDate, operatorsPic, dayBan, password) 
        VALUES 
        ('$TFno', '$first_name', '$last_name', '$m_name', '$sex', '$email', '$contact_num', '$address', '$tricColor', '$tricType', '$toda', '$driver1_name', '$driver2_name', '$grant_date', '$expDate', '$filePath', '$dayBanned', '$hashedPassword')";

    if (mysqli_query($conn, $insert_sql)) {
        $_SESSION['status'] = "Record added successfully. Default password is '$defaultPassword'.";
        $_SESSION['status_code'] = "success";
    } else {
        $_SESSION['status'] = "Failed to add record: " . mysqli_error($conn);
        $_SESSION['status_code'] = "error";
    }

    header('Location: franchiseHolders.php');
    exit();
} else {
    $_SESSION['status'] = "Invalid request method.";
    $_SESSION['status_code'] = "error";
    header('Location: franchiseHolders.php');
    exit();
}
