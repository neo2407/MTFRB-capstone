<?php
include "../../include/db_conn.php";
session_start();

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$fileType = isset($_POST['fileType']) ? mysqli_real_escape_string($conn, $_POST['fileType']) : '';
$status = isset($_POST['status']) ? mysqli_real_escape_string($conn, $_POST['status']) : '';
$remarks = isset($_POST['remarks']) ? mysqli_real_escape_string($conn, $_POST['remarks']) : '';

// Debugging output
error_log("ID: $id, FileType: $fileType, Status: $status, Remarks: $remarks");

if ($id === 0 || empty($fileType) || empty($status)) {
    echo "Invalid parameters.";
    exit();
}

// Construct the SQL query based on the fileType
$sql = '';

switch ($fileType) {
    case 'operatorsPic':
        $sql = "UPDATE applicants SET operatorsPicStatus = '$status', operatorsPicRemarks = '$remarks' WHERE id = $id";
        break;
    case 'toda_cert':
        $sql = "UPDATE applicants SET toda_certStatus = '$status', toda_certRemarks = '$remarks' WHERE id = $id";
        break;
    case 'valid_id':
        $sql = "UPDATE applicants SET valid_idStatus = '$status', valid_idRemarks = '$remarks' WHERE id = $id";
        break;
    case 'sedula':
        $sql = "UPDATE applicants SET sedulaStatus = '$status', sedulaRemarks = '$remarks' WHERE id = $id";
        break;
    case 'driversPic1':
        $sql = "UPDATE applicants SET driversPic1Status = '$status', driversPic1Remarks = '$remarks' WHERE id = $id";
        break;
    case 'driversPic2':
        $sql = "UPDATE applicants SET driversPic2Status = '$status', driversPic2Remarks = '$remarks' WHERE id = $id";
        break;
    case 'license':
        $sql = "UPDATE applicants SET licenseStatus = '$status', licenseRemarks = '$remarks' WHERE id = $id";
        break;
    case 'med_res':
        $sql = "UPDATE applicants SET med_resStatus = '$status', med_resRemarks = '$remarks' WHERE id = $id";
        break;
    case 'cr':
        $sql = "UPDATE applicants SET crStatus = '$status', crRemarks = '$remarks' WHERE id = $id";
        break;
    case 'or':
        $sql = "UPDATE applicants SET orStatus = '$status', orRemarks = '$remarks' WHERE id = $id";
        break;
    case 'tricyclePics':
        $sql = "UPDATE applicants SET tricyclePicsStatus = '$status', tricyclePicsRemarks = '$remarks' WHERE id = $id";
        break;
    case 'deedSale':
        $sql = "UPDATE applicants SET deedSaleStatus = '$status', deedSaleRemarks = '$remarks' WHERE id = $id";
        break;
    case 'tric_insp':
        $sql = "UPDATE applicants SET tric_inspStatus = '$status', tric_inspRemarks = '$remarks' WHERE id = $id";
        break;
    default:
        echo "Invalid fileType.";
        exit();
}

// Debugging output
error_log("SQL Query: $sql");

if (!empty($sql)) {
    if ($conn->query($sql) === TRUE) {
        // Log the update action
        $action = "Applicant $id:$fileType has been marked as $status ";
        $log_sql = "INSERT INTO logs_history (user_id, action, franchise_no, date_time, account_type, username) 
                    VALUES (?, ?, ?, ?, ?, ?)";
        if ($log_stmt = $conn->prepare($log_sql)) {
            $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session
            $franchise_no = NULL; // Adjust as necessary
            $date_time = date('Y-m-d H:i:s');
            $account_type = $_SESSION['account_type']; // Assuming account_type is stored in session
            $username = $_SESSION['username']; // Assuming username is stored in session

            $log_stmt->bind_param('isssss', $user_id, $action, $franchise_no, $date_time, $account_type, $username);
            $log_stmt->execute();
            $log_stmt->close();
        }
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "SQL query was not set.";
}

$conn->close();
?>+
