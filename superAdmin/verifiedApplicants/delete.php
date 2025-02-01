<?php
session_start();
include "../../include/db_conn.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // Define the upload directories
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

    // Retrieve the file paths from the database
    $sqlSelect = "SELECT driversPic1, driversPic2, license, tricyclePics, operatorsPic, toda_cert, valid_id, sedula, cr, `or`, deedSale, med_res FROM `applicants` WHERE id = ?";
    $stmtSelect = mysqli_prepare($conn, $sqlSelect);

    if ($stmtSelect) {
        mysqli_stmt_bind_param($stmtSelect, "i", $id);
        mysqli_stmt_execute($stmtSelect);
        mysqli_stmt_bind_result($stmtSelect, $driversPic1, $driversPic2, $license, $tricyclePics, $operatorsPic, $todaCert, $validID, $sedula, $cr, $or, $deedSale, $medRes);
        mysqli_stmt_fetch($stmtSelect);
        mysqli_stmt_close($stmtSelect);

        // Create an array to handle all files for deletion
        $filesToDelete = [
            $uploadDirDriver1 . $driversPic1,
            $uploadDirDriver2 . $driversPic2,
            $uploadDirLicense . $license,
            $uploadDirOperator . $operatorsPic,
            $uploadDirTodaCert . $todaCert,
            $uploadDirValidId . $validID,
            $uploadDirSedula . $sedula,
            $uploadDirCr . $cr,
            $uploadDirOr . $or,
            $uploadDirDeedSale . $deedSale,
            $uploadDirMedRes . $medRes
        ];

        // Delete the files if they exist
        foreach ($filesToDelete as $filePath) {
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // Unlink (delete) the tricycle pics files
        $tricyclePicsArray = json_decode($tricyclePics, true);
        if (is_array($tricyclePicsArray)) {
            foreach ($tricyclePicsArray as $tricyclePic) {
                $tricyclePicPath = $uploadDirTricycle . $tricyclePic;
                if (file_exists($tricyclePicPath)) {
                    unlink($tricyclePicPath);
                }
            }
        }

        // Prepare the SQL statement for deletion
        $sqlDelete = "DELETE FROM `applicants` WHERE id = ?";
        $stmtDelete = mysqli_prepare($conn, $sqlDelete);

        if ($stmtDelete) {
            // Bind the parameter
            mysqli_stmt_bind_param($stmtDelete, "i", $id);

            // Execute the statement
            mysqli_stmt_execute($stmtDelete);

            // Check if the deletion was successful
            if (mysqli_stmt_affected_rows($stmtDelete) > 0) {
                $_SESSION['status'] = "Applicant deleted successfully";
                $_SESSION['status_code'] = "success";
                header('Location: verifiedApplicants.php');
                exit();
            } else {
                $_SESSION['status'] = "Applicant not deleted";
                $_SESSION['status_code'] = "error";
                header('Location: verifiedApplicants.php');
                exit();
            }

            // Close the statement
            mysqli_stmt_close($stmtDelete);
        } else {
            $_SESSION['msg'] = "Failed: " . mysqli_error($conn);
            header("Location: verifiedApplicants.php");
            exit();
        }
    } else {
        $_SESSION['msg'] = "Failed to retrieve file paths: " . mysqli_error($conn);
        header("Location: verifiedApplicants.php");
        exit();
    }
} else {
    $_SESSION['msg'] = "Invalid request.";
    header("Location: verifiedApplicants.php");
    exit();
}

// Close the database connection
mysqli_close($conn);
?>
