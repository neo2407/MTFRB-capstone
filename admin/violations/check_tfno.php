<?php
include "../../include/db_conn.php";

// Check if TFno is provided
if (isset($_POST['TFno'])) {
    $TFno = mysqli_real_escape_string($conn, $_POST['TFno']);

    // Log the TFno received
    error_log("TFno received: " . $TFno);  // This will log in PHP error log

    // Validate the format of TFno
    if (!preg_match('/^\d+[0-9]$/', $TFno)) {
        echo json_encode(["exists" => false, "error" => "Invalid TFno format."]);
        exit();
    }

    // Extract the last digit to determine the month (0 for October)
    $month = intval(substr($TFno, -1));

    // Map month to corresponding table
    $monthTables = [
        1 => "jan_operators",
        2 => "feb_operators",
        3 => "march_operators",
        4 => "apr_operators",
        5 => "may_operators",
        6 => "jun_operators",
        7 => "jul_operators",
        8 => "aug_operators",
        9 => "sep_operators",
        0 => "oct_operators" // 0 maps to October
    ];

    // Validate if the suffix corresponds to a valid table
    if (!isset($monthTables[$month])) {
        echo json_encode(["exists" => false, "error" => "Invalid month suffix in TFno."]);
        exit();
    }

    // Select the appropriate table based on the suffix
    $table = $monthTables[$month];

    // Check if the corresponding TFno exists as the `id` in the determined table
    $query = "SELECT `first_name`, `last_name` FROM `$table` WHERE `TFno` = '$TFno' LIMIT 1";
    $result = mysqli_query($conn, $query);

    // Return appropriate response based on result
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $operatorName = $row['first_name'] . ' ' . $row['last_name']; // Concatenate first and last names
        echo json_encode([
            "exists" => true,
            "operator_name" => $operatorName, // Send full operator name
            "error" => null
        ]);
    } else {
        echo json_encode(["exists" => false, "error" => "Tricycle Franchise No. does not exist."]);
    }

    exit();
}

echo json_encode(["exists" => false, "error" => "Invalid request."]);
?>
