<?php
// Include database connection
include "../include/db_conn.php"; // Adjust path if necessary

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$reportType = $data['reportType'];
$startDate = $data['startDate'];
$endDate = $data['endDate'];

// Array of monthly table names
$monthlyTables = [
    "jan_operators", "feb_operators", "march_operators",
    "apr_operators", "may_operators", "jun_operators",
    "jul_operators", "aug_operators", "sep_operators",
    "oct_operators"
];

// Initialize counters
$totalCount = 0;
$expiredCount = 0;
$renewedCount = 0;
$droppedCount = 0;
$totalRenewalPayment = 0.0;
$totalPenalty = 0.0;

// Data for the table view
$tableData = [];

// Data for the chart view
$chartData = [];

if ($reportType === 'franchise') {
    foreach ($monthlyTables as $table) {
        // Validate table name to avoid SQL injection
        if (!preg_match('/^[a-z_]+$/i', $table)) {
            echo json_encode(['success' => false, 'message' => 'Invalid table name.']);
            exit;
        }

        // Query to get total operators
       /** $totalSql = "SELECT COUNT(*) as count FROM $table WHERE grant_date BETWEEN ? AND ?";
        $stmt = $conn->prepare($totalSql);
        $stmt->bind_param('ss', $startDate, $endDate);
        $stmt->execute();
        $totalResult = $stmt->get_result();
        $totalCountForTable = 0;
        if ($totalResult->num_rows > 0) {
            $row = $totalResult->fetch_assoc();
            $totalCountForTable = $row['count'];
            $totalCount += $row['count'];

            // Add to chart data
            $chartData[] = ['month' => $table, 'total' => $row['count']];
        }
        $stmt->close();**/
        // Query to get total operators
        $totalSql = "SELECT COUNT(*) as count FROM $table";
        $stmt = $conn->prepare($totalSql);
        $stmt->execute();
        $totalResult = $stmt->get_result();
        $totalCountForTable = 0;
        if ($totalResult->num_rows > 0) {
            $row = $totalResult->fetch_assoc();
            $totalCountForTable = $row['count'];
            $totalCount += $row['count'];
        
            // Add to chart data
            $chartData[] = ['month' => $table, 'total' => $row['count']];
        }
        $stmt->close();


        // Ensure the dates are in the correct 'yyyy-mm-dd' format
        $startDate = date('Y-m-d', strtotime($startDate));
        $endDate = date('Y-m-d', strtotime($endDate));
        
        $expiredSql = "SELECT COUNT(*) as count FROM $table WHERE status='Expired' AND STR_TO_DATE(expDate, '%d/%m/%Y') BETWEEN ? AND ?";
        $stmt = $conn->prepare($expiredSql);
        $stmt->bind_param('ss', $startDate, $endDate);
        $stmt->execute();
        $expiredResult = $stmt->get_result();
        
        $expiredCountForTable = 0;
        if ($expiredResult->num_rows > 0) {
            $row = $expiredResult->fetch_assoc();
            $expiredCountForTable = $row['count'];
            $expiredCount += $row['count'];
        }
        $stmt->close();

         $startDate = date('Y-m-d', strtotime($startDate));
        $endDate = date('Y-m-d', strtotime($endDate));
        
        // Query to get renewed operators
        $renewedSql = "SELECT COUNT(*) as count FROM $table WHERE status='Renewed' AND dtOfrenewal BETWEEN ? AND ?";
        $stmt = $conn->prepare($renewedSql);
        $stmt->bind_param('ss', $startDate, $endDate);
        $stmt->execute();
        $renewedResult = $stmt->get_result();
        $renewedCountForTable = 0;
        if ($renewedResult->num_rows > 0) {
            $row = $renewedResult->fetch_assoc();
            $renewedCountForTable = $row['count'];
            $renewedCount += $row['count'];
        }
        $stmt->close();
        
        // Query to get drop franchise
        $droppedSql = "SELECT COUNT(*) as count FROM $table WHERE drop_franchise='Drop' AND dropping_date BETWEEN ? AND ?";
        $stmt = $conn->prepare($droppedSql);
        $stmt->bind_param('ss', $startDate, $endDate);
        $stmt->execute();
        $droppedResult = $stmt->get_result();
        $droppedCountForTable = 0;
        if ($droppedResult->num_rows > 0) {
            $row = $droppedResult->fetch_assoc();
            $droppedCountForTable = $row['count'];
            $droppedCount += $row['count'];
        }
        $stmt->close();

        // Query to get total renewal payment
        $renewalPaymentSql = "SELECT SUM(renewal_payment) as total FROM $table WHERE dtOfrenewal BETWEEN ? AND ?";
        $stmt = $conn->prepare($renewalPaymentSql);
        $stmt->bind_param('ss', $startDate, $endDate);
        $stmt->execute();
        $renewalPaymentResult = $stmt->get_result();
        $renewalPaymentForTable = 0.0;
        if ($renewalPaymentResult->num_rows > 0) {
            $row = $renewalPaymentResult->fetch_assoc();
            $renewalPaymentForTable = $row['total'] ?? 0.0;
            $totalRenewalPayment += $renewalPaymentForTable;
        }
        $stmt->close();

        // Query to get total penalty
        $penaltySql = "SELECT SUM(penalty) as total FROM $table WHERE dtOfrenewal BETWEEN ? AND ?";
        $stmt = $conn->prepare($penaltySql);
        $stmt->bind_param('ss', $startDate, $endDate);
        $stmt->execute();
        $penaltyResult = $stmt->get_result();
        $penaltyForTable = 0.0;
        if ($penaltyResult->num_rows > 0) {
            $row = $penaltyResult->fetch_assoc();
            $penaltyForTable = $row['total'] ?? 0.0;
            $totalPenalty += $penaltyForTable;
        }
        $stmt->close();

        // Add to table data (detailed rows for each table)
        $tableData[] = [
            'table' => $table,
            'total' => $totalCountForTable,
            'expired' => $expiredCountForTable,
            'renewed' => $renewedCountForTable,
            'dropped' => $droppedCountForTable,
            'renewal_payment' => $renewalPaymentForTable,
            'penalty' => $penaltyForTable,
        ];
    }

    // Response data
    $response = [
        'success' => true,
        'tableData' => $tableData,
        'chartData' => $chartData,
        'summary' => [
            'totalOperators' => $totalCount,
            'expiredOperators' => $expiredCount,
            'renewedOperators' => $renewedCount,
            'droppedOperators' => $droppedCount,
            'totalRenewalPayment' => $totalRenewalPayment,
            'totalPenalty' => $totalPenalty,
        ]
    ];

    // Output as JSON
    echo json_encode($response);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
