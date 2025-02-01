<?php
// Include database connection
include "../../include/db_conn.php";

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set content type to JSON
header('Content-Type: application/json');

// Check if TFno is set and not empty
if (isset($_POST['TFno']) && !empty($_POST['TFno'])) {
    $TFno = $_POST['TFno'];

    // Extract the last digit of the TFno to determine the month
    $lastDigit = $TFno % 10;

    // Mapping last digit to table names
    $tableMap = [
        1 => 'jan_operators',
        2 => 'feb_operators',
        3 => 'march_operators',
        4 => 'apr_operators',
        5 => 'may_operators',
        6 => 'jun_operators',
        7 => 'jul_operators',
        8 => 'aug_operators',
        9 => 'sep_operators',
        0 => 'oct_operators'
    ];

    // Determine the table based on the last digit
    if (array_key_exists($lastDigit, $tableMap)) {
        $table = $tableMap[$lastDigit];
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid month derived from TFno"]);
        exit;
    }

    // Start transaction
    $conn->begin_transaction();

    try {
        // Copy data from the source table to operatorHistory
        $copySQL = "INSERT INTO operatorHistory 
                    SELECT * FROM $table WHERE TFno = ?";
        if ($stmt = $conn->prepare($copySQL)) {
            $stmt->bind_param("i", $TFno);
            $stmt->execute();
            $stmt->close();
        } else {
            throw new Exception("Error preparing copy statement: " . $conn->error);
        }

        // Delete data from the source table
        $deleteSQL = "DELETE FROM $table WHERE TFno = ?";
        if ($stmt = $conn->prepare($deleteSQL)) {
            $stmt->bind_param("i", $TFno);
            $stmt->execute();
            $stmt->close();
        } else {
            throw new Exception("Error preparing delete statement: " . $conn->error);
        }

        // Delete data from the violations table
        $deleteViolationsSQL = "DELETE FROM violations WHERE TFno = ?";
        if ($stmt = $conn->prepare($deleteViolationsSQL)) {
            $stmt->bind_param("i", $TFno);
            $stmt->execute();
            $stmt->close();
        } else {
            throw new Exception("Error preparing delete statement for violations: " . $conn->error);
        }

        // Commit transaction
        $conn->commit();
        echo json_encode(["status" => "success", "message" => "Record moved to operatorHistory, deleted from $table and violations"]);
    } catch (Exception $e) {
        // Rollback transaction in case of error
        $conn->rollback();
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }

    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request: TFno not set or empty"]);
}
?>
