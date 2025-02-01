<?php
include "../../include/db_conn.php";   

// Get raw POST data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Get the selected applicant IDs from the POST data
$selected_applicants = isset($data['selected_applicants']) ? $data['selected_applicants'] : [];

if (!empty($selected_applicants)) {
    $invalid_applicants = [];
    $debug_info = []; // Array to store debug information

    // Log the received IDs for debugging
    error_log("Received IDs: " . implode(', ', $selected_applicants));

    foreach ($selected_applicants as $id) {
        // Query to check interviewStatus and paymentStatus
        $sql = "SELECT interviewStatus, paymentStatus FROM applicants WHERE id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Database error: Failed to prepare the statement.',
                'debug' => $conn->error
            ]);
            exit;
        }

        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Log the fetched data for debugging
            error_log("Applicant ID: $id - InterviewStatus: {$row['interviewStatus']}, PaymentStatus: {$row['paymentStatus']}");

            // Add fetched data to debug info
            $debug_info[] = "ID: $id, Interview: {$row['interviewStatus']}, Payment: {$row['paymentStatus']}";

            // Check if interviewStatus is not 'Done' or paymentStatus is not 'Paid'
            if ($row['interviewStatus'] !== 'Done' || $row['paymentStatus'] !== 'Paid') {
                $invalid_applicants[] = $id;
            }
        } else {
            $invalid_applicants[] = $id; // If no record found, treat it as invalid
            $debug_info[] = "ID: $id, Record not found or no interview/payment status available.";
        }
    }

    if (!empty($invalid_applicants)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'All selected applicants must have their interview status as "Done" and payment status as "Paid" before granting a franchise.',
            'debug' => $debug_info // Include debug info in response
        ]);
    } else {
        echo json_encode(['status' => 'success', 'debug' => $debug_info]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No applicants selected.']);
}

// Close connection
$conn->close();
?>
