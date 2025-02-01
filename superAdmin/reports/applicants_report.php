<?php
include "../include/db_conn.php";

$sql = "SELECT COUNT(*) as count FROM applicants";
$result = $conn->query($sql);

// Fetch the count
$total_applicants = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_applicants = $row['count'];
}

$sql = "SELECT COUNT(*) as count FROM applicants WHERE applicantStatus='Pending'";
$result = $conn->query($sql);

// Fetch the count
$total_applicantsPending = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_applicantsPending = $row['count'];
}

$sql = "SELECT COUNT(*) as count FROM applicants WHERE applicantStatus='Verified'";
$result = $conn->query($sql);

// Fetch the count
$total_applicantsVerified = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_applicantsVerified = $row['count'];
}



// Function to initialize monthly counts
function initializeMonthlyCounts() {
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

$applicantsMonth_Count = initializeMonthlyCounts();
$applicantsMonth_VerifiedCount = initializeMonthlyCounts();
$applicantsMonth_PendingCount = initializeMonthlyCounts();

// First Query: Total Applicants
$sql = "SELECT MONTH(STR_TO_DATE(applicationDate, '%Y-%m-%d %h:%i %p')) AS month, COUNT(*) AS count
        FROM applicants 
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
        $applicantsMonth_Count[$monthName] = $count;
    }
}

// Second Query: Verified Applicants
$sql = "SELECT MONTH(STR_TO_DATE(applicationDate, '%Y-%m-%d %h:%i %p')) AS month, COUNT(*) AS count
        FROM applicants 
        WHERE applicantStatus='Verified'
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
        $applicantsMonth_VerifiedCount[$monthName] = $count;
    }
}


// Third Query: Pending Applicants
$sql = "SELECT MONTH(STR_TO_DATE(applicationDate, '%Y-%m-%d %h:%i %p')) AS month, COUNT(*) AS count
        FROM applicants 
        WHERE applicantStatus='Pending'
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
        $applicantsMonth_PendingCount[$monthName] = $count;
    }
}

// Assign counts to individual variables for use in JavaScript
$janCount = $applicantsMonth_Count['January'];
$febCount = $applicantsMonth_Count['February'];
$marCount = $applicantsMonth_Count['March'];
$aprCount = $applicantsMonth_Count['April'];
$mayCount = $applicantsMonth_Count['May'];
$junCount = $applicantsMonth_Count['June'];
$julCount = $applicantsMonth_Count['July'];
$augCount = $applicantsMonth_Count['August'];
$sepCount = $applicantsMonth_Count['September'];
$octCount = $applicantsMonth_Count['October'];
$novCount = $applicantsMonth_Count['November'];
$decCount = $applicantsMonth_Count['December'];

$janCount_verified = $applicantsMonth_VerifiedCount['January'];
$febCount_verified = $applicantsMonth_VerifiedCount['February'];
$marCount_verified = $applicantsMonth_VerifiedCount['March'];
$aprCount_verified = $applicantsMonth_VerifiedCount['April'];
$mayCount_verified = $applicantsMonth_VerifiedCount['May'];
$junCount_verified = $applicantsMonth_VerifiedCount['June'];
$julCount_verified = $applicantsMonth_VerifiedCount['July'];
$augCount_verified = $applicantsMonth_VerifiedCount['August'];
$sepCount_verified = $applicantsMonth_VerifiedCount['September'];
$octCount_verified = $applicantsMonth_VerifiedCount['October'];
$novCount_verified = $applicantsMonth_VerifiedCount['November'];
$decCount_verified = $applicantsMonth_VerifiedCount['December'];

$janCount_pending= $applicantsMonth_PendingCount['January'];
$febCount_pending = $applicantsMonth_PendingCount['February'];
$marCount_pending = $applicantsMonth_PendingCount['March'];
$aprCount_pending = $applicantsMonth_PendingCount['April'];
$mayCount_pending = $applicantsMonth_PendingCount['May'];
$junCount_pending = $applicantsMonth_PendingCount['June'];
$julCount_pending = $applicantsMonth_PendingCount['July'];
$augCount_pending = $applicantsMonth_PendingCount['August'];
$sepCount_pending = $applicantsMonth_PendingCount['September'];
$octCount_pending = $applicantsMonth_PendingCount['October'];
$novCount_pending = $applicantsMonth_PendingCount['November'];
$decCount_pending = $applicantsMonth_PendingCount['December']

?>