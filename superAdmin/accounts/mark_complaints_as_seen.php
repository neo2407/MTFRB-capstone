<?php
include "../../include/db_conn.php";

$id = $_POST['id'];

// Mark the application as seen
$sql = "UPDATE complaints SET is_new = 0 WHERE id = '$id'";
if (mysqli_query($conn, $sql)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to mark complaints as seen']);
}
?>