<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../phpmailer/src/PHPMailer.php';
require '../../phpmailer/src/SMTP.php';
require '../../phpmailer/src/Exception.php';

session_start();

header('Content-Type: application/json');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'error_log.txt'); // Log errors to a file

$response = ['success' => false];

include "../../include/db_conn.php";

// Function to fetch operator details
function getOperatorDetailsById($id, $conn) {
    $months = ['jan', 'feb', 'march', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct'];
    foreach ($months as $month) {
        $table_name = $month . '_operators';
        $sql = "SELECT email, first_name, last_name, contact_num FROM $table_name WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            error_log("Failed to prepare statement for table $table_name: " . $conn->error);
            continue;
        }
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->bind_result($email, $fname, $lname, $contact_num);
        if ($stmt->fetch()) {
            $stmt->close();
            return [
                'email' => $email,
                'first_name' => $fname,
                'last_name' => $lname,
                'contact_num' => $contact_num,
                'table_name' => $table_name
            ];
        }
        $stmt->close();
    }
    return null;
}

// Function to insert/update data in the operator's table
function insertDataIntoSameTable($formattedInterviewSchedule, $complaintDescription, $complaint_date, $operatorId, $table_name, $conn) {
    $sql = "UPDATE $table_name SET interview_schedule = ?, complaint_description = ?, complaint_date = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Failed to prepare update statement for table $table_name: " . $conn->error);
        return false;
    }
    $stmt->bind_param('sssi', $formattedInterviewSchedule, $complaintDescription, $complaint_date, $operatorId);
    $result = $stmt->execute();
    if (!$result) {
        error_log("Failed to execute update statement for table $table_name: " . $stmt->error);
    }
    $stmt->close();
    return $result;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $interviewSchedule = $_POST['interview_schedule'];
    $complaintDescription = $_POST['complaint_description'];
    $complaint_date = $_POST['complaint_date'];
    $operatorId = $_POST['id'];

    $operatorDetails = getOperatorDetailsById($operatorId, $conn);

    if ($operatorDetails) {
        $operatorEmail = $operatorDetails['email'];
        $operatorFname = $operatorDetails['first_name'];
        $operatorLname = $operatorDetails['last_name'];
        $contact_num = $operatorDetails['contact_num'];
        $table_name = $operatorDetails['table_name'];

        // Format the interview schedule to 12-hour format with AM/PM
        $dateTime = new DateTime($interviewSchedule);
        $formattedInterviewSchedule = $dateTime->format('Y-m-d h:i A');

        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'mtfrblucban2024@gmail.com';
            $mail->Password = 'uway leyk zkah dcda';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            // Recipients
            $mail->setFrom('mtfrblucban2024@gmail.com', 'MTFRB Lucban Office');
            $mail->addAddress($operatorEmail);
            $mail->addBCC('mtfrblucban2024@gmail.com', 'MTFRB Lucban Office');

            // Compose message
            $message = "
            Greetings: $operatorFname $operatorLname

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
            $mail->Body = nl2br($message);

            $mail->send();

            // SMS message
            $smsMessage = "Hi $operatorFname, There is someone who filed a complaint regarding your service on $complaint_date. For clarification, we request you to come into the MTFRB office for an interview on $formattedInterviewSchedule.";

            // Send SMS using Semaphore API
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

            // Check if data was successfully updated in the database
            if (insertDataIntoSameTable($formattedInterviewSchedule, $complaintDescription, $complaint_date, $operatorId, $table_name, $conn)) {
                // Log success action
                $action = "Sent notification for complaint to operator: $operatorFname";
                $log_sql = "INSERT INTO logs_history (user_id, action, franchise_no, date_time, account_type, username) 
                            VALUES (?, ?, ?, ?, ?, ?)";
                if ($log_stmt = $conn->prepare($log_sql)) {
                    $user_id = $_SESSION['user_id'] ?? 0;
                    $franchise_no = NULL;
                    $date_time = date('Y-m-d H:i:s');
                    $account_type = $_SESSION['account_type'] ?? 'unknown';
                    $username = $_SESSION['username'] ?? 'unknown';

                    $log_stmt->bind_param('isssss', $user_id, $action, $franchise_no, $date_time, $account_type, $username);
                    if (!$log_stmt->execute()) {
                        error_log('Log insertion failed: ' . $log_stmt->error);
                    }
                    $log_stmt->close();
                } else {
                    error_log('Log statement preparation failed: ' . $conn->error);
                }

                $response['success'] = true;
                $response['message'] = 'Email and SMS sent successfully.';
            } else {
                $response['message'] = 'Email and SMS sent, but failed to update the database.';
            }
        } catch (Exception $e) {
            $response['message'] = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        }
    } else {
        $response['message'] = 'Invalid operator ID.';
    }

    echo json_encode($response);
    exit;
}

// Close the database connection
$conn->close();
?>
