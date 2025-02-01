<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../phpmailer/src/PHPMailer.php';
require '../../phpmailer/src/SMTP.php';
require '../../phpmailer/src/Exception.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

// Log all requests for debugging
error_log("Received request: " . json_encode($_POST));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id']) && !empty($_POST['reason_denial'])) {
    $id = intval($_POST['id']); // Ensure ID is an integer
    $denialReason = $_POST['reason_denial'];

    include "../../include/db_conn.php";

    // Log query parameters
    error_log("Applicant ID: $id, Denial Reason: $denialReason");

    $stmt = $conn->prepare("SELECT first_name, last_name, email, contact_num FROM applicants WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $applicantName = $row['first_name'] . ' ' . $row['last_name'];
        $email = $row['email'];
        $contact_num = $row['contact_num']; // Use the correct column name
    } else {
        error_log("No applicant found for ID: $id");
        echo json_encode(['status' => 'error', 'message' => 'No applicant found.']);
        $stmt->close();
        exit;
    }


    $stmt->close();

    $message = "Dear $applicantName,\n\nWe regret to inform you that your tricycle franchise application has been denied.\n\nReason for denial: $denialReason\n\nThank you for your understanding.";

    $mail = new PHPMailer(true);

    try {
        // Enable SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'mtfrblucban2024@gmail.com'; 
        $mail->Password   = 'uway leyk zkah dcda5';  
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;
        
        $mail->setFrom('mtfrblucban2024@gmail.com', 'MTFRB Lucban Office');
        $mail->addAddress($email, $applicantName);
        
        // Add BCC
        $mail->addBCC('mtfrblucban2024@gmail.com', 'MTFRB Lucban Office');
        
        $mail->isHTML(false);
        $mail->Subject = 'Tricycle Franchise Application Notification';
        $mail->Body    = $message;
        
        $mail->send();

        // Log success action
        $action = "Sent notification for denial of application to applicant: $applicantName (ID: $id)";
        $log_sql = "INSERT INTO logs_history (user_id, action, franchise_no, date_time, account_type, username) 
                    VALUES (?, ?, ?, ?, ?, ?)";
        if ($log_stmt = $conn->prepare($log_sql)) {
            $user_id = $_SESSION['user_id'] ?? 0; // Default to 0 if not set
            $franchise_no = NULL;
            $date_time = date('Y-m-d H:i:s');
            $account_type = $_SESSION['account_type'] ?? 'unknown';
            $username = $_SESSION['username'] ?? 'unknown';

            $log_stmt->bind_param('isssss', $user_id, $action, $franchise_no, $date_time, $account_type, $username);
            $log_stmt->execute();
            $log_stmt->close();
        }

        // Send SMS using Semaphore API
        $smsMessage = "Hi $applicantName, your application for a tricycle franchise has been denied. Reason: $denialReason. - MTFRB Lucban";
        $apiKey = '613064d06f3ca2eb22645ca581299fcc'; 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.semaphore.co/api/v4/messages');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'apikey' => $apiKey,
            'number' => $contact_num,
            'message' => $smsMessage,
            'sendername' => 'MTFRBLucban' 
        ]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsResponse = curl_exec($ch);
        curl_close($ch);

        // Log SMS response
        error_log("SMS response: $smsResponse");

        error_log("Email and SMS successfully sent to $email and $contact_num");
        echo json_encode(['status' => 'success', 'message' => 'Email and SMS sent successfully.']);
    } catch (Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}");
        echo json_encode(['status' => 'error', 'message' => "Mailer Error: {$mail->ErrorInfo}"]);
    }
} else {
    error_log("Invalid request: ID or denial reason not provided");
    echo json_encode(['status' => 'error', 'message' => 'ID or denial reason not provided or invalid request method.']);
}
?>