<?php
session_start(); // Start the session
include "../include/db_conn.php";

if (isset($_POST["submit"])) {
    $edit_id = $_POST['id'];
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $editdriversPic = $_FILES['driversPic']['name'];
    $editlicense = $_FILES['license']['name'];
    $edittricyclePics = $_FILES['tricyclePics'];

    // Fetch existing file paths and statuses
    $updatePics = "SELECT * FROM applicants WHERE id = '$edit_id'";
    $updatePics_run = mysqli_query($conn, $updatePics);
    $pic_row = mysqli_fetch_assoc($updatePics_run);

    $driversPicPath = $pic_row['driversPic'];
    $licensePath = $pic_row['license'];
    $driversPicStatus = $pic_row['driversPicStatus'];
    $licenseStatus = $pic_row['licenseStatus'];
    $tricyclePicsArray = json_decode($pic_row['tricyclePics'], true);
    $tricyclePicsStatus = $pic_row['tricyclePicsStatus']; // Correct status check

    $changesMade = false;

    // Handle driversPic upload if a new file is uploaded and the status is "invalid" or "for verification"
    if (!empty($editdriversPic) && ($driversPicStatus == 'invalid' || $driversPicStatus == 'for verification')) {
        $hashedDriversPic = md5(time() . $editdriversPic) . '.' . pathinfo($editdriversPic, PATHINFO_EXTENSION);
        $driversPicFullPath = "../uploads/driversPic/" . $hashedDriversPic;
        if (file_exists("../uploads/driversPic/" . $pic_row['driversPic'])) {
            unlink("../uploads/driversPic/" . $pic_row['driversPic']);
        }
        move_uploaded_file($_FILES['driversPic']['tmp_name'], $driversPicFullPath);
        $driversPicPath = $hashedDriversPic; // Store only the filename
        $changesMade = true;
    }

    // Handle license upload if a new file is uploaded and the status is "invalid" or "for verification"
    if (!empty($editlicense) && ($licenseStatus == 'invalid' || $licenseStatus == 'for verification')) {
        $hashedLicense = md5(time() . $editlicense) . '.' . pathinfo($editlicense, PATHINFO_EXTENSION);
        $licenseFullPath = "../uploads/license/" . $hashedLicense;
        if (file_exists("../uploads/license/" . $pic_row['license'])) {
            unlink("../uploads/license/" . $pic_row['license']);
        }
        move_uploaded_file($_FILES['license']['tmp_name'], $licenseFullPath);
        $licensePath = $hashedLicense; // Store only the filename
        $changesMade = true;
    }

    // Handle tricycle pics upload if new files are uploaded and the status is "invalid" or "for verification"
    if (!empty($edittricyclePics['name'][0]) && ($tricyclePicsStatus == 'invalid' || $tricyclePicsStatus == 'for verification')) {
        // Remove existing tricycle pics
        foreach ($tricyclePicsArray as $pic) {
            $tricyclePicPath = "../uploads/tricyclePics/" . $pic;
            if (file_exists($tricyclePicPath)) {
                unlink($tricyclePicPath);
            }
        }

        $tricyclePicsHashed = [];
        foreach ($edittricyclePics['name'] as $key => $name) {
            if ($edittricyclePics['error'][$key] === UPLOAD_ERR_OK) {
                $fileExtension = pathinfo($name, PATHINFO_EXTENSION);
                $hashedTricyclePic = md5(time() . $name) . '.' . $fileExtension;
                $tricyclePicPath = "../uploads/tricyclePics/" . $hashedTricyclePic;
                move_uploaded_file($edittricyclePics['tmp_name'][$key], $tricyclePicPath);
                $tricyclePicsHashed[] = $hashedTricyclePic;
            }
        }
        $tricyclePicsArray = $tricyclePicsHashed;
        $changesMade = true; // Correct variable
    }

    // Check if there were no changes made to the files
    if (!$changesMade) {
        $_SESSION['status'] = "No changes were made to the files.";
        $_SESSION['status_code'] = "info";
        header("Location: applicantDash.php");
        exit();
    }

    // Update query
    $sql = "UPDATE applicants SET first_name='$first_name', last_name='$last_name', email='$email', gender='$gender', 
    driversPic='$driversPicPath', license='$licensePath', tricyclePics='" . json_encode($tricyclePicsArray) . "' WHERE id = $edit_id";

    if (mysqli_query($conn, $sql)) {
        // Log notification for the successful update
        $notification_message = "Applicant $first_name $last_name successfully updated their files.";
        $insert_notification = "INSERT INTO notifications (message, type) VALUES ('$notification_message', 'update')";
        mysqli_query($conn, $insert_notification);

        $_SESSION['status'] = "Data updated successfully!";
        $_SESSION['status_code'] = "success";
        header("Location: applicantDash.php");
    } else {
        $_SESSION['status'] = "Data not updated";
        $_SESSION['status_code'] = "error";
        header("Location: applicantDash.php");
    }
    session_write_close();
}
?>
