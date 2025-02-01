<?php
include "../../include/db_conn.php";

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Fetch filter values from the request
$firstName = isset($_GET['first_name']) ? $_GET['first_name'] : '';
$lastName = isset($_GET['last_name']) ? $_GET['last_name'] : '';
$status = isset($_GET['applicantStatus']) ? $_GET['applicantStatus'] : '';
$type = isset($_GET['tricType']) ? $_GET['tricType'] : '';

// Pagination parameters
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$pageSize = isset($_GET['pageSize']) ? intval($_GET['pageSize']) : 10;
$offset = ($page - 1) * $pageSize;

// Ensure pagination parameters are valid
$page = max(1, $page); // Ensure page is at least 1
$pageSize = max(1, $pageSize); // Ensure pageSize is at least 1
$offset = max(0, $offset); // Ensure offset is not negative

// Base SQL query
$sql = "SELECT * FROM applicants 
WHERE ((applicantStatus = 'Pending' OR applicantStatus = 'Denied') 
AND new_acc = 0) AND 1=1";
$countSql = "SELECT COUNT(*) as total FROM applicants WHERE ((applicantStatus = 'Pending' OR applicantStatus = 'Denied') 
AND new_acc = 0) AND 1=1";

// Add conditions based on filters
if (!empty($firstName)) {
    $sql .= " AND first_name LIKE '%" . mysqli_real_escape_string($conn, $firstName) . "%'";
    $countSql .= " AND first_name LIKE '%" . mysqli_real_escape_string($conn, $firstName) . "%'";
}

if (!empty($lastName)) {
    $sql .= " AND last_name LIKE '%" . mysqli_real_escape_string($conn, $lastName) . "%'";
    $countSql .= " AND last_name LIKE '%" . mysqli_real_escape_string($conn, $lastName) . "%'";
}

if (!empty($status)) {
    $sql .= " AND applicantStatus = '" . mysqli_real_escape_string($conn, $status) . "'";
    $countSql .= " AND applicantStatus = '" . mysqli_real_escape_string($conn, $status) . "'";
}

if (!empty($type)) {
    $sql .= " AND tricType = '" . mysqli_real_escape_string($conn, $type) . "'";
    $countSql .= " AND tricType = '" . mysqli_real_escape_string($conn, $type) . "'";
}
// Count total records for pagination based on the filtered query
$countResult = mysqli_query($conn, $countSql);
if (!$countResult) {
    die('Error counting records: ' . mysqli_error($conn));
}
$totalRow = mysqli_fetch_assoc($countResult);
$totalRecords = $totalRow['total'];

$sql .= " ORDER BY applicationDate DESC";
$sql .= " LIMIT $offset, $pageSize";

// Execute the main query
$result = mysqli_query($conn, $sql);
if (!$result) {
    die('Error executing query: ' . mysqli_error($conn));
}

$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Calculate total pages
$totalPages = ceil($totalRecords / $pageSize);

// Return the results as JSON
header('Content-Type: application/json');
echo json_encode([
    'rows' => $data,
    'totalPages' => $totalPages,
    'currentPage' => $page 
]);

mysqli_close($conn);
?>