<?php
session_start();

header('Content-Type: application/json');

require '../../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    include "../../include/db_conn.php";

    // Fetch applicant details
    $stmt = $conn->prepare("SELECT first_name, last_name, interview_sched, contact_num FROM applicants WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $applicant_name = $row['first_name'];
        $applicant_lname = $row['last_name'];
        $interview_schedule = $row['interview_sched'];
        $contact_num = $row['contact_num'];

        // Ensure phone number is in E.164 format for Twilio
        $contact_num = preg_replace('/^0/', '+63', $contact_num);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No applicant found.']);
        $stmt->close();
        $conn->close();
        exit;
    }

    $stmt->close();
    $conn->close();

    // Compose SMS message
    $message = "Hello $applicant_name. Your interview schedule for your franchise application is on $interview_schedule at MTFRB Lucban Office.";

    // Twilio API credentials
    $account_sid = "ACdb104c23fa2c140dbbf8822ff3bac332";
    $auth_token = "509d6748763c5bb2c08daa23e69e6b29";
    $twilio_number = "+18638374498";

    // Initialize cURL
    $ch = curl_init("https://api.twilio.com/2010-04-01/Accounts/$account_sid/Messages.json");

    // Set cURL options
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, "$account_sid:$auth_token");
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        "From" => $twilio_number,
        "To" => $contact_num,
        "Body" => $message
    ]));

    // Execute cURL request
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to send SMS.', 'curl_error' => curl_error($ch)]);
    } else {
        $responseData = json_decode($response, true);

        // Check if the SMS was sent successfully
        if (isset($responseData['sid'])) {
            echo json_encode(['status' => 'success', 'message' => 'SMS sent successfully']);
        } else {
            // Provide detailed error response from Twilio
            $error_message = isset($responseData['message']) ? $responseData['message'] : 'Unknown error';
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to send SMS.',
                'twilio_error' => $error_message,
                'response' => $responseData
            ]);
        }
    }

    // Close cURL
    curl_close($ch);
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID not provided or invalid request method.']);
}
