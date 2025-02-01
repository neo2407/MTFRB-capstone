<?php
include "../../include/db_conn.php";

// Fetch filter values from the request
$ticketNo = isset($_GET['ticketNo']) ? $_GET['ticketNo'] : '';
$TFno = isset($_GET['TFno']) ? $_GET['TFno'] : '';
$violationType = isset($_GET['violationType']) ? $_GET['violationType'] : '';
$offenseType = isset($_GET['offenseType']) ? $_GET['offenseType'] : '';
$penaltyStatus = isset($_GET['penaltyStatus']) ? $_GET['penaltyStatus'] : '';

// Pagination parameters
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$pageSize = isset($_GET['pageSize']) ? intval($_GET['pageSize']) : 10;
$offset = ($page - 1) * $pageSize;

// Ensure pagination parameters are valid
$page = max(1, $page); // Ensure page is at least 1
$pageSize = max(1, $pageSize); // Ensure pageSize is at least 1
$offset = max(0, $offset); // Ensure offset is not negative

// Base SQL query with WHERE 1=1
$sql = "SELECT * FROM violations WHERE 1=1";
$countSql = "SELECT COUNT(*) as total FROM violations WHERE 1=1"; // Counting query

// Add conditions based on filters
if (!empty($ticketNo)) {
    $sql .= " AND ticketNo LIKE '%" . mysqli_real_escape_string($conn, $ticketNo) . "%'";
    $countSql .= " AND ticketNo LIKE '%" . mysqli_real_escape_string($conn, $ticketNo) . "%'";
}

if (!empty($TFno)) {
    $sql .= " AND TFno LIKE '%" . mysqli_real_escape_string($conn, $TFno) . "'";
    $countSql .= " AND TFno LIKE '%" . mysqli_real_escape_string($conn, $TFno) . "'";
}

if (!empty($violationType)) {
    $sql .= " AND violationType LIKE '%" . mysqli_real_escape_string($conn, $violationType) . "'";
    $countSql .= " AND violationType LIKE '%" . mysqli_real_escape_string($conn, $violationType) . "'";
}

if (!empty($offenseType)) {
    $sql .= " AND offenseType = '" . mysqli_real_escape_string($conn, $offenseType) . "'";
    $countSql .= " AND offenseType = '" . mysqli_real_escape_string($conn, $offenseType) . "'";
}

if (!empty($penaltyStatus)) {
    $sql .= " AND penaltyStatus = '" . mysqli_real_escape_string($conn, $penaltyStatus) . "'";
    $countSql .= " AND penaltyStatus = '" . mysqli_real_escape_string($conn, $penaltyStatus) . "'";
}

// Count total records for pagination based on the filtered query
$countResult = mysqli_query($conn, $countSql);
if (!$countResult) {
    die('Error counting records: ' . mysqli_error($conn));
}
$totalRow = mysqli_fetch_assoc($countResult);
$totalRecords = $totalRow['total'];

// Append limit and offset for pagination to the main query
$sql .= " ORDER BY violationDate DESC LIMIT $offset, $pageSize";

// Execute the main query
$result = mysqli_query($conn, $sql);
if (!$result) {
    die('Error executing query: ' . mysqli_error($conn));
}

// Fetch results as an associative array
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

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
?>
