<?php
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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['reason_dismissal'])) {
    $id = $_POST['id'];
    $dismissalReason = $_POST['reason_dismissal'];

    include "../../include/db_conn.php";

    // Log query parameters
    error_log("Complaint ID: $id, Dismissal Reason: $dismissalReason");

    $stmt = $conn->prepare("SELECT first_name, last_name, email FROM complaints WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $complainantName = $row['first_name'] . ' ' . $row['last_name'];
        $email = $row['email'];
    } else {
        // Log no applicant found and return error
        error_log("No complaint found for ID: $id");
        echo json_encode(['status' => 'error', 'message' => 'No complaint found.']);
        $stmt->close();
        $conn->close();
        exit;
    }

    $stmt->close();
    $conn->close();

    $message = "Dear $complainantName,\n\nWe regret to inform you that the complaint you filed  has been dismissed.\n\nReason for dismissal of complaint: $dismissalReason\n\nThank you for your understanding.";

    $mail = new PHPMailer(true);

    try {
        // Enable SMTP debugging for detailed log output
        $mail->SMTPDebug = 2;  // Set to 2 for detailed SMTP logs
        $mail->Debugoutput = function ($str, $level) {
            // Log PHPMailer debug output to a file
            file_put_contents('phpmailer_debug.log', date('Y-m-d H:i:s') . " [{$level}] {$str}\n", FILE_APPEND);
        };

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'mtfrblucban2024@gmail.com'; // Use correct email
        $mail->Password   = 'uway leyk zkah dcda';  // Use correct app password
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

        $mail->setFrom('mtfrblucban2024@gmail.com', 'MTFRB Lucban Office');
        $mail->addAddress($email, $complainantName);

        $mail->isHTML(false);
        $mail->Subject = 'Complaint Status Notification';
        $mail->Body    = $message;

        $mail->send();
        
        // Log success message
        error_log("Email successfully sent to $email");

        echo json_encode(['status' => 'success', 'message' => 'Email sent successfully']);
    } catch (Exception $e) {
        // Log any PHPMailer error
        error_log("Mailer Error: {$mail->ErrorInfo}");
        echo json_encode(['status' => 'error', 'message' => "Mailer Error: {$mail->ErrorInfo}"]);
    }
} else {
    // Log invalid request
    error_log("Invalid request: ID or dismissal reason not provided");
    echo json_encode(['status' => 'error', 'message' => 'ID or dismissal reason not provided or invalid request method.']);
}
?>
