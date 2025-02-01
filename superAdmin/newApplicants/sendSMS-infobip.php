<?php
session_start();

header('Content-Type: application/json');

use Infobip\Configuration;
use Infobip\Api\SmsApi;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;
use Infobip\Model\SmsAdvancedTextualRequest;
use Twilio\Rest\Client;

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

        // Ensure phone number is in E.164 format for Infobip
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

    // Infobip API credentials
    $api_url = "https://api.infobip.com/sms/1/text/single";
    $api_key = "d0a4ed6213ea5a1c32e887f7265c7ba1-d7e2cd19-9138-4779-a5cf-43ed67c610fb";  // Replace with your Infobip API key

    // Prepare SMS data
    $sms_data = [
        'from' => 'MTFRB',  // Your sender ID (up to 11 characters, or use a valid phone number)
        'to' => $contact_num,
        'text' => $message,
    ];

    // Initialize cURL for Infobip API
    $ch = curl_init($api_url);  // Corrected variable name
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: App ' . $api_key,  // Corrected variable name
        'Content-Type: application/json',
        'Accept: application/json'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($sms_data));

    // Execute cURL request and collect response
    $response = curl_exec($ch);

    // Initialize results array
    $results = [];

    if (curl_errno($ch)) {
        $results[] = [
            'id' => $id,
            'status' => 'error',
            'message' => 'Failed to send SMS.',
            'curl_error' => curl_error($ch)
        ];
    } else {
        // Decode JSON response
        $responseData = json_decode($response, true);

        // Check for successful message ID in the response
        if ($responseData && isset($responseData['messages'][0]['messageId'])) {
            $results[] = [
                'id' => $id,
                'status' => 'success',
                'message' => 'SMS sent successfully',
                'messageId' => $responseData['messages'][0]['messageId']
            ];
        } else {
            // Provide detailed error response from Infobip
            $error_message = isset($responseData['requestError']['serviceException']['text']) ? $responseData['requestError']['serviceException']['text'] : 'Unknown error';
            $results[] = [
                'id' => $id,
                'status' => 'error',
                'message' => 'Failed to send SMS.',
                'infobip_error' => $error_message
            ];
        }
    }

    // Close cURL
    curl_close($ch);

    // Return the results as a JSON response
    echo json_encode($results);
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID not provided or invalid request method.']);
}
