<?php
session_start(); // Start the session
include "../../include/db_conn.php";

if (isset($_POST["submit"])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    
    // Initialize variables for file uploads
    $uploadsDir = "../../uploads/";
    $changes = false;

    // Fetch existing data
    $updatePics = "SELECT * FROM `applicants` WHERE id = '$id'";
    $updatePics_run = mysqli_query($conn, $updatePics);
    $pic_row = mysqli_fetch_assoc($updatePics_run);

    // Prepare file paths
    $file_fields = [
        'operatorsPic' => 'operator/',
        'driversPic1' => 'driver1/',
        'driversPic2' => 'driver2/',
        'toda_cert' => 'toda_cert/',
        'valid_id' => 'valid_id/',
        'sedula' => 'sedula/',
        'license' => 'license/',
        'med_res' => 'med_res/',
        'cr' => 'cr/',
        'or' => 'or/',
        'deedSale' => 'deedSale/',
        'tricyclePics' => 'tricyclePics/',
        'tric_insp' => 'tric_insp/'
    ];

    foreach ($file_fields as $field => $subdir) {
        if (!empty($_FILES[$field]['name'])) {
            $fileName = $_FILES[$field]['name'];
            $fileTmpName = $_FILES[$field]['tmp_name'];
            $fileError = $_FILES[$field]['error'];
            
            if ($fileError === UPLOAD_ERR_OK) {
                // Hash the file name and prepare the path
                $hashedFileName = md5(time() . $fileName) . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
                $filePath = $uploadsDir . $subdir . $hashedFileName;

                // Remove existing file
                $oldFilePath = $uploadsDir . $subdir . $pic_row[$field];
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }

                // Move uploaded file
                move_uploaded_file($fileTmpName, $filePath);

                // Update the path
                $pic_row[$field] = $hashedFileName;
                $changes = true;
            }
        }
    }

    // Handle multiple file uploads (tricyclePics)
    if (!empty($_FILES['tricyclePics']['name'][0])) {
        // Remove existing tricycle pics
        foreach (json_decode($pic_row['tricyclePics'], true) as $pic) {
            $tricyclePicPath = $uploadsDir . 'tricyclePics/' . $pic;
            if (file_exists($tricyclePicPath)) {
                unlink($tricyclePicPath);
            }
        }

        $tricyclePicsHashed = [];
        foreach ($_FILES['tricyclePics']['name'] as $key => $name) {
            if ($_FILES['tricyclePics']['error'][$key] === UPLOAD_ERR_OK) {
                $fileExtension = pathinfo($name, PATHINFO_EXTENSION);
                $hashedTricyclePic = md5(time() . $name) . '.' . $fileExtension;
                $tricyclePicPath = $uploadsDir . 'tricyclePics/' . $hashedTricyclePic;
                move_uploaded_file($_FILES['tricyclePics']['tmp_name'][$key], $tricyclePicPath);
                $tricyclePicsHashed[] = $hashedTricyclePic;
            }
        }
        $pic_row['tricyclePics'] = json_encode($tricyclePicsHashed);
        $changes = true;
    }

    // Update query
    if ($changes) {
        $sql = "UPDATE applicants SET 
                    operatorsPic='{$pic_row['operatorsPic']}',
                    driversPic1='{$pic_row['driversPic1']}',
                    driversPic2='{$pic_row['driversPic2']}',
                    toda_cert='{$pic_row['toda_cert']}',
                    valid_id='{$pic_row['valid_id']}',
                    sedula='{$pic_row['sedula']}',
                    license='{$pic_row['license']}',
                    med_res='{$pic_row['med_res']}',
                    cr='{$pic_row['cr']}',
                    `or`='{$pic_row['or']}', 
                    deedSale='{$pic_row['deedSale']}',
                    tricyclePics='{$pic_row['tricyclePics']}',
                    tric_insp='{$pic_row['tric_insp']}'
                WHERE id='$id'";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Log notification for the successful update
            $notification_message = "Applicant $first_name $last_name successfully updated their files.";
            $insert_notification = "INSERT INTO notifications (message, type) VALUES ('$notification_message', 'update')";
            mysqli_query($conn, $insert_notification);

            $_SESSION['status'] = "File/s updated successfully!";
            $_SESSION['status_code'] = "success";
            header("Location: applicantDash.php");
        } else {
            $_SESSION['status'] = "Data not updated";
            $_SESSION['status_code'] = "error";
            header("Location: applicantDash.php");
        }
    } else {
        $_SESSION['status'] = "No changes detected";
        $_SESSION['status_code'] = "info";
        header("Location: applicantDash.php");
    }
}
?>
