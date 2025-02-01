<?php
include "../../include/db_conn.php";

$id = $_POST['id'];

// Mark the notification as seen
$sql = "UPDATE notifications SET seen = 1 WHERE id = '$id'";
if (mysqli_query($conn, $sql)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to mark notification as seen']);
}
?>
