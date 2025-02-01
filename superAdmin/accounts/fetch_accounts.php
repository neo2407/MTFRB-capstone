<?php
include "../include/db_conn.php";

// Fetch filter values from the request
$f_name = isset($_GET['f_name']) ? $_GET['f_name'] : '';
$l_name = isset($_GET['l_name']) ? $_GET['l_name'] : '';
$username = isset($_GET['username']) ? $_GET['username'] : '';
$acc_type = isset($_GET['acc_type']) ? $_GET['acc_type'] : '';  
$job_position = isset($_GET['job_position']) ? $_GET['job_position'] : '';

// Pagination parameters
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$pageSize = isset($_GET['pageSize']) ? intval($_GET['pageSize']) : 10;
$offset = ($page - 1) * $pageSize;

// Ensure pagination parameters are valid
$page = max(1, $page); // Ensure page is at least 1
$pageSize = max(1, $pageSize); // Ensure pageSize is at least 1
$offset = max(0, $offset); // Ensure offset is not negative

// Base SQL query
$sql = "SELECT * FROM accounts WHERE 1=1";

// Add conditions based on filters
if (!empty($f_name)) {
    $sql .= " AND f_name LIKE '%" . mysqli_real_escape_string($conn, $f_name) . "%'";
}

if (!empty($l_name)) {
    $sql .= " AND l_name LIKE '%" . mysqli_real_escape_string($conn, $l_name) . "%'";
}

if (!empty($username)) {
    $sql .= " AND username LIKE '%" . mysqli_real_escape_string($conn, $username) . "'";
}

if (!empty($account_type)) {
    $sql .= " AND account_type = '" . mysqli_real_escape_string($conn, $account_type) . "'";
}

if (!empty($job_position)) {
    $sql .= " AND job_position = '" . mysqli_real_escape_string($conn, $job_position) . "'";
}

// Count total records for pagination
$countSql = "SELECT COUNT(*) as total FROM accounts WHERE 1=1";

// Add the same conditions for counting
if (!empty($f_name)) {
    $countSql .= " AND f_name LIKE '%" . mysqli_real_escape_string($conn, $f_name) . "%'";
}

if (!empty($l_name)) {
    $countSql .= " AND l_name LIKE '%" . mysqli_real_escape_string($conn, $l_name) . "%'";
}

if (!empty($username)) {
    $countSql .= " AND username LIKE '%" . mysqli_real_escape_string($conn, $username) . "'";
}


if (!empty($acc_type)) {
    $sql .= " AND account_type = '" . mysqli_real_escape_string($conn, $acc_type) . "'";
}

if (!empty($job_position)) {
    $countSql .= " AND job_position = '" . mysqli_real_escape_string($conn, $job_position) . "'";
}

// Execute the count query
$countResult = mysqli_query($conn, $countSql);
if (!$countResult) {
    die('Error counting records: ' . mysqli_error($conn));
}
$totalRow = mysqli_fetch_assoc($countResult);
$totalRecords = $totalRow['total'];

// Append limit and offset for pagination
$sql .= " LIMIT $offset, $pageSize";

// Execute the main query
$result = mysqli_query($conn, $sql);
if (!$result) {
    die('Error executing query: ' . mysqli_error($conn));
}

// Fetch all results
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Encode the IDs
foreach ($data as &$row) {
    $row['id'] = base64_encode($row['id']);
}

// Calculate total pages
$totalPages = ceil($totalRecords / $pageSize);

// Return the results as JSON
header('Content-Type: application/json');
echo json_encode([
    'rows' => $data,
    'totalPages' => $totalPages,
    'currentPage' => $page // Including the current page for reference
]);

mysqli_close($conn);
