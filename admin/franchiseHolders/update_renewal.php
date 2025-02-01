<?php
session_start(); // Start the session
include "../include/db_conn.php";
if (isset($_POST["submit"])) {
    $id = $_POST['id'];
    $status = isset($_POST['status']) ? trim($_POST['status']) : '';
    $expDate = isset($_POST['expDate']) ? trim($_POST['expDate']) : '';
    $dtOfrenewal = isset($_POST['dtOfrenewal']) ? trim($_POST['dtOfrenewal']) : '';
    $renewal_payment = isset($_POST['renewal_payment']) ? trim($_POST['renewal_payment']) : '0';
    $penalty = isset($_POST['penalty']) ? trim($_POST['penalty']) : '0';
    
     //if ($expDate) {
        //$expDate = DateTime::createFromFormat('Y-m-d', $expDate)->format('d/m/Y');
    //}**/
    
    // Fetch existing data
    $updateData = "SELECT * FROM `jan_operators` WHERE id = ? UNION 
    SELECT * FROM `feb_operators` WHERE id = ? UNION 
    SELECT * FROM `march_operators` WHERE id = ? UNION 
    SELECT * FROM `apr_operators` WHERE id = ? UNION 
    SELECT * FROM `may_operators` WHERE id = ? UNION 
    SELECT * FROM `jun_operators` WHERE id = ? UNION 
    SELECT * FROM `jul_operators` WHERE id = ? UNION 
    SELECT * FROM `aug_operators` WHERE id = ? UNION 
    SELECT * FROM `sep_operators` WHERE id = ? UNION 
    SELECT * FROM `oct_operators` WHERE id = ?";

    if ($stmt = $conn->prepare($updateData)) {
        $stmt->bind_param("iiiiiiiiii", $id, $id, $id, $id, $id, $id, $id, $id, $id, $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
    }

    // Variables to track changes
    $changes = false;

    if ($status !== $result['status'] || $expDate !== $result['expDate'] || $dtOfrenewal !== $result['dtOfrenewal'] ||
    $renewal_payment !== $result['renewal_payment'] || $penalty !== $result['penalty']  || $changes) {

        $tables = ['jan_operators', 'feb_operators', 'march_operators', 'apr_operators', 'may_operators', 'jun_operators', 'jul_operators', 'aug_operators', 'sep_operators', 'oct_operators'];

        $updateQuery = "UPDATE %s SET status=?, expDate=?, dtOfrenewal=?, renewal_payment=?, penalty=? WHERE id=?";
        $updateSuccessful = false;

        foreach ($tables as $table) {
            $query = sprintf($updateQuery, $table);
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("sssiii", $status, $expDate, $dtOfrenewal, $renewal_payment, $penalty, $id);
                $result = $stmt->execute();
                if ($result) {
                    $updateSuccessful = true;
                }
                $stmt->close();
            }
        }

        if ($updateSuccessful) {
            $_SESSION['status'] = "Franchise Renewal Information Updated Successfully";
            $_SESSION['status_code'] = "success";
        } else {
            $_SESSION['status'] = "Franchise Renewal Information not updated";
            $_SESSION['status_code'] = "error";
        }
    } else {
        $_SESSION['status'] = "No changes detected";
        $_SESSION['status_code'] = "info";
    }

    header("Location: edit_operatorDash.php?id=$id");
    exit;
}

?>
