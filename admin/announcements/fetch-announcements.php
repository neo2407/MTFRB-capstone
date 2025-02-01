<?php
include "../include/db_conn.php";

$sql = "SELECT * FROM announcements ORDER BY inserted_at DESC";

$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

echo json_encode($data);
?>