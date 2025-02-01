<?php
session_start();
include "../../include/db_conn.php";
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

// Set the default timezone
date_default_timezone_set('Asia/Manila');

// Check if the POST request contains the required data
if (isset($_POST['id']) && isset($_POST['status'])) {
    // Retrieve the applicant ID and new status
    $applicantId = intval($_POST['id']);
    $newStatus = htmlspecialchars(trim($_POST['status']));

    try {
        // Update the account status in the database
        $sql = "UPDATE applicants SET account_status = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $newStatus, $applicantId);

        if ($stmt->execute()) {
            // Send email and SMS if status is 'Active'
            if ($newStatus === 'Active') {
                // Fetch the applicant's details for email and SMS
                $stmt = $conn->prepare("SELECT first_name, email, contact_num FROM applicants WHERE id = ?");
                $stmt->bind_param("i", $applicantId);
                $stmt->execute();
                $result = $stmt->get_result();
                $applicant = $result->fetch_assoc();

            // Send SMS
                $smsResponse = sendSMS($applicant['contact_num'], "Hello {$applicant['first_name']}, your account is now active! Please visit the MTFRB Lucban website and log in to your account to access your dashboard.");

                // Send the email with BCC
                $emailResponse = sendEmail($applicant['email'], $applicant['first_name']);

                // Log success action after sending SMS and email
                $action = "Sent account activation notification to applicant: {$applicant['first_name']} (ID: $applicantId)";
                $log_sql = "INSERT INTO logs_history (user_id, action, franchise_no, date_time, account_type, username) 
                            VALUES (?, ?, ?, ?, ?, ?)";
                
                if ($log_stmt = $conn->prepare($log_sql)) {
                    $user_id = $_SESSION['user_id'] ?? 0; // Default to 0 if not set
                    $franchise_no = NULL; // You can update this if necessary
                    $date_time = date('Y-m-d H:i:s');
                    $account_type = $_SESSION['account_type'] ?? 'unknown';
                    $username = $_SESSION['username'] ?? 'unknown';

                    $log_stmt->bind_param('isssss', $user_id, $action, $franchise_no, $date_time, $account_type, $username);
                    $log_stmt->execute();
                    $log_stmt->close();
                }

                // Return a success message along with email and SMS status
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Account status updated and notification sent successfully',
                    'smsStatus' => $smsResponse,
                    'emailStatus' => $emailResponse
                ]);
            } else {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Account status updated and notification sent successfully'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to update account status. Please try again.'
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'An unexpected error occurred: ' . $e->getMessage()
        ]);
    }
} else {
    // Return an error for invalid requests
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request. Please provide the required data.'
    ]);
}

// Function to send SMS
function sendSMS($contact_num, $message) {
    $apiKey = '613064d06f3ca2eb22645ca581299fcc';  
    $url = 'https://api.semaphore.co/api/v4/messages';

    $data = [
        'apikey' => $apiKey,
        'number' => $contact_num,
        'message' => $message,
        'sendername' => 'MTFRBLucban'
    ];

    $options = [
        'http' => [
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data),
        ],
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    return $response ? "SMS sent successfully." : "Failed to send SMS.";
}

// Function to send email with BCC
function sendEmail($email, $first_name) {
    $mail = new PHPMailer(true);

    try {
        // Set up the mailer
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'mtfrb_lucban@mtfrblucban.com';  
        $mail->Password = 'MTFRB_Lucban2025';  
        $mail->SMTPSecure = 'ssl';
        $mail->Port =  465;

        // From and To
        $mail->setFrom('mtfrb_lucban@mtfrblucban.com', 'MTFRB Lucban Office');
        $mail->addAddress($email, $first_name);  // Applicant email
        $mail->addBCC('mtfrb_lucban@mtfrblucban.com', 'MTFRB Lucban Office');  

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Account Activated';
        $mail->Body    = "<p>Dear $first_name,</p><p>Your account has been activated successfully!</p>
        <p>To access your dashboard and view all the data and requirements submitted in the online application.</p>
        <p>You may login using link https://mtfrblucban.com/franchise_applicant/applicant_login.php 
        <p>Best regards,<br>MTRFB Lucban</p>";

        // Send the email
        $mail->send();
        return "Email sent successfully.";
    } catch (Exception $e) {
        return "Email failed to send. Error: {$mail->ErrorInfo}";
    }
}
?>
