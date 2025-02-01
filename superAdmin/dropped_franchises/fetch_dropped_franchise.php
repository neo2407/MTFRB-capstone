<?php
session_start();
include "../include/db_conn.php";

// Fetch filter values from the request

$first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
$last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
$month = isset($_POST['month']) ? $_POST['month'] : '';
$id = isset($_POST['id']) ? $_POST['id'] : '';
$TFno = isset($_POST['TFno']) ? $_POST['TFno'] : '';
// Pagination parameters
$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$pageSize = isset($_POST['pageSize']) ? intval($_POST['pageSize']) : 10;
$offset = ($page - 1) * $pageSize;

// Ensure pagination parameters are valid
$page = max(1, $page);
$pageSize = max(1, $pageSize);
$offset = max(0, $offset);

// Define the base filter conditions
$filterConditions = "drop_franchise = 'Drop'";

if (!empty($first_name)) {
    $filterConditions .= " AND first_name LIKE '%" . mysqli_real_escape_string($conn, $first_name) . "%'";
}

if (!empty($last_name)) {
    $filterConditions .= " AND last_name LIKE '%" . mysqli_real_escape_string($conn, $last_name) . "%'";
}

if (!empty($TFno)) {
    $filterConditions .= " AND TFno LIKE '%" . mysqli_real_escape_string($conn, $TFno) . "%'";
}

// Define the SQL query
$tables = ['jan_operators', 'feb_operators', 'march_operators', 'apr_operators', 'may_operators', 'jun_operators', 'jul_operators', 'aug_operators', 'sep_operators', 'oct_operators'];

if (!empty($month) && in_array($month, $tables)) {
    // Use the selected month table if provided
    $tableName = mysqli_real_escape_string($conn, $month);
    $sql = "SELECT * FROM $tableName WHERE $filterConditions";
    $countSql = "SELECT COUNT(*) as total FROM $tableName WHERE $filterConditions";
} else {
    // Default to all months using UNION ALL
    $unionQueries = [];
    $countUnionQueries = [];
    foreach ($tables as $table) {
        $unionQueries[] = "SELECT * FROM $table WHERE $filterConditions";
        $countUnionQueries[] = "SELECT COUNT(*) as total FROM $table WHERE $filterConditions";
    }
    $sql = implode(" UNION ALL ", $unionQueries);
    $countSql = "SELECT SUM(total) as total FROM (" . implode(" UNION ALL ", $countUnionQueries) . ") as combined_counts";
}

// Log the SQL query for debugging purposes
error_log("SQL Query: " . $sql);

// Count total records for pagination based on the filtered query
$countResult = mysqli_query($conn, $countSql);
if (!$countResult) {
    die('Error counting records: ' . mysqli_error($conn));
}
$totalRow = mysqli_fetch_assoc($countResult);
$totalRecords = $totalRow['total'];

// Append limit and offset for pagination to the main query
$sql .= " LIMIT $offset, $pageSize";

// Execute the main query
$result = mysqli_query($conn, $sql);
if (!$result) {
    die('Error fetching data: ' . mysqli_error($conn));
}

// Fetch the data
$rows = [];
while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
}

// Prepare the JSON response
$response = [
    'rows' => $rows,
    'totalPages' => ceil($totalRecords / $pageSize),
    'currentPage' => $page
];

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($response);

mysqli_close($conn);
?>
