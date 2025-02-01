<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../phpmailer/src/PHPMailer.php';
require '../../phpmailer/src/SMTP.php';
require '../../phpmailer/src/Exception.php';

session_start(); 

header('Content-Type: application/json');

// Enable error reporting and start output buffering
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start();

$response = ['success' => false];

include "../../include/db_conn.php"; // Ensure this path is correct and initializes $conn

// Function to fetch operator details (email, name, last name, table name)
function getOperatorDetailsById($id, $conn) {
    $months = ['jan', 'feb', 'march', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct'];
    foreach ($months as $month) {
        $table_name = $month . '_operators';
        $sql = "SELECT email, first_name, last_name FROM $table_name WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            return null;
        }
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->bind_result($email, $fname, $lname);
        if ($stmt->fetch()) {
            $stmt->close();
            return ['email' => $email, 'first_name' => $fname, 'last_name' => $lname, 'table_name' => $table_name];
        }
        $stmt->close();
    }
    return null;
}

// Function to insert data into the same table where the operator is found
function insertDataIntoSameTable($formattedInterviewSchedule, $complaintDescription, $complaint_date, $operatorId, $table_name, $conn) {
    $sql = "UPDATE $table_name SET interview_schedule = ?, complaint_description = ?, complaint_date=? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return false;
    }
    $stmt->bind_param('sssi', $formattedInterviewSchedule, $complaintDescription, $complaint_date,  $operatorId);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $interviewSchedule = $_POST['interview_schedule'];
    $complaintDescription = $_POST['complaint_description'];
    $complaint_date=$_POST['complaint_date'];
    $operatorId = $_POST['id'];

    $operatorDetails = getOperatorDetailsById($operatorId, $conn);

    if ($operatorDetails) {
        $operatorEmail = $operatorDetails['email'];
        $operatorFname = $operatorDetails['first_name'];
        $operatorLname = $operatorDetails['last_name'];
        $table_name = $operatorDetails['table_name'];

        // Format the interview schedule to 12-hour format with AM/PM
        $dateTime = new DateTime($interviewSchedule);
        $formattedInterviewSchedule = $dateTime->format('Y-m-d h:i A');

        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'mtfrblucban2024@gmail.com';
            $mail->Password   = 'uway leyk zkah dcda';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            // Recipients
            $mail->setFrom('mtfrblucban2024@gmail.com', 'MTFRB Lucban Office');
            $mail->addAddress($operatorEmail);

            // Compose message
            $message = "
            Greetings: $operatorLname, $operatorFname

            There is someone who filed a complaint regarding your service on $complaint_date. For clarification, we request you 
            to come into the MTFRB office in Lucban, Quezon.

            The reason of complaint is: $complaintDescription.

            Your interview schedule will be on $formattedInterviewSchedule.

            Please acknowledge this message so we can take necessary action to resolve this complaint.

            Thank you!
            ";

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Interview Schedule for Complaint';
            $mail->Body    = nl2br($message);

            $mail->send();
            
            // Insert data into the same table where the operator is found using the form-submitted values
            if (insertDataIntoSameTable($formattedInterviewSchedule, $complaintDescription,$complaint_date, $operatorId, $table_name, $conn)) {
                $response['success'] = true;
            } else {
                $response['message'] = 'Email sent but failed to insert data into the database.';
            }
        } catch (Exception $e) {
            $response['message'] = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        }
    } else {
        $response['message'] = 'Invalid operator ID.';
    }

    ob_end_clean(); // Clear the buffer before sending JSON response
    echo json_encode($response);
    exit;
}

// Close the database connection
$conn->close();