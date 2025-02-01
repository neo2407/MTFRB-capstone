<?php
session_start(); // Start the session
include "../../include/db_conn.php"; // Include the database connection

if (isset($_POST['submit'])) {
    // Retrieve and sanitize form data
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $ticketNo = mysqli_real_escape_string($conn, $_POST['ticketNo']);
    $violationDate = mysqli_real_escape_string($conn, $_POST['violationDate']);
    $violationType = mysqli_real_escape_string($conn, $_POST['violationType']);
    $TFno = mysqli_real_escape_string($conn, $_POST['TFno']);
    $penaltyCharged = mysqli_real_escape_string($conn, $_POST['penaltyCharged']);
    $penaltyStatus = mysqli_real_escape_string($conn, $_POST['penaltyStatus']);
    $offenseType = mysqli_real_escape_string($conn, $_POST['offenseType']);
    $enforcer = mysqli_real_escape_string($conn, $_POST['enforcer']);

    // Update the record in the database
    $sql = "UPDATE violations 
            SET ticketNo='$ticketNo', violationDate='$violationDate', violationType='$violationType', 
                TFno='$TFno', penaltyCharged='$penaltyCharged', penaltyStatus='$penaltyStatus', 
                offenseType='$offenseType', enforcer='$enforcer'
            WHERE id='$id'";

$result = mysqli_query($conn, $sql);
if ($result) {
    // Success message
    $_SESSION['status'] = "Violators Information Updated Successfully";
    $_SESSION['status_code'] = "success";
    header("Location: edit_Violations.php?ticketNo=$ticketNo");
    exit();
   
} else {
    // Error message
    $_SESSION['status'] = "Connection error.";
            $_SESSION['status_code'] = "error";
            header("Location: edit_Violations.php?ticketNo=$ticketNo");
            exit();
    }
}
// Close the connection
mysqli_close($conn);
?>

