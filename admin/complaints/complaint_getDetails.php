<?php

include "../../include/db_conn.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM `complaints` WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'No details found for the given ID.']);
    }
} else {
    echo json_encode(['error' => 'No ID provided.']);
}
?>