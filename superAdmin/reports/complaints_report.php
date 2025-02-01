<?php
include "../include/db_conn.php";

$sql = "SELECT COUNT(*) as count FROM complaints";
$result = $conn->query($sql);

// Fetch the count
$total_complaints = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_complaints = $row['count'];
}

$sql = "SELECT COUNT(*) as count FROM complaints WHERE complaintStatus='Resolved'";
$result = $conn->query($sql);

// Fetch the count
$total_complaintsResolved = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_complaintsResolved = $row['count'];
}

$sql = "SELECT COUNT(*) as count FROM complaints WHERE complaintStatus='Dismissed'";
$result = $conn->query($sql);

// Fetch the count
$total_complaintsDismissed = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_complaintsDismissed = $row['count'];
}



// Function to complaints monthly counts
function complaintsMonthlyCounts() {
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

$complaintsMonth_Count = complaintsMonthlyCounts();
$complaintsMonth_ResolvedCount = complaintsMonthlyCounts();
$complaintsMonth_DismissedCount = complaintsMonthlyCounts();

// First Query: Total Complaints in different months
$sql = "SELECT MONTH(dateOfincident) AS month, COUNT(*) AS count
        FROM complaints 
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
        $complaintsMonth_Count[$monthName] = $count;
    }
}

// Second Query: Resolved Complaints
$sql = "SELECT MONTH(dateOfincident) AS month, COUNT(*) AS count
        FROM complaints  
        WHERE complaintStatus='Resolved'
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
        $complaintsMonth_ResolvedCount[$monthName] = $count;
    }
}

// Third Query: Dismissed Complaints
$sql = "SELECT MONTH(dateOfincident) AS month, COUNT(*) AS count
        FROM complaints  
        WHERE complaintStatus='Dismissed'
        GROUP BY month
        ORDER BY month";
$result = $conn->query($sql);

if ($result === false) {
    die("Error in third query: " . $conn->error);
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $monthNumber = $row['month'];
        $count = $row['count'];
        $monthName = date('F', mktime(0, 0, 0, $monthNumber, 10)); // Get month name
        $complaintsMonth_DismissedCount[$monthName] = $count;
    }
}

// Assigning counts to variables for each month
$jan_count = $complaintsMonth_Count['January'];
$feb_count = $complaintsMonth_Count['February'];
$mar_count = $complaintsMonth_Count['March'];
$apr_count = $complaintsMonth_Count['April'];
$may_count = $complaintsMonth_Count['May'];
$jun_count = $complaintsMonth_Count['June'];
$jul_count = $complaintsMonth_Count['July'];
$aug_count = $complaintsMonth_Count['August'];
$sep_count = $complaintsMonth_Count['September'];
$oct_count = $complaintsMonth_Count['October'];
$nov_count = $complaintsMonth_Count['November'];
$dec_count = $complaintsMonth_Count['December'];

$janCount_resolved = $complaintsMonth_ResolvedCount['January'];
$febCount_resolved = $complaintsMonth_ResolvedCount['February'];
$marCount_resolved = $complaintsMonth_ResolvedCount['March'];
$aprCount_resolved = $complaintsMonth_ResolvedCount['April'];
$mayCount_resolved = $complaintsMonth_ResolvedCount['May'];
$junCount_resolved = $complaintsMonth_ResolvedCount['June'];
$julCount_resolved = $complaintsMonth_ResolvedCount['July'];
$augCount_resolved = $complaintsMonth_ResolvedCount['August'];
$sepCount_resolved = $complaintsMonth_ResolvedCount['September'];
$octCount_resolved = $complaintsMonth_ResolvedCount['October'];
$novCount_resolved = $complaintsMonth_ResolvedCount['November'];
$decCount_resolved = $complaintsMonth_ResolvedCount['December'];

$janCount_dismissed = $complaintsMonth_DismissedCount['January'];
$febCount_dismissed = $complaintsMonth_DismissedCount['February'];
$marCount_dismissed = $complaintsMonth_DismissedCount['March'];
$aprCount_dismissed = $complaintsMonth_DismissedCount['April'];
$mayCount_dismissed = $complaintsMonth_DismissedCount['May'];
$junCount_dismissed = $complaintsMonth_DismissedCount['June'];
$julCount_dismissed = $complaintsMonth_DismissedCount['July'];
$augCount_dismissed = $complaintsMonth_DismissedCount['August'];
$sepCount_dismissed = $complaintsMonth_DismissedCount['September'];
$octCount_dismissed = $complaintsMonth_DismissedCount['October'];
$novCount_dismissed = $complaintsMonth_DismissedCount['November'];
$decCount_dismissed = $complaintsMonth_DismissedCount['December'];
?>