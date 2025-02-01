<?php
// Start session and include database connection
session_start();
include "../../include/db_conn.php";

// Check if the form was submitted
if (isset($_POST["submit"])) {
    // Retrieve form data
    $id = $_POST['id'];
    $orderId = $_POST['orderId'];
    $paymentDate = $_POST['paymentDate'];
    $nature = $_POST['nature'];
    $amount = $_POST['amount'];
    $amount_words = $_POST['amount_words'];

    // Get applicant's name from the database
    $sql = "SELECT first_name, last_name FROM applicants WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->bind_result($first_name, $last_name);
        $stmt->fetch();
        $applicant_name = $first_name . " " . $last_name;
        $stmt->close();
    }

    // Path to store the generated image
    $folderPath = "../../orderPayment/";
    if (!is_dir($folderPath)) {
        mkdir($folderPath, 0777, true); // Ensure the folder exists
    }

    // Image dimensions
    $width = 1200;
    $height = 800;

    // Create blank image
    $image = imagecreatetruecolor($width, $height);

    // Colors
    $white = imagecolorallocate($image, 255, 255, 255);
    $black = imagecolorallocate($image, 0, 0, 0);

    // Fill the background with white
    imagefilledrectangle($image, 0, 0, $width, $height, $white);

    // Centered header text
    $header_text = "Municipal Tricycle Franchising and Regulatory Board - Lucban";
    $header_text_width = imagefontwidth(5) * strlen($header_text);
    imagestring($image, 5, ($width - $header_text_width) / 2, 20, $header_text, $black);

    $address_text = "88 A. Racelis Ave, Lucban, Quezon";
    $address_text_width = imagefontwidth(4) * strlen($address_text);
    imagestring($image, 4, ($width - $address_text_width) / 2, 60, $address_text, $black);

    // Add Order of Payment title
    imagestring($image, 5, 500, 120, "ORDER OF PAYMENT", $black);

    // Add applicant's name, order ID, and payment date
    imagestring($image, 4, 100, 180, "Order ID: " . $orderId, $black);
    imagestring($image, 4, 100, 160, "Applicant: " . $applicant_name, $black);
    imagestring($image, 4, 100, 200, "Payment Date: " . $paymentDate, $black);

    // Draw table
    imagerectangle($image, 100, 250, 1100, 650, $black);
    imageline($image, 100, 300, 1100, 300, $black); // Horizontal line for header
    imageline($image, 700, 250, 700, 650, $black); // Vertical line to separate columns

    // Add table headers
    imagestring($image, 4, 120, 270, "Nature of Collection", $black);
    imagestring($image, 4, 720, 270, "Amount", $black);

    // Add form data to the table
    imagestring($image, 4, 120, 320, $nature, $black);
    imagestring($image, 4, 720, 320, "PHP " . number_format($amount, 2), $black);

    // Add total row
    imageline($image, 100, 580, 1100, 580, $black);
    imagestring($image, 4, 120, 600, "Total", $black);
    imagestring($image, 4, 720, 600, "PHP " . number_format($amount, 2), $black);

    // Add amount in words
    imagestring($image, 4, 100, 700, "Amount in Words:", $black);
    imagestring($image, 4, 300, 700, $amount_words, $black);

    // Save the image
    $imageFileName = "order_payment_$orderId.png";
    $filePath = $folderPath . $imageFileName;
    imagepng($image, $filePath);

    // Free memory
    imagedestroy($image);

    // Update database with the image filename
    $sql = "UPDATE applicants 
            SET orderId = ?, paymentDate = ?, nature = ?, amount = ?, amount_words = ?, order_payment_image = ? 
            WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('ississi', $orderId, $paymentDate, $nature, $amount, $amount_words, $imageFileName, $id);
        if ($stmt->execute()) {
            
            // Log the action in logs_history table
            $user_id = $_SESSION['user_id'];
            $account_type = $_SESSION['account_type'];
            $username = $_SESSION['username'];
            $date_time = date('Y-m-d H:i:s');
            $action = "Order of payment generated for applicant ID $id.";
            $franchise_no = isset($_SESSION['franchise_no']) ? $_SESSION['franchise_no'] : null;

            $logQuery = "INSERT INTO logs_history (user_id, action, franchise_no, date_time, account_type, username) VALUES (?, ?, ?, ?, ?, ?)";
            if ($logStmt = $conn->prepare($logQuery)) {
                $logStmt->bind_param("isssss", $user_id, $action, $franchise_no, $date_time, $account_type, $username);
                $logStmt->execute();
                $logStmt->close();
            }
            
            
            $_SESSION['status'] = "Order of Payment Added Successfully!";
            $_SESSION['status_code'] = "success";
            header("Location: edit.php?id=$id");
            exit();
        } else {
            $_SESSION['status'] = "Error updating record: " . $stmt->error;
            $_SESSION['status_code'] = "error";
        }
        $stmt->close();
    }

    $conn->close();
} else {
    header('HTTP/1.1 405 Method Not Allowed');
    $_SESSION['status'] = "Invalid request.";
    $_SESSION['status_code'] = "error";
}
