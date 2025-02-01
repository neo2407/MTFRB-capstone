<?php 
include "../include/db_conn.php";

// Query to get the number of franchise applicants
$sql = "SELECT COUNT(*) as count FROM applicants WHERE new_acc=0";
$result = $conn->query($sql);

// Fetch the count
$franchiseCount = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $franchiseCount = $row['count'];
}

// Query to get the number of  complaints
$sql = "SELECT COUNT(*) as count FROM complaints ";
$result = $conn->query($sql);

// Fetch the count
$complaintsCount = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $complaintsCount = $row['count'];
}

// Query to get the number of  complaints
$sql = "SELECT COUNT(*) as count FROM violations ";
$result = $conn->query($sql);

// Fetch the count
$violationsCount = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $violationsCount = $row['count'];
}


// Query to get the total number of operators from all tables
$sql = "
    SELECT COUNT(*) as count FROM jan_operators
    UNION ALL
    SELECT COUNT(*) as count FROM feb_operators
    UNION ALL
    SELECT COUNT(*) as count FROM march_operators
    UNION ALL
    SELECT COUNT(*) as count FROM apr_operators
    UNION ALL
    SELECT COUNT(*) as count FROM may_operators
    UNION ALL
    SELECT COUNT(*) as count FROM jun_operators
    UNION ALL
    SELECT COUNT(*) as count FROM jul_operators
    UNION ALL
    SELECT COUNT(*) as count FROM aug_operators
    UNION ALL
    SELECT COUNT(*) as count FROM sep_operators
    UNION ALL
    SELECT COUNT(*) as count FROM oct_operators
";

$result = $conn->query($sql);

// Fetch the total count
$operatorsCount = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $operatorsCount += $row['count'];
    }
}

// Query to get the total number of operators with pending complaints
$sql = "
    SELECT COUNT(*) as count FROM jan_operators WHERE complaint_description is not null
    UNION ALL
    SELECT COUNT(*) as count FROM feb_operators WHERE complaint_description is not null
    UNION ALL
    SELECT COUNT(*) as count FROM march_operators WHERE complaint_description is not null
    UNION ALL
    SELECT COUNT(*) as count FROM apr_operators WHERE complaint_description is not null
    UNION ALL
    SELECT COUNT(*) as count FROM may_operators WHERE complaint_description is not null
    UNION ALL
    SELECT COUNT(*) as count FROM jun_operators WHERE complaint_description is not null
    UNION ALL
    SELECT COUNT(*) as count FROM jul_operators WHERE complaint_description is not null
    UNION ALL
    SELECT COUNT(*) as count FROM aug_operators WHERE complaint_description is not null
    UNION ALL
    SELECT COUNT(*) as count FROM sep_operators WHERE complaint_description is not null
    UNION ALL
    SELECT COUNT(*) as count FROM oct_operators WHERE complaint_description is not null
";

// Execute the query
$result = $conn->query($sql);

// Fetch the total count
$operators_complaintCount = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $operators_complaintCount += $row['count'];
    }
}

// Query to get the total number renewed franchise
$sql = "
    SELECT COUNT(*) as count FROM jan_operators WHERE status='Renewed'
    UNION ALL
    SELECT COUNT(*) as count FROM feb_operators WHERE status='Renewed'
    UNION ALL
    SELECT COUNT(*) as count FROM march_operators WHERE status='Renewed'
    UNION ALL
    SELECT COUNT(*) as count FROM apr_operators WHERE status='Renewed'
    UNION ALL
    SELECT COUNT(*) as count FROM may_operators WHERE status='Renewed'
    UNION ALL
    SELECT COUNT(*) as count FROM jun_operators WHERE status='Renewed'
    UNION ALL
    SELECT COUNT(*) as count FROM jul_operators WHERE status='Renewed'
    UNION ALL
    SELECT COUNT(*) as count FROM aug_operators WHERE status='Renewed'
    UNION ALL
    SELECT COUNT(*) as count FROM sep_operators WHERE status='Renewed'
    UNION ALL
    SELECT COUNT(*) as count FROM oct_operators WHERE status='Renewed'
";

// Execute the query
$result = $conn->query($sql);

// Fetch the total count
$renewedFranchiseCount = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $renewedFranchiseCount += $row['count'];
    }
}

// Query to get the total number of drop franchise
$sql = "
    SELECT COUNT(*) as count FROM jan_operators WHERE drop_franchise='Drop'
    UNION ALL
    SELECT COUNT(*) as count FROM feb_operators WHERE drop_franchise='Drop'
    UNION ALL
    SELECT COUNT(*) as count FROM march_operators WHERE drop_franchise='Drop'
    UNION ALL
    SELECT COUNT(*) as count FROM apr_operators WHERE drop_franchise='Drop'
    UNION ALL
    SELECT COUNT(*) as count FROM may_operators WHERE drop_franchise='Drop'
    UNION ALL
    SELECT COUNT(*) as count FROM jun_operators WHERE drop_franchise='Drop'
    UNION ALL
    SELECT COUNT(*) as count FROM jul_operators WHERE drop_franchise='Drop'
    UNION ALL
    SELECT COUNT(*) as count FROM aug_operators WHERE drop_franchise='Drop'
    UNION ALL
    SELECT COUNT(*) as count FROM sep_operators WHERE drop_franchise='Drop'
    UNION ALL
    SELECT COUNT(*) as count FROM oct_operators WHERE drop_franchise='Drop'
";

// Execute the query
$result = $conn->query($sql);

// Fetch the total count
$dropFranchiseCount = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dropFranchiseCount += $row['count'];
    }
}


// Query to get the total number of drop franchise
$sql = "
    SELECT COUNT(*) as count FROM jan_operators WHERE status='Expired'
    UNION ALL
    SELECT COUNT(*) as count FROM feb_operators WHERE status='Expired'
    UNION ALL
    SELECT COUNT(*) as count FROM march_operators WHERE status='Expired'
    UNION ALL
    SELECT COUNT(*) as count FROM apr_operators WHERE status='Expired'
    UNION ALL
    SELECT COUNT(*) as count FROM may_operators WHERE status='Expired'
    UNION ALL
    SELECT COUNT(*) as count FROM jun_operators WHERE status='Expired'
    UNION ALL
    SELECT COUNT(*) as count FROM jul_operators WHERE status='Expired'
    UNION ALL
    SELECT COUNT(*) as count FROM aug_operators WHERE status='Expired'
    UNION ALL
    SELECT COUNT(*) as count FROM sep_operators WHERE status='Expired'
    UNION ALL
    SELECT COUNT(*) as count FROM oct_operators WHERE status='Expired'
";

// Execute the query
$result = $conn->query($sql);

// Fetch the total count
$expiredFranchiseCount = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $expiredFranchiseCount += $row['count'];
    }
}


?>