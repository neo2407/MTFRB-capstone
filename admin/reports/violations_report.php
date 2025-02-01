<?php
include "../include/db_conn.php";

$sql = "SELECT COUNT(*) as count FROM violations";
$result = $conn->query($sql);

// Fetch the count
$total_violations = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_violations = $row['count'];
}

$sql = "SELECT COUNT(*) as count FROM violations WHERE penaltyStatus='Paid'";
$result = $conn->query($sql);

// Fetch the count
$total_violationsSettled = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_violationsSettled = $row['count'];
}

$sql = "SELECT COUNT(*) as count FROM violations WHERE penaltyStatus='To be paid'";
$result = $conn->query($sql);

// Fetch the count
$total_violationsUnSettled = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_violationsUnSettled = $row['count'];
}

// Function to complaints monthly counts
function violationsMonthlyCounts() {
    return [
        'January' => 0,
        'February' => 0,
        'March' => 0,
        'April' => 0,
        'May' => 0,
        'June' => 0,
        'July' => 0,
        'August' => 0,
        'September' => 0,
        'October' => 0,
        'November' => 0,
        'December' => 0
    ];
}

$violationsMonth_Count = violationsMonthlyCounts();
$violationsMonth_SettledCount = violationsMonthlyCounts();
$violationsMonth_UnSettledCount = violationsMonthlyCounts();

// First Query: Total Violations in different months
$sql = "SELECT MONTH(violationDate) AS month, COUNT(*) AS count
        FROM violations
        GROUP BY month
        ORDER BY month";
$result = $conn->query($sql);

if ($result === false) {
    die("Error in first query: " . $conn->error);
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $monthNumber = $row['month'];
        $count = $row['count'];
        $monthName = date('F', mktime(0, 0, 0, $monthNumber, 10)); // Get month name
        $violationsMonth_Count[$monthName] = $count;
    }
}

// Second Query: Settled Violations
$sql = "SELECT MONTH(violationDate) AS month, COUNT(*) AS count
        FROM violations 
        WHERE penaltyStatus='Paid'
        GROUP BY month
        ORDER BY month";
$result = $conn->query($sql);

if ($result === false) {
    die("Error in second query: " . $conn->error);
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $monthNumber = $row['month'];
        $count = $row['count'];
        $monthName = date('F', mktime(0, 0, 0, $monthNumber, 10)); // Get month name
        $violationsMonth_SettledCount[$monthName] = $count;
    }
}

// Third Query: UnSettled Violations
$sql = "SELECT MONTH(violationDate) AS month, COUNT(*) AS count
        FROM violations 
        WHERE penaltyStatus='To be paid'
        GROUP BY month
        ORDER BY month";
$result = $conn->query($sql);

if ($result === false) {
    die("Error in second query: " . $conn->error);
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $monthNumber = $row['month'];
        $count = $row['count'];
        $monthName = date('F', mktime(0, 0, 0, $monthNumber, 10)); // Get month name
        $violationsMonth_UnSettledCount[$monthName] = $count;
    }
}

$Jan_count = $violationsMonth_Count['January'];
$Feb_count = $violationsMonth_Count['February'];
$Mar_count = $violationsMonth_Count['March'];
$Apr_count = $violationsMonth_Count['April'];
$May_count = $violationsMonth_Count['May'];
$Jun_count = $violationsMonth_Count['June'];
$Jul_count = $violationsMonth_Count['July'];
$Aug_count = $violationsMonth_Count['August'];
$Sep_count = $violationsMonth_Count['September'];
$Oct_count = $violationsMonth_Count['October'];
$Nov_count= $violationsMonth_Count['November'];
$Dec_count = $violationsMonth_Count['December'];

$janCount_settled = $violationsMonth_SettledCount['January'];
$febCount_settled = $violationsMonth_SettledCount['February'];
$marCount_settled = $violationsMonth_SettledCount['March'];
$aprCount_settled = $violationsMonth_SettledCount['April'];
$mayCount_settled = $violationsMonth_SettledCount['May'];
$junCount_settled = $violationsMonth_SettledCount['June'];
$julCount_settled = $violationsMonth_SettledCount['July'];
$augCount_settled = $violationsMonth_SettledCount['August'];
$sepCount_settled = $violationsMonth_SettledCount['September'];
$octCount_settled = $violationsMonth_SettledCount['October'];
$novCount_settled = $violationsMonth_SettledCount['November'];
$decCount_settled = $violationsMonth_SettledCount['December'];

$janCount_unsettled = $violationsMonth_UnSettledCount['January'];
$febCount_unsettled = $violationsMonth_UnSettledCount['February'];
$marCount_unsettled = $violationsMonth_UnSettledCount['March'];
$aprCount_unsettled = $violationsMonth_UnSettledCount['April'];
$mayCount_unsettled = $violationsMonth_UnSettledCount['May'];
$junCount_unsettled = $violationsMonth_UnSettledCount['June'];
$julCount_unsettled = $violationsMonth_UnSettledCount['July'];
$augCount_unsettled = $violationsMonth_UnSettledCount['August'];
$sepCount_unsettled = $violationsMonth_UnSettledCount['September'];
$octCount_unsettled = $violationsMonth_UnSettledCount['October'];
$novCount_unsettled = $violationsMonth_UnSettledCount['November'];
$decCount_unsettled = $violationsMonth_UnSettledCount['December'];

?>