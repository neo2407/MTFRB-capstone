<?php
session_start();
header('Content-Type: application/json');

require '../../vendor/autoload.php';
include "../../include/db_conn.php";

// Check if month was received
$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['month'])) {
    echo json_encode(['status' => 'error', 'message' => 'Month not provided.']);
    exit();
}

$month_table = $data['month'];  // e.g., 'jan_operators', 'feb_operators'

// Twilio API credentials
$account_sid = "ACdb104c23fa2c140dbbf8822ff3bac332";
$auth_token = "509d6748763c5bb2c08daa23e69e6b29";
$twilio_number = "+18638374498";

$results = [];

// Fetch all operators from the selected month table
$stmt = $conn->prepare("SELECT id, first_name, expDate, contact_num FROM $month_table");
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $operator_name = $row['first_name'];
    $expDate = $row['expDate'];
    $contact_num = preg_replace('/^0/', '+63', $row['contact_num']);  // Format phone number

    // Compose SMS message
    $message = "Hello $operator_name. We want to inform you that your current franchise is set to expire on $expDate and you must renew it before expiration date.";

    // Initialize cURL for each message
    $ch = curl_init("https://api.twilio.com/2010-04-01/Accounts/$account_sid/Messages.json");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, "$account_sid:$auth_token");
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        "From" => $twilio_number,
        "To" => $contact_num,
        "Body" => $message
    ]));

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
        $responseData = json_decode($response, true);

        if (isset($responseData['sid'])) {
            $results[] = [
                'id' => $id,
                'status' => 'success',
                'message' => 'SMS sent successfully',
                'sid' => $responseData['sid']
            ];
        } else {
            $error_message = isset($responseData['message']) ? $responseData['message'] : 'Unknown error';
            $results[] = [
                'id' => $id,
                'status' => 'error',
                'message' => 'Failed to send SMS.',
                'twilio_error' => $error_message
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

