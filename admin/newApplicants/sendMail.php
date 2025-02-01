<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../phpmailer/src/PHPMailer.php';
require '../../phpmailer/src/SMTP.php';
require '../../phpmailer/src/Exception.php';

session_start();    

header('Content-Type: application/json');

// Check if the id is provided via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    include "../../include/db_conn.php";

    // Fetch applicant details
    $stmt = $conn->prepare("SELECT first_name, last_name, interview_sched, email FROM applicants WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $applicant_name = $row['first_name'];
        $applicant_lname = $row['last_name'];
        $interview_schedule = $row['interview_sched'];
        $email = $row['email'];
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No applicant found.']);
        $stmt->close();
        $conn->close();
        exit;
    }
    
    $stmt->close();

    // Compose message
    $message = "
    Greetings: $applicant_name $applicant_lname

    Your information and files submitted have been validated. 
    To proceed with the next phase of the application, we request you 
    to come into the MTFRB Lucban Office located at Lucban Minicipal Hall 3rd floor. 
    And look for Mrs. Judith Babierra or Mr. Justin Lee Babat.

    Your interview schedule will be on $interview_schedule.

    Please bring your original document/requirements submitted on the
    online application for further verification. 

    Thank you!
    ";

    // Send the message using PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'mtfrblucban2024@gmail.com'; 
        $mail->Password   = 'uway leyk zkah dcda';  
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;
        
        $mail->setFrom('mtfrblucban2024@gmail.com', 'MTFRB Lucban Office');
        $mail->addAddress($email, "$applicant_name, $applicant_lname");
        
        // Add BCC
        $mail->addBCC('mtfrblucban2024@gmail.com', 'MTFRB Lucban Office');
        
        $mail->isHTML(false);
        $mail->Subject = 'Interview Schedule Notification';
        $mail->Body    = $message;

        $mail->send();

        // Log success message
        $action = "Sent interview notification to applicant: $applicant_name(ID: $id)";
        $log_sql = "INSERT INTO logs_history (user_id, action, franchise_no, date_time, account_type, username) 
                    VALUES (?, ?, ?, ?, ?, ?)";
        if ($log_stmt = mysqli_prepare($conn, $log_sql)) {
            $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session
            $franchise_no = NULL; // Adjust as necessary
            $date_time = date('Y-m-d H:i:s');
            $account_type = $_SESSION['account_type']; // Assuming account_type is stored in session
            $username = $_SESSION['username']; // Assuming username is stored in session

            mysqli_stmt_bind_param($log_stmt, 'isssss', $user_id, $action, $franchise_no, $date_time, $account_type, $username);
            mysqli_stmt_execute($log_stmt);
            mysqli_stmt_close($log_stmt);
        }

        echo json_encode(['status' => 'success', 'message' => 'Email sent successfully']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
    } finally {
        $conn->close();
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID not provided or invalid request method.']);
}
