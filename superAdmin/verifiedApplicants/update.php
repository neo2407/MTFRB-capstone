<?php
session_start(); // Start the session
include "../../include/db_conn.php";

if (isset($_POST["submit"])) {
    $edit_id = $_POST['id'];
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $m_name = mysqli_real_escape_string($conn, $_POST['m_name']);
    $b_date = mysqli_real_escape_string($conn, $_POST['b_date']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $gender = mysqli_real_escape_string($conn, $_POST['sex']);
    $contact_num = mysqli_real_escape_string($conn, $_POST['contact_num']);
    $driver1_name = mysqli_real_escape_string($conn, $_POST['driver1_name']);
    $driver2_name = mysqli_real_escape_string($conn, $_POST['driver2_name']);
    $tricColor = mysqli_real_escape_string($conn, $_POST['tricColor']);
    $tricType = mysqli_real_escape_string($conn, $_POST['tricType']);

    // Fetch existing data
    $updatePics = "SELECT * FROM applicants WHERE id = '$edit_id'";
    $updatePics_run = mysqli_query($conn, $updatePics);
    $pic_row = mysqli_fetch_assoc($updatePics_run);

    $driversPicPath = $pic_row['driversPic'];
    $licensePath = $pic_row['license'];
    $tricyclePicsArray = json_decode($pic_row['tricyclePics'], true);

    // Variables to track changes
    $changes = false;

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
    }

    // Handle driversPic1 upload if a new file is uploaded
    if (!empty($_FILES['driversPic1']['name'])) {
        $hashedDriversPic1 = md5(time() . $_FILES['driversPic1']['name']) . '.' . pathinfo($_FILES['driversPic1']['name'], PATHINFO_EXTENSION);
        $driversPic1Path = "../../uploads/driversPic1/" . $hashedDriversPic1;
        if (file_exists("../../uploads/driversPic1/" . $pic_row['driversPic1'])) {
            unlink("../../uploads/driversPic1/" . $pic_row['driversPic1']);
        }
        move_uploaded_file($_FILES['driversPic1']['tmp_name'], $driversPic1Path);
        $driversPic1Path = $hashedDriversPic1; // Store only the filename
        $changes = true;
    }

    // Handle driversPic2 upload if a new file is uploaded
    if (!empty($_FILES['driversPic2']['name'])) {
        $hashedDriversPic2 = md5(time() . $_FILES['driversPic2']['name']) . '.' . pathinfo($_FILES['driversPic2']['name'], PATHINFO_EXTENSION);
        $driversPic2Path = "../../uploads/driversPic2/" . $hashedDriversPic2;
        if (file_exists("../../uploads/driversPic2/" . $pic_row['driversPic2'])) {
            unlink("../../uploads/driversPic2/" . $pic_row['driversPic2']);
        }
        move_uploaded_file($_FILES['driversPic2']['tmp_name'], $driversPic2Path);
        $driversPic2Path = $hashedDriversPic2; // Store only the filename
        $changes = true;
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
        // Upload new tricycle pics
        $tricyclePicsArray = [];
        for ($i = 0; $i < count($_FILES['tricyclePics']['name']); $i++) {
            $tricyclePicName = md5(time() . $_FILES['tricyclePics']['name'][$i]) . '.' . pathinfo($_FILES['tricyclePics']['name'][$i], PATHINFO_EXTENSION);
            $tricyclePicPath = "../../uploads/tricyclePics/" . $tricyclePicName;
            move_uploaded_file($_FILES['tricyclePics']['tmp_name'][$i], $tricyclePicPath);
            $tricyclePicsArray[] = $tricyclePicName; // Store only the filenames
        }
        $tricyclePicsArray = json_encode($tricyclePicsArray);
        $changes = true;
    }

    // Update query
    $sql = "UPDATE applicants SET 
                first_name='$first_name',
                last_name='$last_name',
                m_name='$m_name',
                b_date='$b_date',
                age='$age',
                address='$address',
                email='$email',
                sex='$gender',
                contact_num='$contact_num',
                driver1_name='$driver1_name',
                driver2_name='$driver2_name',
                tricColor='$tricColor',
                tricType='$tricType',
                operatorsPic='$operatorsPicPath',
                driversPic1='$driversPic1Path',
                driversPic2='$driversPic2Path',
                toda_cert='$todaCertPath',
                valid_id='$validIdPath',
                sedula='$sedulaPath',
                license='$licensePath',
                med_res='$medResPath',
                cr='$crPath',
                or='$orPath',
                tricyclePics='$tricyclePicsArray'
            WHERE id='$edit_id'";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['status'] = "Update successful!";
        header("Location: ../update.php?id=$edit_id");
    } else {
        $_SESSION['status'] = "Update failed!";
        header("Location: ../update.php?id=$edit_id");
    }
}
?>
