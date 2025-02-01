<?php
session_start(); // Start the session
include "../include/db_conn.php";

if (isset($_POST["submit"])) {
    $id = $_POST['id'];

    $operatorsPic = $_FILES['operatorsPic']['name'];
    $toda_cert = $_FILES['toda_cert']['name'];

    $valid_id = $_FILES['valid_id']['name'];
    $sedula = $_FILES['sedula']['name'];
    $driversPic1 = $_FILES['driversPic1']['name'];
    $driversPic2 = $_FILES['driversPic2']['name'];
    $license = $_FILES['license']['name'];
    $med_res = $_FILES['med_res']['name'];
    $cr = $_FILES['cr']['name'];
    $or = $_FILES['or']['name'];
    $deedSale = $_FILES['deedSale']['name'];
    $tric_insp = $_FILES['tric_insp']['name'];
    $tricyclePics = $_FILES['tricyclePics'];
    

    // Fetch existing data
    $updatePics = "SELECT * FROM `applicants` WHERE id = $id"; 
    $updatePics_run = mysqli_query($conn, $updatePics);
    $pic_row = mysqli_fetch_assoc($updatePics_run);

    $operatorsPicPath = $pic_row['operatorsPic'];
    $driversPic1Path = $pic_row['driversPic1'];
    $driversPic2Path = $pic_row['driversPic2'];
    $todaCertPath = $pic_row['toda_cert'];
    $validIdPath = $pic_row['valid_id'];
    $sedulaPath = $pic_row['sedula'];
    $licensePath = $pic_row['license'];
    $medResPath= $pic_row['med_res'];
    $crPath = $pic_row['cr'];
    $orPath = $pic_row['or'];
    $deedSalePath = $pic_row['deedSale'];
    $tric_inspPath = $pic_row['tric_insp'];
    $tricyclePicsArray = json_decode($pic_row['tricyclePics'], true);

    // Variables to track changes
    $changes = false;
    
    
    // Array to track updated files
    $updatedFiles = [];

    // Handle operatorsPic upload if a new file is uploaded
    if (!empty($_FILES['operatorsPic']['name'])) {
        $hashedOperatorsPic = md5(time() . $_FILES['operatorsPic']['name']) . '.' . pathinfo($_FILES['operatorsPic']['name'], PATHINFO_EXTENSION);
        $operatorsPicPath = "../../uploads/operator/" . $hashedOperatorsPic;
        if (file_exists("../../uploads/operator/" . $pic_row['operatorsPic'])) {
            unlink("../../uploads/operator/" . $pic_row['operatorsPic']);
        }
        move_uploaded_file($_FILES['operatorsPic']['tmp_name'], $operatorsPicPath);
        $operatorsPicPath = $hashedOperatorsPic; // Store only the filename
        $changes = true;
        
        $updatedFiles[] = "Operator's Picture";
    }

     // Handle driversPic1 upload if a new file is uploaded
     if (!empty($_FILES['driversPic1']['name'])) {
        $hashedDriversPic1 = md5(time() . $_FILES['driversPic1']['name']) . '.' . pathinfo($_FILES['driversPic1']['name'], PATHINFO_EXTENSION);
        $driversPic1Path = "../../uploads/driver1/" . $hashedDriversPic1;
        if (file_exists("../../uploads/driver1/" . $pic_row['driversPic1'])) {
            unlink("../../uploads/driver1/" . $pic_row['driversPic1']);
        }
        move_uploaded_file($_FILES['driversPic1']['tmp_name'], $driversPic1Path);
        $driversPic1Path = $hashedDriversPic1; // Store only the filename
        $changes = true;
        
          $updatedFiles[] = "Driver's Picture 1";
    }


    
    // Handle driversPic2 upload if a new file is uploaded
    if (!empty($_FILES['driversPic2']['name'])) {
        $hashedDriversPic2 = md5(time() . $_FILES['driversPic2']['name']) . '.' . pathinfo($_FILES['driversPic2']['name'], PATHINFO_EXTENSION);
        $driversPic2Path = "../../uploads/driver2/" . $hashedDriversPic2;
        if (file_exists("../../uploads/driver2/" . $pic_row['driversPic2'])) {
            unlink("../../uploads/driver2/" . $pic_row['driversPic2']);
        }
        move_uploaded_file($_FILES['driversPic2']['tmp_name'], $driversPic2Path);
        $driversPic2Path = $hashedDriversPic2; // Store only the filename
        $changes = true;
        
        $updatedFiles[] = "Driver's Picture 2";
    }

    // Handle toda_cert upload if a new file is uploaded
    if (!empty($_FILES['toda_cert']['name'])) {
        $hashedTodaCert = md5(time() . $_FILES['toda_cert']['name']) . '.' . pathinfo($_FILES['toda_cert']['name'], PATHINFO_EXTENSION);
        $todaCertPath = "../../uploads/toda_cert/" . $hashedTodaCert;
        if (file_exists("../../uploads/toda_cert/" . $pic_row['toda_cert'])) {
            unlink("../../uploads/toda_cert/" . $pic_row['toda_cert']);
        }
        move_uploaded_file($_FILES['toda_cert']['tmp_name'], $todaCertPath);
        $todaCertPath = $hashedTodaCert; // Store only the filename
        $changes = true;
        
        $updatedFiles[] = "TODA Certificate";
    }

    // Handle valid_id upload if a new file is uploaded
    if (!empty($_FILES['valid_id']['name'])) {
        $hashedValidId = md5(time() . $_FILES['valid_id']['name']) . '.' . pathinfo($_FILES['valid_id']['name'], PATHINFO_EXTENSION);
        $validIdPath = "../../uploads/valid_id/" . $hashedValidId;
        if (file_exists("../../uploads/valid_id/" . $pic_row['valid_id'])) {
            unlink("../../uploads/valid_id/" . $pic_row['valid_id']);
        }
        move_uploaded_file($_FILES['valid_id']['tmp_name'], $validIdPath);
        $validIdPath = $hashedValidId; // Store only the filename
        $changes = true;
        
        $updatedFiles[] = "PSA/Voter's ID/Certification";
    }

    // Handle sedula upload if a new file is uploaded
    if (!empty($_FILES['sedula']['name'])) {
        $hashedSedula = md5(time() . $_FILES['sedula']['name']) . '.' . pathinfo($_FILES['sedula']['name'], PATHINFO_EXTENSION);
        $sedulaPath = "../../uploads/sedula/" . $hashedSedula;
        if (file_exists("../../uploads/sedula/" . $pic_row['sedula'])) {
            unlink("../../uploads/sedula/" . $pic_row['sedula']);
        }
        move_uploaded_file($_FILES['sedula']['tmp_name'], $sedulaPath);
        $sedulaPath = $hashedSedula; // Store only the filename
        $changes = true;
        
        $updatedFiles[] = "Sedula";
    }

    // Handle license upload if a new file is uploaded
    if (!empty($_FILES['license']['name'])) {
        $hashedLicense = md5(time() . $_FILES['license']['name']) . '.' . pathinfo($_FILES['license']['name'], PATHINFO_EXTENSION);
        $licensePath = "../../uploads/license/" . $hashedLicense;
        if (file_exists("../../uploads/license/" . $pic_row['license'])) {
            unlink("../../uploads/license/" . $pic_row['license']);
        }
        move_uploaded_file($_FILES['license']['tmp_name'], $licensePath);
        $licensePath = $hashedLicense; // Store only the filename
        $changes = true;
        
        $updatedFiles[] = "Driver's License";
    }

    // Handle med_res upload if a new file is uploaded
    if (!empty($_FILES['med_res']['name'])) {
        $hashedMedRes = md5(time() . $_FILES['med_res']['name']) . '.' . pathinfo($_FILES['med_res']['name'], PATHINFO_EXTENSION);
        $medResPath = "../../uploads/med_res/" . $hashedMedRes;
        if (file_exists("../../uploads/med_res/" . $pic_row['med_res'])) {
            unlink("../../uploads/med_res/" . $pic_row['med_res']);
        }
        move_uploaded_file($_FILES['med_res']['tmp_name'], $medResPath);
        $medResPath = $hashedMedRes; // Store only the filename
        $changes = true;
        
        $updatedFiles[] = "Medical Result/ Health Card";
    }

    // Handle cr upload if a new file is uploaded
    if (!empty($_FILES['cr']['name'])) {
        $hashedCr = md5(time() . $_FILES['cr']['name']) . '.' . pathinfo($_FILES['cr']['name'], PATHINFO_EXTENSION);
        $crPath = "../../uploads/cr/" . $hashedCr;
        if (file_exists("../../uploads/cr/" . $pic_row['cr'])) {
            unlink("../../uploads/cr/" . $pic_row['cr']);
        }
        move_uploaded_file($_FILES['cr']['tmp_name'], $crPath);
        $crPath = $hashedCr; // Store only the filename
        $changes = true;
        
        $updatedFiles[] = "(CR) Certificate of Registration";
    }

    // Handle deedSale upload if a new file is uploaded
    if (!empty($_FILES['deedSale']['name'])) {
        $hashedDeedSale = md5(time() . $_FILES['deedSale']['name']) . '.' . pathinfo($_FILES['deedSale']['name'], PATHINFO_EXTENSION);
        $deedSalePath = "../../uploads/deedSale/" . $hashedDeedSale;
        if (file_exists("../../uploads/deedSale/" . $pic_row['deedSale'])) {
            unlink("../../uploads/deedSale/" . $pic_row['deedSale']);
        }
        move_uploaded_file($_FILES['deedSale']['tmp_name'], $deedSalePath);
        $deedSalePath = $hashedDeedSale; // Store only the filename
        $changes = true;
        
        $updatedFiles[] = "Deed of Sale";
    }

    // Handle or upload if a new file is uploaded
    if (!empty($_FILES['or']['name'])) {
        $hashedOr = md5(time() . $_FILES['or']['name']) . '.' . pathinfo($_FILES['or']['name'], PATHINFO_EXTENSION);
        $orPath = "../../uploads/or/" . $hashedOr;
        if (file_exists("../../uploads/or/" . $pic_row['or'])) {
            unlink("../../uploads/or/" . $pic_row['or']);
        }
        move_uploaded_file($_FILES['or']['tmp_name'], $orPath);
        $orPath = $hashedOr; // Store only the filename
        $changes = true;
        
        $updatedFiles[] = "(OR) Official Receipt";
    }

     // Handle tric_insp upload if a new file is uploaded
     if (!empty($_FILES['tric_insp']['name'])) {
        $hashedtric_insp = md5(time() . $_FILES['tric_insp']['name']) . '.' . pathinfo($_FILES['tric_insp']['name'], PATHINFO_EXTENSION);
        $tric_inspPath = "../../uploads/tric_insp/" . $hashedtric_insp;
        if (file_exists("../../uploads/tric_insp/" . $pic_row['tric_insp'])) {
            unlink("../../uploads/tric_insp/" . $pic_row['tric_insp']);
        }
        move_uploaded_file($_FILES['tric_insp']['tmp_name'], $tric_inspPath);
        $tric_inspPath = $hashedtric_insp; // Store only the filename
        $changes = true;
        
        $updatedFiles[] = "Tricycle Inspection";
    }


    // Handle tricycle pics upload if new files are uploaded
    if (!empty($tricyclePics['name'][0])) {
        // Remove existing tricycle pics
        foreach ($tricyclePicsArray as $pic) {
            $tricyclePicPath = "../../uploads/tricyclePics/" . $pic;
            if (file_exists($tricyclePicPath)) {
                unlink($tricyclePicPath);
            }
        }

        $tricyclePicsHashed = [];
        foreach ($tricyclePics['name'] as $key => $name) {
            if ($tricyclePics['error'][$key] === UPLOAD_ERR_OK) {
                $fileExtension = pathinfo($name, PATHINFO_EXTENSION);
                $hashedTricyclePic = md5(time() . $name) . '.' . $fileExtension;
                $tricyclePicPath = "../../uploads/tricyclePics/" . $hashedTricyclePic;
                move_uploaded_file($tricyclePics['tmp_name'][$key], $tricyclePicPath);
                $tricyclePicsHashed[] = $hashedTricyclePic;
            }
        }
        $tricyclePicsArray = $tricyclePicsHashed;
        $changes = true;
        
        $updatedFiles[] = "Tricycle Pictures";
    }

    // Update query
    if ($changes) {
        // Prepare the SQL statement
        $sql = "UPDATE applicants SET 
                    operatorsPic = ?, 
                    driversPic1 = ?, 
                    driversPic2 = ?, 
                    toda_cert = ?, 
                    valid_id = ?, 
                    sedula = ?, 
                    license = ?, 
                    med_res = ?, 
                    cr = ?, 
                    `or` = ?, 
                    deedSale = ?, 
                    tric_insp = ?, 
                    tricyclePics = ?
                WHERE id = ?";
        
        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, 'sssssssssssssi', 
                $operatorsPicPath, 
                $driversPic1Path, 
                $driversPic2Path, 
                $todaCertPath, 
                $validIdPath, 
                $sedulaPath, 
                $licensePath, 
                $medResPath, 
                $crPath, 
                $orPath, 
                $deedSalePath, 
                $tric_inspPath, 
                json_encode($tricyclePicsArray),
                $id
            );
    
            // Execute the statement
            $result = mysqli_stmt_execute($stmt);
    
            // Check if the update was successful
            if ($result) {
                $_SESSION['status'] = "File/s updated";
                $_SESSION['status_code'] = "success";
                
                
                // Insert into logs_history
                $userId = $_SESSION['user_id']; // Assuming you have this stored in the session
                $franchiseNo = ''; // Assuming franchise number is the same as ID
                $dateTime = date('Y-m-d H:i:s'); // Current date and time
                $accountType = $_SESSION['account_type']; // Assuming this is stored in the session
                $username = $_SESSION['username']; // Assuming this is stored in the session
                $action = implode(", ", $updatedFiles) . " of Applicant ID:$id is updated";
    
                $log_sql = "INSERT INTO logs_history (user_id, action, franchise_no, date_time, account_type, username) VALUES (?, ?, ?, ?, ?, ?)";
                if ($log_stmt = mysqli_prepare($conn, $log_sql)) {
                    mysqli_stmt_bind_param($log_stmt, 'isssss', $userId, $action, $franchiseNo, $dateTime, $accountType, $username);
                    mysqli_stmt_execute($log_stmt);
                    mysqli_stmt_close($log_stmt);
                }
        
            } else {
                $_SESSION['status'] = "File/s not updated";
                $_SESSION['status_code'] = "error";
            }
    
            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            $_SESSION['status'] = "Failed to prepare the statement";
            $_SESSION['status_code'] = "error";
        }
    
        header("Location: edit.php?id=$id");
    } else {
        $_SESSION['status'] = "No changes detected";
        $_SESSION['status_code'] = "info";
        header("Location: edit.php?id=$id");
    }
    
}
?>
