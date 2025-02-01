<?php
session_start();    

header('Content-Type: application/json');

// Check if the ID is provided via POST
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
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No applicant found.']);
        $stmt->close();
        $conn->close();
        exit;
    }
    
    $stmt->close();
    $conn->close();

    // Compose SMS message
   $message = "Magandang Araw, $applicant_name! Naaprubahan ang inyong aplikasyon para sa prangkisa ng traysikel. Mangyaring magtungo sa MTFRB Lucban Office sa ganap na $interview_schedule para sa iyong interbyu.Salamat po.";  
    // Semaphore API settings
    $apiKey = "613064d06f3ca2eb22645ca581299fcc";  
    $url = "https://api.semaphore.co/api/v4/messages";

    // Data to send with the POST request
    $data = [
        "apikey" => $apiKey,
        "number" => $contact_num,
        "message" => $message,
        "sendername" => 'MTFRBLucban'
    ];

    // Initialize cURL
    $ch = curl_init($url);

    // Set cURL options
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    // Execute cURL request
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to send SMS in curl.', 'curl_error' => curl_error($ch)]);
    } else {
        $responseData = json_decode($response, true);

        // Check if the SMS was sent successfully
        if (isset($responseData['status']) && $responseData['status'] === "queued") {
            echo json_encode(['status' => 'success', 'message' => 'SMS sent successfully']);
        } else {
            // Log entire response for debugging
            echo json_encode(['status' => 'error', 'message' => 'Failed to send SMS.', 'response' => $responseData]);
        }
    }

    // Close cURL
    curl_close($ch);
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID not provided or invalid request method.']);
}
?>
