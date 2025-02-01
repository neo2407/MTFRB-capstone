<?php
include "../include/db_conn.php";
header('Content-Type: application/json');

$rawInput = file_get_contents('php://input');
$data = json_decode($rawInput, true);

$debug = [
    'raw_input' => $rawInput,
    'decoded_data' => $data,
    'missing_fields' => []
];

if (empty($data['reportType'])) {
    $debug['missing_fields'][] = 'reportType';
}
if (empty($data['reportDuration'])) {
    $debug['missing_fields'][] = 'reportDuration';
}
if (empty($data['startDate'])) {
    $debug['missing_fields'][] = 'startDate';
}
if (empty($data['endDate'])) {
    $debug['missing_fields'][] = 'endDate';
}

if (!empty($debug['missing_fields'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Missing required parameters: ' . implode(', ', $debug['missing_fields']),
        'debug' => $debug
    ]);
    exit;
}

$reportType = $data['reportType'];
$reportDuration = strtolower($data['reportDuration']);
$startDate = $data['startDate'];
$endDate = $data['endDate'];

$tableData = [];
$chartData = ['labels' => [], 'total' => [], 'verified' => [], 'denied' => []];

$startDateFormatted = date('Y-m-d H:i:s', strtotime($startDate . ' 00:00:00'));
$endDateFormatted = date('Y-m-d H:i:s', strtotime($endDate . ' 23:59:59'));

switch ($reportDuration) {
    case 'daily':
        $groupBy = "DATE(applicationDate)";
        $labelFormat = "DATE(applicationDate)";
        $orderBy = "DATE(applicationDate)";
        break;

    case 'weekly':
        $groupBy = "YEAR(applicationDate), WEEK(applicationDate, 1)";
        $labelFormat = "CONCAT(YEAR(applicationDate), '-W', WEEK(applicationDate, 1))";
        $orderBy = "YEAR(applicationDate), WEEK(applicationDate, 1)";
        break;

    case 'monthly':
        $groupBy = "YEAR(applicationDate), MONTH(applicationDate)";
        $labelFormat = "DATE_FORMAT(applicationDate, '%M %Y')";
        $orderBy = "YEAR(applicationDate), MONTH(applicationDate)";
        break;

    case 'yearly':
        $groupBy = "YEAR(applicationDate)";
        $labelFormat = "YEAR(applicationDate)";
        $orderBy = "YEAR(applicationDate)";
        break;

    default:
        echo json_encode([
            'success' => false,
            'message' => 'Invalid report duration. Must be daily, weekly, monthly, or yearly.',
            'received_duration' => $reportDuration
        ]);
        exit;
}

if ($reportDuration === 'weekly') {
    $query = "SELECT 
        CONCAT(
            YEAR(applicationDate), 
            '-W', 
            LPAD(WEEK(applicationDate, 1), 2, '0')
        ) AS label,
        COUNT(*) AS total,
        SUM(CASE WHEN applicantStatus = 'Verified' THEN 1 ELSE 0 END) AS verified,
        SUM(CASE WHEN applicantStatus = 'Denied' THEN 1 ELSE 0 END) AS denied
    FROM applicants 
    WHERE applicationDate BETWEEN ? AND ? 
    GROUP BY YEAR(applicationDate), WEEK(applicationDate, 1)
    ORDER BY YEAR(applicationDate), WEEK(applicationDate, 1)";
} else if ($reportDuration === 'daily') {
    $query = "SELECT 
        DATE(applicationDate) AS label,
        COUNT(*) AS total,
        SUM(CASE WHEN applicantStatus = 'Verified' THEN 1 ELSE 0 END) AS verified,
        SUM(CASE WHEN applicantStatus = 'Denied' THEN 1 ELSE 0 END) AS denied
    FROM applicants 
    WHERE applicationDate BETWEEN ? AND ? 
    GROUP BY DATE(applicationDate)
    ORDER BY DATE(applicationDate)";
} else {
    $query = "SELECT 
        {$labelFormat} AS label,
        COUNT(*) AS total,
        SUM(CASE WHEN applicantStatus = 'Verified' THEN 1 ELSE 0 END) AS verified,
        SUM(CASE WHEN applicantStatus = 'Denied' THEN 1 ELSE 0 END) AS denied
    FROM applicants 
    WHERE applicationDate BETWEEN ? AND ? 
    GROUP BY {$groupBy}
    ORDER BY {$orderBy}";
}

$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $startDateFormatted, $endDateFormatted);
$stmt->execute();
$result = $stmt->get_result();

$tableData = [];
$chartData = ['labels' => [], 'total' => [], 'verified' => [], 'denied' => []];

if ($reportDuration === 'daily') {
    $dateRange = [];
    $currentDate = strtotime($startDateFormatted);
    $endDateTimestamp = strtotime($endDateFormatted);

    while ($currentDate <= $endDateTimestamp) {
        $dateRange[] = date('Y-m-d', $currentDate);
        $currentDate = strtotime("+1 day", $currentDate);
    }
} 

if ($reportDuration === 'monthly') {
    $dateRange = [];
    $currentDate = strtotime($startDateFormatted);
    $endDateTimestamp = strtotime($endDateFormatted);

    while ($currentDate <= $endDateTimestamp) {
        $dateRange[] = date('F Y', $currentDate);
        $currentDate = strtotime("+1 month", $currentDate);
    }
}

$existingDates = [];
while ($row = $result->fetch_assoc()) {
    $existingDates[] = $row['label'];
    $tableData[] = [
        'label' => $row['label'],
        'total' => intval($row['total']),
        'verified' => intval($row['verified']),
        'denied' => intval($row['denied'])
    ];
    $chartData['labels'][] = $row['label'];
    $chartData['total'][] = intval($row['total']);
    $chartData['verified'][] = intval($row['verified']);
    $chartData['denied'][] = intval($row['denied']);
}

if ($reportDuration === 'weekly') {
    $weekRange = [];
    $currentDate = strtotime($startDateFormatted);
    $endDateTimestamp = strtotime($endDateFormatted);

    while ($currentDate <= $endDateTimestamp) {
        $yearWeek = date('Y-\WW', $currentDate);
        if (!in_array($yearWeek, $weekRange)) {
            $weekRange[] = $yearWeek;
        }
        $currentDate = strtotime("+1 week", $currentDate);
    }

    $weekRange = array_filter($weekRange, function($week) use ($startDateFormatted, $endDateFormatted) {
        $weekStartDate = strtotime("{$week}1");
        return $weekStartDate >= strtotime($startDateFormatted) && $weekStartDate <= strtotime($endDateFormatted);
    });

    foreach ($weekRange as $week) {
        if (!in_array($week, $existingDates)) {
            $tableData[] = [
                'label' => $week,
                'total' => 0,
                'verified' => 0,
                'denied' => 0
            ];
            $chartData['labels'][] = $week;
            $chartData['total'][] = 0;
            $chartData['verified'][] = 0;
            $chartData['denied'][] = 0;
        }
    }
}

if ($reportDuration === 'daily') {
    foreach ($dateRange as $date) {
        if (!in_array($date, $existingDates)) {
            $tableData[] = [
                'label' => $date,
                'total' => 0,
                'verified' => 0,
                'denied' => 0
            ];
            $chartData['labels'][] = $date;
            $chartData['total'][] = 0;
            $chartData['verified'][] = 0;
            $chartData['denied'][] = 0;
        }
    }
}

if ($reportDuration === 'monthly') {
    foreach ($dateRange as $monthLabel) {
        if (!in_array($monthLabel, $existingDates)) {
            $tableData[] = [
                'label' => $monthLabel,
                'total' => 0,
                'verified' => 0,
                'denied' => 0
            ];
            $chartData['labels'][] = $monthLabel;
            $chartData['total'][] = 0;
            $chartData['verified'][] = 0;
            $chartData['denied'][] = 0;
        }
    }
}

if ($reportDuration === 'weekly') {
    usort($tableData, function ($a, $b) {
        list($yearA, $weekA) = explode('-W', $a['label']);
        list($yearB, $weekB) = explode('-W', $b['label']);
        
        $yearCompare = $yearA - $yearB;
        if ($yearCompare === 0) {
            return (int)$weekA - (int)$weekB;
        }
        
        return $yearCompare;
    });
}

usort($tableData, function ($a, $b) {
    return strtotime($a['label']) - strtotime($b['label']);
});

$chartData['labels'] = array_map(function ($data) {
    return $data['label'];
}, $tableData);

$chartData['total'] = array_map(function ($data) {
    return $data['total'];
}, $tableData);

$chartData['verified'] = array_map(function ($data) {
    return $data['verified'];
}, $tableData);

$chartData['denied'] = array_map(function ($data) {
    return $data['denied'];
}, $tableData);

$totalApplicants = array_sum(array_column($tableData, 'total'));

echo json_encode([
    'success' => true,
    'totalApplicants' => $totalApplicants,
    'tableData' => $tableData,
    'chartData' => $chartData
]);
?>