<?php
session_start();
include "../include/db_conn.php";

// Get data from POST request
$id = $_POST['id'];
$complaints = $_POST['complaints'];

// Identify the correct table
$tables = [
    "jan_operators", "feb_operators", "march_operators", "apr_operators", 
    "may_operators", "jun_operators", "jul_operators", 
    "aug_operators", "sep_operators", "oct_operators"
];

$table_to_update = null;

foreach ($tables as $table) {
    // Check if the operator exists in the current table
    $sql = "SELECT complaints FROM $table WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $table_to_update = $table;
        $stmt->bind_result($existing_complaints);
        $stmt->fetch();
        break;
    }

    $stmt->close();
}

if ($table_to_update) {
    if (!empty($existing_complaints)) {
        // Decode existing complaints and merge with new complaints
        $existing_complaints_array = json_decode($existing_complaints, true);
        $new_complaints_array = json_decode($complaints, true);
        $merged_complaints = array_merge($existing_complaints_array, $new_complaints_array);
        $complaints = json_encode($merged_complaints);
    }

    // Update complaints in the correct table
    $sql = "UPDATE $table_to_update SET complaints = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $complaints, $id);

    if ($stmt->execute()) {
        $_SESSION['status'] = "Complaint History Added Successfully";
        $_SESSION['status_code'] = "success";
        header("Location: edit_operatorDash.php?id=$id");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Operator not found.";
}

$conn->close();
?>
