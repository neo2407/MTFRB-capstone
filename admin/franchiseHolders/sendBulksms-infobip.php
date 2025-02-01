<?php
session_start();
header('Content-Type: application/json');

use Infobip\Configuration;
use Infobip\Api\SmsApi;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;
use Infobip\Model\SmsAdvancedTextualRequest;
use Twilio\Rest\Client;

require __DIR__ . "/../../vendor/autoload.php";
include "../../include/db_conn.php";

// Check if month was received
$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['month'])) {
    echo json_encode(['status' => 'error', 'message' => 'Month not provided.']);
    exit();
}

$month_table = $data['month'];

// Infobip API credentials
$apiKey = 'd0a4ed6213ea5a1c32e887f7265c7ba1-d7e2cd19-9138-4779-a5cf-43ed67c610fb'; // Replace with your actual Infobip API key
$baseUrl = 'https://d959dl.api.infobip.com'; // Ensure 'https://' is included

$results = [];

try {
    // Prepare and execute the SQL query
    $stmt = $conn->prepare("SELECT id, first_name, expDate, contact_num FROM $month_table");
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $operator_name = $row['first_name'];
        $expDate = $row['expDate'];
        $contact_num = preg_replace('/^0/', '+63', $row['contact_num']);  // Format phone number

        // Compose SMS message
        $message = "Hello $operator_name. We want to inform you that your current franchise is set to expire on $expDate. Please renew it before the expiration date.";

        // Infobip SMS endpoint URL
        $url = "$baseUrl/sms/2/text/advanced";

        // Prepare the Infobip payload
        $payload = [
            "messages" => [
                [
                    "from" => "MTFRB", // Replace with your desired sender ID
                    "destinations" => [
                        ["to" => $contact_num]
                    ],
                    "text" => $message
                ]
            ]
        ];

        // Initialize cURL for Infobip API
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: App ' . $apiKey,
            'Content-Type: application/json',
            'Accept: application/json'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

        // Execute cURL request and collect response
        $response = curl_exec($ch);

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
    }

    // Close the database connection
    $conn->close();

    // Output results for each ID
    echo json_encode(['results' => $results, 'success' => true]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'An exception occurred: ' . $e->getMessage()]);
}
