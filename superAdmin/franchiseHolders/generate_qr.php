<?php
session_start(); 

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Log errors to a file for additional debugging
ini_set('log_errors', 1);
ini_set('error_log', 'error.log');  // Adjust the path

include "phpqrcode/qrlib.php"; 
include "../include/db_conn.php";

if (isset($_POST['submit'])) {
    // Retrieve the operator ID from the POST data
    $operatorId = htmlspecialchars($_POST['id']);

    // Encode the operator ID for security
    $encodedId = base64_encode($operatorId);

    // Retrieve the operator's data from the database
    $query = "
    SELECT * FROM jan_operators WHERE id = ? UNION 
    SELECT * FROM feb_operators WHERE id = ? UNION 
    SELECT * FROM march_operators WHERE id = ? UNION 
    SELECT * FROM apr_operators WHERE id = ? UNION
    SELECT * FROM may_operators WHERE id = ? UNION  
    SELECT * FROM jun_operators WHERE id = ? UNION 
    SELECT * FROM jul_operators WHERE id = ? UNION 
    SELECT * FROM aug_operators WHERE id = ? UNION 
    SELECT * FROM sep_operators WHERE id = ? UNION 
    SELECT * FROM oct_operators WHERE id = ?";

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo "Error preparing query: " . $conn->error;
        exit();
    }

    $stmt->bind_param("iiiiiiiiii", $operatorId, $operatorId, $operatorId, $operatorId, $operatorId, $operatorId, $operatorId, $operatorId, $operatorId, $operatorId);
    if (!$stmt->execute()) {
        echo "Error executing query: " . $stmt->error;
        exit();
    }
    $result = $stmt->get_result();

    // Check if data was fetched successfully
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Store the fetched data in $row

        // Retrieve the TFno for file naming
        $TFno = $row['TFno'];

        // Directory where QR codes will be saved
        $dir = $_SERVER['DOCUMENT_ROOT'] . '/qrcodes/'; // Use absolute path (adjust as needed)

        // Check if directory is writable
        if (!is_writable($dir)) {
            echo "Directory is not writable: " . $dir;
            exit();
        }

        // Generate a unique file name for the QR code using TFno and timestamp
        $fileName = 'qr_' . $TFno . '_' . time() . '.png';
        $filePath = $dir . $fileName;

        // URL to encode in the QR code (link to view_operator.php with encoded operator ID as a parameter)
        $qrData = "https://mtfrblucban.com/view_operator.php?id=" . urlencode($encodedId);

        // Debugging: Check the generated URL and file path
        echo "Encoded ID: " . $encodedId . "<br>";
        echo "QR Data: " . $qrData . "<br>";
        echo "Saving QR code to: " . $filePath . "<br>";

        // Ensure QR code generation works
        try {
            QRcode::png($qrData, $filePath, QR_ECLEVEL_L, 10);
            echo "QR code successfully generated and saved at: " . $filePath . "<br>";
            
            // Log the action in logs_history table
            $user_id = $_SESSION['user_id'];
            $account_type = $_SESSION['account_type'];
            $username = $_SESSION['username'];
            $date_time = date('Y-m-d H:i:s');
            $action = "QR Code generated for operator TFno $TFno.";  // Update the action message as needed
            $franchise_no = isset($_SESSION['franchise_no']) ? $_SESSION['franchise_no'] : null;

            $logQuery = "INSERT INTO logs_history (user_id, action, franchise_no, date_time, account_type, username) VALUES (?, ?, ?, ?, ?, ?)";
            if ($logStmt = $conn->prepare($logQuery)) {
                $logStmt->bind_param("isssss", $user_id, $action, $franchise_no, $date_time, $account_type, $username);
                $logStmt->execute();
                $logStmt->close();
            }
        } catch (Exception $e) {
            echo "Error generating QR code: " . $e->getMessage();
            exit();
        }

        // Update queries for each table
        $tables = ['jan_operators', 'feb_operators', 'march_operators', 'apr_operators', 'may_operators', 'jun_operators', 'jul_operators', 'aug_operators', 'sep_operators', 'oct_operators'];
        foreach ($tables as $table) {
            $updateQuery = "UPDATE $table SET qr_code = ? WHERE id = ?";
            $stmtUpdate = $conn->prepare($updateQuery);
            if (!$stmtUpdate) {
                echo "Error preparing update query for table: $table";
                exit();
            }
            $stmtUpdate->bind_param("si", $fileName, $operatorId);
            if (!$stmtUpdate->execute()) {
                echo "Error executing update query for table: $table";
                exit();
            }
        }

        // Set a success message and redirect
        $_SESSION['status'] = "QR Code Generated Successfully!";
        $_SESSION['status_code'] = "success";
        header("Location: edit_operatorDash.php?id=$operatorId");
        exit();
    } else {
        echo "No data found for this operator.";
    }
} else {
    // Redirect back if the form was not submitted correctly
    header("Location: franchiseHolders.php");
    exit();
}
?>
