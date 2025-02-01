<?php
include "../../include/db_conn.php";

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Fetch filter values from the request
$id = isset($_GET['id']) ? $_GET['id'] : '';
$TFno = isset($_GET['TFno']) ? $_GET['TFno'] : '';
$complaint_description = isset($_GET['complaint_description']) ? $_GET['complaint_description'] : '';
$complaint_interview_stat = isset($_GET['complaint_interview_stat']) ? $_GET['complaint_interview_stat'] : '';
$complaintStatus = isset($_GET['complaintStatus']) ? $_GET['complaintStatus'] : '';

// Pagination parameters
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$pageSize = isset($_GET['pageSize']) ? intval($_GET['pageSize']) : 10;
$page = max(1, $page);
$pageSize = max(1, $pageSize);
$offset = ($page - 1) * $pageSize;

// Base query to fetch data from all monthly tables
$baseQuery = "
    SELECT id, TFno, interview_schedule, complaint_description, complaint_interview_stat, complaintStatus, '{month}' AS month 
    FROM {table} 
    WHERE interview_schedule IS NOT NULL AND interview_schedule != '' 
    AND complaint_description IS NOT NULL AND complaint_description != ''
    {filter_complaint_interview_stat}
";

$months = [
    'January' => 'jan_operators',
    'February' => 'feb_operators',
    'March' => 'march_operators',
    'April' => 'apr_operators',
    'May' => 'may_operators',
    'June' => 'jun_operators',
    'July' => 'jul_operators',
    'August' => 'aug_operators',
    'September' => 'sep_operators',
    'October' => 'oct_operators'
];

$unions = [];
foreach ($months as $month => $table) {
    $filter_complaint_interview_stat = !empty($complaint_interview_stat) 
        ? "AND complaint_interview_stat = '" . mysqli_real_escape_string($conn, $complaint_interview_stat) . "'" 
        : '';
         $filter_complaint_stat = !empty($complaintStatus) 
        ? "AND complaintStatus = '" . mysqli_real_escape_string($conn, $complaintStatus) . "'" 
        : '';
    $unions[] = str_replace(
        ['{month}', '{table}', '{filter_complaint_interview_stat}'],
        [$month, $table, $filter_complaint_interview_stat, $filter_complaint_stat],
        $baseQuery
    );
}

// Combine all queries using UNION
$sql = implode(" UNION ALL ", $unions);

// Apply additional filters for TFno and complaint_description
if (!empty($TFno) || !empty($complaint_description)) {
    $sql = "SELECT * FROM ($sql) AS subquery WHERE 1=1";
    if (!empty($TFno)) {
        $sql .= " AND TFno LIKE '%" . mysqli_real_escape_string($conn, trim($TFno)) . "%'";
    }
    if (!empty($complaint_description)) {
        $sql .= " AND complaint_description LIKE '%" . mysqli_real_escape_string($conn, trim($complaint_description)) . "%'";
    }
}

// Count total records
$countSql = "SELECT COUNT(*) AS total FROM ($sql) AS subquery";
$countResult = mysqli_query($conn, $countSql);
if (!$countResult) {
    die(json_encode(['error' => 'Error counting records: ' . mysqli_error($conn)]));
}
$totalRow = mysqli_fetch_assoc($countResult);
$totalRecords = $totalRow['total'];

// Append limit and offset for pagination
$sql .= " LIMIT $offset, $pageSize";

// Execute the main query
$result = mysqli_query($conn, $sql);
if (!$result) {
    die(json_encode(['error' => 'Error executing query: ' . mysqli_error($conn)]));
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
    'currentPage' => $page,
    'totalRecords' => $totalRecords
]);

mysqli_close($conn);
?>
