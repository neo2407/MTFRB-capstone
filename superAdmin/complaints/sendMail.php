<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../phpmailer/src/PHPMailer.php';
require '../../phpmailer/src/SMTP.php';
require '../../phpmailer/src/Exception.php';

header('Content-Type: application/json');

// Check if the ID is provided via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    include "../../include/db_conn.php";

    // Check connection
    if ($conn->connect_error) {
        echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conn->connect_error]);
        exit;
    }

    // Fetch applicant details
    $stmt = $conn->prepare("SELECT first_name, last_name, interview_dt, email, contactNum FROM complaints WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $complainant_fname = $row['first_name'];
        $complainant_lname = $row['last_name'];
        $interview_schedule = $row['interview_dt'];
        $email = $row['email'];
        $contactNum = $row['contactNum'];
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No complainant found.']);
        $stmt->close();
        $conn->close();
        exit;
    }

    $stmt->close();
    $conn->close();

    // Compose email message
    $email_message = "
    Greetings:  $complainant_fname $complainant_lname
    
    Your complaint has been reviewed by MTFRB Staff. 
    To resolve your complaint, please visit the MTFRB office in Lucban, Quezon. 

    Your interview is scheduled is on $interview_schedule.

    Thank you!
    ";

    // Compose SMS message
    $sms_message = "Greetings $complainant_fname, MTFRB Office received your complaint and to resolve it we scheduled your interview on $interview_schedule - Thank you.";

    // Send the message using PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Email settings
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'mtfrblucban2024@gmail.com';
        $mail->Password   = 'uway leyk zkah dcda';  
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

        $mail->setFrom('mtfrblucban2024@gmail.com', 'MTFRB Lucban Office');
        $mail->addAddress($email, "$complainant_fname $complainant_lname");
        $mail->addBCC('mtfrblucban2024@gmail.com', 'MTFRB Lucban Office');

        // Email content
        $mail->isHTML(false);
        $mail->Subject = 'Interview Schedule Notification for Complaint';
        $mail->Body    = $email_message;

        $mail->send();

        // Send SMS using Semaphore
        $api_key = '613064d06f3ca2eb22645ca581299fcc';
        $sms_data = [
            'apikey' => $api_key,
            'number' => $contactNum,
            'message' => $sms_message,
            'sendername' => 'MTFRBLucban'
        ];

        $sms_url = 'https://api.semaphore.co/api/v4/messages';
        $ch = curl_init($sms_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sms_data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($http_code === 200) {
            // Re-open DB connection for logging
            include "../../include/db_conn.php";

            // Log the action in logs_history table
            $user_id = $_SESSION['user_id'];
            $account_type = $_SESSION['account_type'];
            $username = $_SESSION['username'];
            $date_time = date('Y-m-d H:i:s');
            $action = "Interview Notification for complaint sent to complainant with ID: $id.";
            $franchise_no = isset($_SESSION['franchise_no']) ? $_SESSION['franchise_no'] : null;

            $logQuery = "INSERT INTO logs_history (user_id, action, franchise_no, date_time, account_type, username) VALUES (?, ?, ?, ?, ?, ?)";
            if ($logStmt = $conn->prepare($logQuery)) {
                $logStmt->bind_param("isssss", $user_id, $action, $franchise_no, $date_time, $account_type, $username);
                $logStmt->execute();
                $logStmt->close();
            }

            $conn->close();

            echo json_encode(['status' => 'success', 'message' => 'Email and SMS sent successfully, log recorded']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Email sent but failed to send SMS', 'sms_response' => $response]);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => "Mailer Error: {$mail->ErrorInfo}"]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID not provided or invalid request method.']);
}
