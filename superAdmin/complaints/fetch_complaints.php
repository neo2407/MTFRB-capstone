<?php
include "../../include/db_conn.php";

// Automatically update interviewStatus based on the interview date
$currentDate = date('Y-m-d H:i:s');
$updateStatusQuery = "
    UPDATE complaints
    SET interviewStatus = CASE
        WHEN interview_dt IS NULL OR interview_dt = '' THEN 'Pending'
        WHEN interview_dt < '$currentDate' THEN 'Missed'
        ELSE 'Pending'
    END
    WHERE interviewStatus != 'Done'";
mysqli_query($conn, $updateStatusQuery);




// Fetch filter values from the request
$madeOf = isset($_GET['madeOf']) ? $_GET['madeOf'] : '';
$colorOftric = isset($_GET['colorOftric']) ? $_GET['colorOftric'] : '';
$first_name = isset($_GET['first_name']) ? $_GET['first_name'] : '';
$last_name = isset($_GET['last_name']) ? $_GET['last_name'] : '';
$complaintStatus = isset($_GET['complaintStatus']) ? $_GET['complaintStatus'] : '';

// Pagination parameters
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$pageSize = isset($_GET['pageSize']) ? intval($_GET['pageSize']) : 10;
$offset = ($page - 1) * $pageSize;

// Ensure pagination parameters are valid
$page = max(1, $page);
$pageSize = max(1, $pageSize);
$offset = max(0, $offset);

// Base SQL query with WHERE 1=1
$sql = "SELECT * FROM complaints WHERE 1=1";
$countSql = "SELECT COUNT(*) as total FROM complaints WHERE 1=1"; // Counting query

// Add conditions based on filters
if (!empty($colorOftric)) {
    $colorOftric = mysqli_real_escape_string($conn, $colorOftric);
    $sql .= " AND colorOftric LIKE '%$colorOftric%'";
    $countSql .= " AND colorOftric LIKE '%$colorOftric%'";
}

if (!empty($first_name)) {
    $first_name = mysqli_real_escape_string($conn, $first_name);
    $sql .= " AND first_name LIKE '%$first_name%'";
    $countSql .= " AND first_name LIKE '%$first_name%'";
}

if (!empty($last_name)) {
    $last_name = mysqli_real_escape_string($conn, $last_name);
    $sql .= " AND last_name LIKE '%$last_name%'";
    $countSql .= " AND last_name LIKE '%$last_name%'";
}

if (!empty($madeOf)) {
    $madeOf = mysqli_real_escape_string($conn, $madeOf);
    $sql .= " AND madeOf = '$madeOf'";
    $countSql .= " AND madeOf = '$madeOf'";
}

if (!empty($complaintStatus)) {
    $complaintStatus = mysqli_real_escape_string($conn, $complaintStatus);
    $sql .= " AND complaintStatus = '$complaintStatus'";
    $countSql .= " AND complaintStatus = '$complaintStatus'";
}

// Count total records for pagination based on the filtered query
$countResult = mysqli_query($conn, $countSql);
if (!$countResult) {
    die(json_encode(['error' => 'Error counting records: ' . mysqli_error($conn)]));
}
$totalRow = mysqli_fetch_assoc($countResult);
$totalRecords = $totalRow['total'];

// Append limit and offset for pagination to the main query
$sql .= " LIMIT $offset, $pageSize";

// Execute the main query
$result = mysqli_query($conn, $sql);
if (!$result) {
    die(json_encode(['error' => 'Error executing query: ' . mysqli_error($conn)]));
}

// Fetch results as an associative array
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Ensure $data is always an array
if (!$data) {
    $data = [];
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
?>
