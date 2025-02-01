<?php
session_start();
include '../include/db_conn.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_GET['ticketNo'])) {
    $user_id = $_SESSION['user_id'];
    $account_type = $_SESSION['account_type'];
    $username = $_SESSION['username'];
    $date_time = date('Y-m-d H:i:s');

    // Retrieve ticketNo from POST or GET
    $ticketNo = isset($_POST['ticketNo']) ? $_POST['ticketNo'] : (isset($_GET['ticketNo']) ? $_GET['ticketNo'] : null);

    if (!$ticketNo) {
        echo json_encode(['success' => false, 'error' => 'Ticket No is missing.']);
        exit;
    }

    $action = "Receipt generated for ticket no: $ticketNo.";
    $franchise_no = isset($_SESSION['franchise_no']) ? $_SESSION['franchise_no'] : null;

    $logQuery = "INSERT INTO logs_history (user_id, action, franchise_no, date_time, account_type, username) VALUES (?, ?, ?, ?, ?, ?)";
    if ($logStmt = $conn->prepare($logQuery)) {
        $logStmt->bind_param("isssss", $user_id, $action, $franchise_no, $date_time, $account_type, $username);
        if ($logStmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
        $logStmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}
?>
