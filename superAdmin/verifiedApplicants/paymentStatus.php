<?php
include "../../include/db_conn.php";

if (isset($_POST['id']) && isset($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Check if order of payment is generated
    $checkSql = "SELECT order_payment_Image FROM applicants WHERE id = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param('i', $id);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        $row = $checkResult->fetch_assoc();
        if (!empty($row['order_payment_Image'])) {
            // Proceed with updating payment status
            $sql = "UPDATE applicants SET paymentStatus = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('si', $status, $id);

            if ($stmt->execute()) {
                // Log the action
                session_start();
                $user_id = $_SESSION['user_id'];
                $account_type = $_SESSION['account_type'];
                $username = $_SESSION['username'];
                $date_time = date('Y-m-d H:i:s');
                $action = "Payment status updated to '$status' for applicant ID $id.";
                $franchise_no = isset($_SESSION['franchise_no']) ? $_SESSION['franchise_no'] : null;

                $logQuery = "INSERT INTO logs_history (user_id, action, franchise_no, date_time, account_type, username) VALUES (?, ?, ?, ?, ?, ?)";
                $logStmt = $conn->prepare($logQuery);
                $logStmt->bind_param("isssss", $user_id, $action, $franchise_no, $date_time, $account_type, $username);

                if ($logStmt->execute()) {
                    echo json_encode(['success' => true, 'message' => 'Status updated and action logged successfully.']);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Status updated but failed to log the action: ' . $logStmt->error]);
                }

                $logStmt->close();
            } else {
                echo json_encode(['success' => false, 'error' => 'Failed to update status: ' . $stmt->error]);
            }

            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'error' => 'Order of payment not generated.']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Applicant not found.']);
    }

    $checkStmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request.']);
}

$conn->close();
?>
