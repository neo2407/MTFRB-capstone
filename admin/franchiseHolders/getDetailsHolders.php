<?php

include "../include/db_conn.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM `janoperators` WHERE id = $id UNION SELECT * FROM `feboperators` WHERE id = $id UNION SELECT * FROM `marchoperators` WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        // Decode yung tricycle pics links
        if (isset($row['tricyclePics']) && !is_null($row['tricyclePics'])) {
            $row['tricyclePics'] = json_decode(stripslashes($row['tricyclePics']), true); //inaalis yung slashes na-naka store sa db para maacess yung pic
        }
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'No details found for the given ID.']);
    }
} else {
    echo json_encode(['error' => 'No ID provided.']);
}
?>
