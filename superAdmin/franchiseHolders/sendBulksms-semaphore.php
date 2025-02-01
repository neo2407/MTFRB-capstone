<?php
session_start();
include "../include/db_conn.php";

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Function to determine the network based on the contact number
function getNetwork($contactNum) {
    // Define prefixes for each network
    // (Keep the same code as before)
}

// Get input from the frontend
$data = json_decode(file_get_contents('php://input'), true);
$table = $data['table'];

// Validate the table name
$allowedTables = [
    'jan_operators',
    'feb_operators',
    'march_operators',
    'apr_operators',
    'may_operators',
    'jun_operators',
    'jul_operators',
    'aug_operators',
    'sep_operators',
    'oct_operators'
];

if (!in_array($table, $allowedTables)) {
    echo json_encode(['success' => false, 'message' => 'Invalid table selected.']);
    exit;
}

// Map table names to months
$tableToMonth = [
    'jan_operators' => 'January',
    'feb_operators' => 'February',
    'march_operators' => 'March',
    'apr_operators' => 'April',
    'may_operators' => 'May',
    'jun_operators' => 'June',
    'jul_operators' => 'July',
    'aug_operators' => 'August',
    'sep_operators' => 'September',
    'oct_operators' => 'October'
];

// Get the selected month
$selectedMonth = $tableToMonth[$table];

// Fetch all contact numbers
$query = "SELECT first_name, expDate, contact_num FROM $table";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $groupedNumbers = [
        'smart' => [],
        'globe' => [],
        'dito' => [],
        'sun' => [],
        'other' => []
    ];

    while ($row = $result->fetch_assoc()) {
        $contactNum = preg_replace('/^0/', '+63', $row['contact_num']);
        $network = getNetwork($contactNum);

        $groupedNumbers[$network][] = [
            'first_name' => $row['first_name'],
            'expDate' => $row['expDate'],
            'contact_num' => $contactNum
        ];
    }

    $allMessagesSent = true;
    $failureMessages = [];

    foreach ($groupedNumbers as $network => $numbers) {
        if (count($numbers) > 0) {
            $sent = sendSmsBatch($numbers, $network);
            if (!$sent) {
                $failureMessages[] = "Failed to send SMS to $network recipients.";
                $allMessagesSent = false;
            }
        }
    }

    // Log the action
    $user_id = $_SESSION['user_id'];
    $account_type = $_SESSION['account_type'];
    $username = $_SESSION['username'];
    $date_time = date('Y-m-d H:i:s');
    $action = "Franchise Renewal reminder was sent to all operators for $selectedMonth.";
    $franchise_no = isset($_SESSION['franchise_no']) ? $_SESSION['franchise_no'] : null;

    $logQuery = "INSERT INTO logs_history (user_id, action, franchise_no, date_time, account_type, username) VALUES (?, ?, ?, ?, ?, ?)";
    if ($logStmt = $conn->prepare($logQuery)) {
        $logStmt->bind_param("isssss", $user_id, $action, $franchise_no, $date_time, $account_type, $username);
        $logStmt->execute();
        $logStmt->close();
    }

    if ($allMessagesSent) {
        echo json_encode(['success' => true, 'message' => 'SMS sent successfully to all operators.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Some SMS failed to send. ' . implode(' ', $failureMessages)]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No operators found in the selected table.']);
}

$conn->close();


// Function to send SMS to a batch of numbers
function sendSmsBatch($numbers, $network) {
    $apiKey = '613064d06f3ca2eb22645ca581299fcc'; // Replace with your actual API key
    $url = "https://semaphore.co/api/v4/messages";
    $sentAll = true;

    foreach ($numbers as $recipient) {
        $operatorName = $recipient['first_name'];
        $expDate = $recipient['expDate'];
        $message = "Hello $operatorName. We want to inform you that your current tricycle franchise is set to expire on $expDate. Please visit MTFRB Lucban office and renew it before the expiration date. Thank you!";
        
        $fields = [
            'apikey' => $apiKey,
            'number' => $recipient['contact_num'],
            'message' => $message,
            'sendername' => 'MTFRBLucban' 
        ];

        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the request
        $response = curl_exec($ch);
        curl_close($ch);

        // Decode the response
        $responseData = json_decode($response, true);

        if (isset($responseData['status']) && $responseData['status'] !== 'success') {
            $sentAll = false;
            file_put_contents('semaphore_response.log', "Failed to send SMS to {$recipient['contact_num']} on network $network. Response: " . json_encode($responseData) . PHP_EOL, FILE_APPEND);
        }
    }

    return $sentAll;
}
?>
