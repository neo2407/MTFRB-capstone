<?php
// Include database connection
include "../../include/db_conn.php";

// Prepare the SQL query to fetch interview data
$sql = "SELECT id, interview_dt, interviewStatus FROM complaints";
$result = $conn->query($sql);

// Initialize an array to hold the data
$data = [];

if ($result->num_rows > 0) {
    // Loop through the results and store each row in the $data array
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            "id" => $row["id"],
            "interview_dt" => $row["interview_dt"],
            "interviewStatus" => $row["interviewStatus"]
        ];
    }
    // Return the data as JSON
    echo json_encode($data);
} else {
    // If no records are found, return an empty array
    echo json_encode([]);
}

// Close the database connection
$conn->close();
?>
