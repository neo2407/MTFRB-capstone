<?php 
include "../include/db_conn.php";

// Query to get the number of  operators in month of january
$sql = "SELECT COUNT(*) as count FROM jan_operators ";
$result = $conn->query($sql);

// Fetch the count
$jan_Count = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $jan_Count = $row['count'];
}

// Query to get the number of  operators in month of feb
$sql = "SELECT COUNT(*) as count FROM feb_operators ";
$result = $conn->query($sql);

// Fetch the count
$feb_Count = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $feb_Count = $row['count'];
}

// Query to get the number of  operators in month of march
$sql = "SELECT COUNT(*) as count FROM march_operators ";
$result = $conn->query($sql);

// Fetch the count
$march_Count = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $march_Count = $row['count'];
}

// Query to get the number of  operators in month of april
$sql = "SELECT COUNT(*) as count FROM apr_operators ";
$result = $conn->query($sql);

// Fetch the count
$apr_Count = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $apr_Count = $row['count'];
}

// Query to get the number of  operators in month of may
$sql = "SELECT COUNT(*) as count FROM may_operators ";
$result = $conn->query($sql);

// Fetch the count
$may_Count = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $may_Count = $row['count'];
}

// Query to get the number of  operators in month of june
$sql = "SELECT COUNT(*) as count FROM jun_operators ";
$result = $conn->query($sql);

// Fetch the count
$jun_Count = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $jun_Count = $row['count'];
}

// Query to get the number of  operators in month of july
$sql = "SELECT COUNT(*) as count FROM jul_operators ";
$result = $conn->query($sql);

// Fetch the count
$jul_Count = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $jul_Count = $row['count'];
}

// Query to get the number of  operators in month of august
$sql = "SELECT COUNT(*) as count FROM aug_operators ";
$result = $conn->query($sql);

// Fetch the count
$aug_Count = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $aug_Count = $row['count'];
}

// Query to get the number of  operators in month of september
$sql = "SELECT COUNT(*) as count FROM sep_operators ";
$result = $conn->query($sql);

// Fetch the count
$sep_Count = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $sep_Count = $row['count'];
}

// Query to get the number of  operators in month of october
$sql = "SELECT COUNT(*) as count FROM oct_operators ";
$result = $conn->query($sql);

// Fetch the count
$oct_Count = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $oct_Count = $row['count'];
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

// Fetch the total count of operators
$operatorsCount = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $operatorsCount += $row['count'];
    }
}


// expired franchise
$sql = "SELECT COUNT(*) as count FROM jan_operators WHERE status='Expired'";
$result = $conn->query($sql);

// Fetch the count
$jan_expiredCount = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $jan_expiredCount = $row['count'];
}

$sql = "SELECT COUNT(*) as count FROM feb_operators WHERE status='Expired'";
$result = $conn->query($sql);

// Fetch the count
$feb_expiredCount = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $feb_expiredCount = $row['count'];
}

$sql = "SELECT COUNT(*) as count FROM march_operators WHERE status='Expired'";
$result = $conn->query($sql);

// Fetch the count
$march_expiredCount = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $march_expiredCount = $row['count'];
}

$sql = "SELECT COUNT(*) as count FROM apr_operators WHERE status='Expired'";
$result = $conn->query($sql);

// Fetch the count
$apr_expiredCount = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $apr_expiredCount = $row['count'];
}

$sql = "SELECT COUNT(*) as count FROM may_operators WHERE status='Expired'";
$result = $conn->query($sql);

// Fetch the count
$may_expiredCount = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $may_expiredCount = $row['count'];
}

$sql = "SELECT COUNT(*) as count FROM jun_operators WHERE status='Expired'";
$result = $conn->query($sql);

// Fetch the count
$jun_expiredCount = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $jun_expiredCount = $row['count'];
}

$sql = "SELECT COUNT(*) as count FROM jul_operators WHERE status='Expired'";
$result = $conn->query($sql);

// Fetch the count
$jul_expiredCount = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $jul_expiredCount = $row['count'];
}


$sql = "SELECT COUNT(*) as count FROM aug_operators WHERE status='Expired'";
$result = $conn->query($sql);

// Fetch the count
$aug_expiredCount = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $aug_expiredCount = $row['count'];
}

$sql = "SELECT COUNT(*) as count FROM sep_operators WHERE status='Expired'";
$result = $conn->query($sql);

// Fetch the count
$sep_expiredCount = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $sep_expiredCount = $row['count'];
}

$sql = "SELECT COUNT(*) as count FROM oct_operators WHERE status='Expired'";
$result = $conn->query($sql);

// Fetch the count
$oct_expiredCount = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $oct_expiredCount = $row['count'];
}

// Query to get the total number of operators from all tables WHERE status='Expired'
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

$result = $conn->query($sql);

// Fetch the total count of operators
$operators_expiredCount = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $operators_expiredCount += $row['count'];
    }
}





// renewed franchise
$sql = "SELECT COUNT(*) as count FROM jan_operators WHERE status='Renewed'";
$result = $conn->query($sql);

// Fetch the count
$jan_renewedCount = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $jan_renewedCount = $row['count'];
}

$sql = "SELECT COUNT(*) as count FROM feb_operators WHERE status='Renewed'";
$result = $conn->query($sql);

// Fetch the count
$feb_renewedCount = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $feb_renewedCount = $row['count'];
}

$sql = "SELECT COUNT(*) as count FROM march_operators WHERE status='Renewed'";
$result = $conn->query($sql);

// Fetch the count
$march_renewedCount = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $march_renewedCount = $row['count'];
}

$sql = "SELECT COUNT(*) as count FROM apr_operators WHERE status='Renewed'";
$result = $conn->query($sql);

// Fetch the count
$apr_renewedCount = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $apr_renewedCount = $row['count'];
}

$sql = "SELECT COUNT(*) as count FROM may_operators WHERE status='Renewed'";
$result = $conn->query($sql);

// Fetch the count
$may_renewedCount = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $may_renewedCount = $row['count'];
}

$sql = "SELECT COUNT(*) as count FROM jun_operators WHERE status='Renewed'";
$result = $conn->query($sql);

// Fetch the count
$jun_renewedCount = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $jun_renewedCount = $row['count'];
}

$sql = "SELECT COUNT(*) as count FROM jul_operators WHERE status='Renewed'";
$result = $conn->query($sql);

// Fetch the count
$jul_renewedCount = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $jul_renewedCount = $row['count'];
}


$sql = "SELECT COUNT(*) as count FROM aug_operators WHERE status='Renewed'";
$result = $conn->query($sql);

// Fetch the count
$aug_renewedCount = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $aug_renewedCount = $row['count'];
}

$sql = "SELECT COUNT(*) as count FROM sep_operators WHERE status='Renewed'";
$result = $conn->query($sql);

// Fetch the count
$sep_renewedCount = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $sep_renewedCount = $row['count'];
}

$sql = "SELECT COUNT(*) as count FROM oct_operators WHERE status='Renewed'";
$result = $conn->query($sql);

// Fetch the count
$oct_renewedCount = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $oct_renewedCount = $row['count'];
}

// Query to get the total number of operators from all tables  WHERE status='Renewed'
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

$result = $conn->query($sql);

// Fetch the total count of operators
$operators_renewedCount = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $operators_renewedCount += $row['count'];
    }
}





?>