<?php
session_start();
include "../include/db_conn.php";

// Fetch filter values from the request
$first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
$last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
$month = isset($_POST['month']) ? $_POST['month'] : '';
$id = isset($_POST['id']) ? $_POST['id'] : '';
$TFno = isset($_POST['TFno']) ? $_POST['TFno'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : '';
$tricType = isset($_POST['tricType']) ? $_POST['tricType'] : '';
$dayBan = isset($_POST['dayBan']) ? $_POST['dayBan'] : '';
$toda = isset($_POST['toda']) ? $_POST['toda'] : '';

// Pagination parameters
$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$pageSize = isset($_POST['pageSize']) ? intval($_POST['pageSize']) : 10;
$page = max(1, $page);
$pageSize = max(1, $pageSize);
$offset = ($page - 1) * $pageSize;

// Ensure pagination parameters are valid
$offset = max(0, $offset);

// Define the base filter conditions
$filterConditions = "drop_franchise IS NULL AND reason_drop IS NULL";

// Add filters dynamically
if (!empty($first_name)) {
    $filterConditions .= " AND first_name LIKE '%" . mysqli_real_escape_string($conn, $first_name) . "%'";
}
if (!empty($last_name)) {
    $filterConditions .= " AND last_name LIKE '%" . mysqli_real_escape_string($conn, $last_name) . "%'";
}
if (!empty($TFno)) {
    $filterConditions .= " AND TFno LIKE '%" . mysqli_real_escape_string($conn, $TFno) . "%'";
}
if (!empty($status)) {
    $filterConditions .= " AND `status` = '" . mysqli_real_escape_string($conn, $status) . "'";
}
if (!empty($tricType)) {
    $filterConditions .= " AND tricType = '" . mysqli_real_escape_string($conn, $tricType) . "'";
}
if (!empty($dayBan)) {
    $filterConditions .= " AND dayBan = '" . mysqli_real_escape_string($conn, $dayBan) . "'";
}
if (!empty($toda)) {
    $filterConditions .= " AND toda = '" . mysqli_real_escape_string($conn, $toda) . "'";
}

// Define the tables to check for expired records
$tables = ['jan_operators', 'feb_operators', 'march_operators', 'apr_operators', 'may_operators', 
           'jun_operators', 'jul_operators', 'aug_operators', 'sep_operators', 'oct_operators'];

$currentDate = date('Y-m-d');

// Loop through tables and update records where expDate is expired
foreach ($tables as $table) {
    $updateQuery = "
        UPDATE $table 
        SET status = 'Expired' 
        WHERE STR_TO_DATE(expDate, '%d/%m/%Y') < '$currentDate'
    ";
    $updateResult = mysqli_query($conn, $updateQuery);

    if (!$updateResult) {
        // Log errors for debugging purposes
        error_log("Error updating table $table: " . mysqli_error($conn));
    } else {
        // Log successful updates
        error_log("Successfully updated table $table.");
    }
}

if (!empty($month) && in_array($month, $tables)) {
    $tableName = mysqli_real_escape_string($conn, $month);
    $sql = "SELECT *, 
                   CASE 
                       WHEN STR_TO_DATE(expDate, '%d/%m/%Y') < '$currentDate' THEN 'Expired' 
                       ELSE status 
                   END AS status 
            FROM $tableName 
            WHERE $filterConditions";
    $countSql = "SELECT COUNT(*) as total FROM $tableName WHERE $filterConditions";
} else {
    $unionQueries = [];
    $countUnionQueries = [];
    foreach ($tables as $table) {
        $unionQueries[] = "SELECT *, 
                                  CASE 
                                      WHEN STR_TO_DATE(expDate, '%d/%m/%Y') < '$currentDate' THEN 'Expired' 
                                      ELSE status 
                                  END AS status 
                           FROM $table 
                           WHERE $filterConditions";
        $countUnionQueries[] = "SELECT COUNT(*) as total FROM $table WHERE $filterConditions";
    }
    $sql = implode(" UNION ALL ", $unionQueries);
    $countSql = "SELECT SUM(total) as total FROM (" . implode(" UNION ALL ", $countUnionQueries) . ") as combined_counts";
}

// For debugging
error_log("SQL Query: " . $sql);

// Count total records for pagination
$countResult = mysqli_query($conn, $countSql);
if (!$countResult) {
    die('Error counting records: ' . mysqli_error($conn));
}
$totalRow = mysqli_fetch_assoc($countResult);
$totalRecords = $totalRow['total'];

// Add LIMIT clause for pagination
$sql .= " LIMIT $offset, $pageSize";

// Execute the main query
$result = mysqli_query($conn, $sql);
if (!$result) {
    die('Error fetching data: ' . mysqli_error($conn));
}

// Fetch all rows
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Calculate total pages
$totalPages = ceil($totalRecords / $pageSize);

// Return the results as JSON
header('Content-Type: application/json');
echo json_encode([
    'rows' => $data,
    'totalPages' => $totalPages,
    'currentPage' => $page,
    'totalRecords' => $totalRecords
]);

mysqli_close($conn);
?>
