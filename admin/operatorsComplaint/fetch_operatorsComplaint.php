<?php
include "../../include/db_conn.php";

// Fetch filter values from the request
$id = isset($_GET['id']) ? $_GET['id'] : '';
$complaint_description = isset($_GET['complaint_description']) ? $_GET['complaint_description'] : '';
$complaint_interview_stat = isset($_GET['complaint_interview_stat']) ? $_GET['complaint_interview_stat'] : '';
$complaintStatus = isset($_GET['complaintStatus']) ? $_GET['complaintStatus'] : '';

// Pagination parameters
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$pageSize = isset($_GET['pageSize']) ? intval($_GET['pageSize']) : 10;
$offset = ($page - 1) * $pageSize;

// Ensure pagination parameters are valid
$page = max(1, $page);
$pageSize = max(1, $pageSize);
$offset = max(0, $offset);

$sql = "
    SELECT id, TFno, interview_schedule, complaint_description, complaint_interview_stat, complaintStatus, 'January' AS month 
    FROM jan_operators 
    WHERE interview_schedule IS NOT NULL AND interview_schedule != '' 
    AND complaint_description IS NOT NULL AND complaint_description != '' 
    " . (!empty($complaint_interview_stat) ? "AND complaint_interview_stat = '" . mysqli_real_escape_string($conn, $complaint_interview_stat) . "'" : "") . "
    UNION ALL 
    SELECT id, TFno, interview_schedule, complaint_description, complaint_interview_stat, complaintStatus, 'February' AS month 
    FROM feb_operators 
    WHERE interview_schedule IS NOT NULL AND interview_schedule != '' 
    AND complaint_description IS NOT NULL AND complaint_description != '' 
    " . (!empty($complaint_interview_stat) ? "AND complaint_interview_stat = '" . mysqli_real_escape_string($conn, $complaint_interview_stat) . "'" : "") . "
    UNION ALL 
    SELECT id, TFno, interview_schedule, complaint_description, complaint_interview_stat, complaintStatus, 'March' AS month 
    FROM march_operators 
    WHERE interview_schedule IS NOT NULL AND interview_schedule != '' 
    AND complaint_description IS NOT NULL AND complaint_description != '' 
    " . (!empty($complaint_interview_stat) ? "AND complaint_interview_stat = '" . mysqli_real_escape_string($conn, $complaint_interview_stat) . "'" : "") . "
    UNION ALL 
    SELECT id, TFno, interview_schedule, complaint_description, complaint_interview_stat, complaintStatus, 'April' AS month 
    FROM apr_operators 
    WHERE interview_schedule IS NOT NULL AND interview_schedule != '' 
    AND complaint_description IS NOT NULL AND complaint_description != '' 
    " . (!empty($complaint_interview_stat) ? "AND complaint_interview_stat = '" . mysqli_real_escape_string($conn, $complaint_interview_stat) . "'" : "") . "
    UNION ALL 
    SELECT id, TFno, interview_schedule, complaint_description, complaint_interview_stat, complaintStatus, 'May' AS month 
    FROM may_operators 
    WHERE interview_schedule IS NOT NULL AND interview_schedule != '' 
    AND complaint_description IS NOT NULL AND complaint_description != '' 
    " . (!empty($complaint_interview_stat) ? "AND complaint_interview_stat = '" . mysqli_real_escape_string($conn, $complaint_interview_stat) . "'" : "") . "
    UNION ALL 
    SELECT id, TFno, interview_schedule, complaint_description, complaint_interview_stat, complaintStatus, 'June' AS month 
    FROM jun_operators 
    WHERE interview_schedule IS NOT NULL AND interview_schedule != '' 
    AND complaint_description IS NOT NULL AND complaint_description != '' 
    " . (!empty($complaint_interview_stat) ? "AND complaint_interview_stat = '" . mysqli_real_escape_string($conn, $complaint_interview_stat) . "'" : "") . "
    UNION ALL 
    SELECT id, TFno, interview_schedule, complaint_description, complaint_interview_stat, complaintStatus, 'July' AS month 
    FROM jul_operators 
    WHERE interview_schedule IS NOT NULL AND interview_schedule != '' 
    AND complaint_description IS NOT NULL AND complaint_description != '' 
    " . (!empty($complaint_interview_stat) ? "AND complaint_interview_stat = '" . mysqli_real_escape_string($conn, $complaint_interview_stat) . "'" : "") . "
    UNION ALL 
    SELECT id, TFno, interview_schedule, complaint_description, complaint_interview_stat, complaintStatus, 'August' AS month 
    FROM aug_operators 
    WHERE interview_schedule IS NOT NULL AND interview_schedule != '' 
    AND complaint_description IS NOT NULL AND complaint_description != '' 
    " . (!empty($complaint_interview_stat) ? "AND complaint_interview_stat = '" . mysqli_real_escape_string($conn, $complaint_interview_stat) . "'" : "") . "
    UNION ALL 
    SELECT id, TFno, interview_schedule, complaint_description, complaint_interview_stat, complaintStatus, 'September' AS month 
    FROM sep_operators 
    WHERE interview_schedule IS NOT NULL AND interview_schedule != '' 
    AND complaint_description IS NOT NULL AND complaint_description != '' 
    " . (!empty($complaint_interview_stat) ? "AND complaint_interview_stat = '" . mysqli_real_escape_string($conn, $complaint_interview_stat) . "'" : "") . "
    UNION ALL 
    SELECT id, TFno, interview_schedule, complaint_description, complaint_interview_stat, complaintStatus, 'October' AS month 
    FROM oct_operators 
    WHERE interview_schedule IS NOT NULL AND interview_schedule != '' 
    AND complaint_description IS NOT NULL AND complaint_description != '' 
    " . (!empty($complaint_interview_stat) ? "AND complaint_interview_stat = '" . mysqli_real_escape_string($conn, $complaint_interview_stat) . "'" : "") . "
";


// Add additional filters for ID and description outside the union
if (!empty($id)) {
    $sql = "SELECT * FROM ($sql) AS subquery WHERE id LIKE '%" . mysqli_real_escape_string($conn, $id) . "%'";
}

if (!empty($complaint_description)) {
    $sql .= " AND complaint_description LIKE '%" . mysqli_real_escape_string($conn, $complaint_description) . "%'";
}
// Add conditions based on filters
if (!empty($id)) {
    $sql .= " AND id LIKE '%" . mysqli_real_escape_string($conn, $id) . "%'";
}

if (!empty($complaint_description)) {
    $sql .= " AND complaint_description LIKE '%" . mysqli_real_escape_string($conn, $complaint_description) . "%'";
}

if (!empty($complaint_interview_stat)) {
    $sql .= " AND complaint_interview_stat = '" . mysqli_real_escape_string($conn, $complaint_interview_stat) . "'";
}

// Counting total records
$countSql = "SELECT COUNT(*) as total FROM ($sql) AS subquery";
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
