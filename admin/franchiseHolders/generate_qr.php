<?php
session_start(); 

include('../../phpqrcode/qrlib.php'); // phpqrcode library
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
    $stmt->bind_param("iiiiiiiiii", $operatorId, $operatorId, $operatorId, $operatorId, $operatorId, $operatorId, $operatorId, $operatorId, $operatorId, $operatorId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if data was fetched successfully
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Store the fetched data in $row

        // Retrieve the TFno for file naming
        $TFno = $row['TFno'];

        // Directory where QR codes will be saved
        $dir = '../../qrcodes/'; 

        // Check if directory exists, if not create it
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true); // Creates the directory with the necessary permissions
        }

        // Generate a unique file name for the QR code using TFno
        $fileName = 'qr_' . $TFno . '.png';
        $filePath = $dir . $fileName;

        // URL to encode in the QR code (link to view_operator.php with encoded operator ID as a parameter)
        $qrData = "https://mtfrblucban.com/view_operator.php?id=" . urlencode($encodedId);

        // Generate and save the QR code
        QRcode::png($qrData, $filePath, QR_ECLEVEL_L, 10);

        // Update queries for each table
        $tables = ['jan_operators', 'feb_operators', 'march_operators', 'apr_operators', 'may_operators', 'jun_operators', 'jul_operators', 'aug_operators', 'sep_operators', 'oct_operators'];
        foreach ($tables as $table) {
            $updateQuery = "UPDATE $table SET qr_code = ? WHERE id = ?";
            $stmtUpdate = $conn->prepare($updateQuery);
            $stmtUpdate->bind_param("si", $fileName, $operatorId);
            $stmtUpdate->execute();
        }

        // Redirect with success status if the update succeeds
        if ($stmtUpdate->execute()) {
            $_SESSION['status'] = "QR Code Generated";
            $_SESSION['status_code'] = "success";
            header("Location: edit_operatorDash.php?id=$operatorId");
        }
    } else {
        echo "No data found for this operator.";
    }
} else {
    // Redirect back if the form was not submitted correctly
    header("Location: franchiseHolders.php");
    exit();
}
?>
