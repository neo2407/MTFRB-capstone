<?php
include "../../include/db_conn.php";

// Fetch filter values from the request
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';
$username = isset($_GET['username']) ? $_GET['username'] : '';
$type_account = isset($_GET['type_account']) ? $_GET['type_account'] : '';
$login_status = isset($_GET['login_status']) ? $_GET['login_status'] : '';

// Pagination parameters
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$pageSize = isset($_GET['pageSize']) ? intval($_GET['pageSize']) : 50;
$offset = ($page - 1) * $pageSize;

// Ensure pagination parameters are valid
$page = max(1, $page);
$pageSize = max(1, $pageSize);
$offset = max(0, $offset);


$sql = "SELECT * FROM logs_history WHERE 1=1";
$countSql = "SELECT COUNT(*) as total FROM logs_history WHERE 1=1";

// Add conditions based on filters
if (!empty($user_id)) {
    $sql .= " AND user_id LIKE '%" . mysqli_real_escape_string($conn, $user_id) . "%'";
    $countSql .= " AND user_id LIKE '%" . mysqli_real_escape_string($conn, $user_id) . "%'";
}

if (!empty($username)) {
    $sql .= " AND username LIKE '%" . mysqli_real_escape_string($conn, $username) . "'";
    $countSql .= " AND username LIKE '%" . mysqli_real_escape_string($conn, $username) . "'";
}

if (!empty($type_account)) {
    $sql .= " AND account_type = '" . mysqli_real_escape_string($conn, $type_account) . "'";
    $countSql .= " AND account_type = '" . mysqli_real_escape_string($conn, $type_account) . "'";
}

if (!empty($login_status)) {
    $sql .= " AND login_status = '" . mysqli_real_escape_string($conn, $login_status) . "'";
    $countSql .= " AND login_status = '" . mysqli_real_escape_string($conn, $login_status) . "'";
}

// Count total records for pagination based on the filtered query
$countResult = mysqli_query($conn, $countSql);
if (!$countResult) {
    die('Error counting records: ' . mysqli_error($conn));
}
$totalRow = mysqli_fetch_assoc($countResult);
$totalRecords = $totalRow['total'];
$sql .= " ORDER BY date_time DESC";
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
