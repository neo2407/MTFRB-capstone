<?php
include "../include/db_conn.php";

header('Content-Type: application/json');

// Decode incoming JSON data
$data = json_decode(file_get_contents('php://input'), true);
$reportDuration = isset($data['reportDuration']) ? strtolower($data['reportDuration']) : null;
$startDate = isset($data['startDate']) ? $data['startDate'] : null;
$endDate = isset($data['endDate']) ? $data['endDate'] : null;

// Validate input data
if (!$reportDuration || !$startDate || !$endDate) {
    echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
    exit;
}

// Format query dates to match database format
$startDateFormatted = date('Y-m-d 00:00:00', strtotime($startDate));
$endDateFormatted = date('Y-m-d 23:59:59', strtotime($endDate));

// Switch case for different report durations
switch ($reportDuration) {
    case 'daily':
        $groupBy = "DATE(violationDate)";
        $labelFormat = "DATE_FORMAT(violationDate, '%Y-%m-%d')"; // Format as YYYY-MM-DD
        $orderBy = "DATE(violationDate)";
        break;

    case 'weekly':
        $groupBy = "YEAR(violationDate), WEEK(violationDate, 1)";
        $labelFormat = "CONCAT(YEAR(violationDate), '-W', LPAD(WEEK(violationDate, 1), 2, '0'))"; // Format as YYYY-WXX
        $orderBy = "YEAR(violationDate), WEEK(violationDate, 1)";
        break;

    case 'monthly':
        $groupBy = "YEAR(violationDate), MONTH(violationDate)";
        $labelFormat = "DATE_FORMAT(violationDate, '%Y-%m')"; // Store as YYYY-MM for sorting
        $orderBy = "YEAR(violationDate), MONTH(violationDate)";
        break;

    case 'yearly':
        $groupBy = "YEAR(violationDate)";
        $labelFormat = "YEAR(violationDate)"; // Format as YYYY
        $orderBy = "YEAR(violationDate)";
        break;

    default:
        echo json_encode([
            'success' => false,
            'message' => 'Invalid report duration. Must be daily, weekly, monthly, or yearly.',
            'received_duration' => $reportDuration
        ]);
        exit;
}

// Generate time periods array based on the report duration
$timePeriods = [];
$currentDate = strtotime($startDateFormatted);
$endDateTimestamp = strtotime($endDateFormatted);

while ($currentDate <= $endDateTimestamp) {
    switch ($reportDuration) {
        case 'daily':
            $formattedTimePeriod = date('Y-m-d', $currentDate);
            $timePeriods[] = $formattedTimePeriod;
            $currentDate = strtotime("+1 day", $currentDate);
            break;

        case 'weekly':
            $weekNumber = date('W', $currentDate);
            $year = date('Y', $currentDate);
            $formattedTimePeriod = $year . '-W' . str_pad($weekNumber, 2, '0', STR_PAD_LEFT);
            if (!in_array($formattedTimePeriod, $timePeriods)) {
                $timePeriods[] = $formattedTimePeriod;
            }
            $currentDate = strtotime("+1 week", $currentDate);
            break;

        case 'monthly':
            $formattedTimePeriod = date('Y-m', $currentDate);
            if (!in_array($formattedTimePeriod, $timePeriods)) {
                $timePeriods[] = $formattedTimePeriod;
            }
            $currentDate = strtotime("+1 month", $currentDate);
            break;

        case 'yearly':
            $year = date('Y', $currentDate);
            if (!in_array($year, $timePeriods)) {
                $timePeriods[] = $year;
            }
            $currentDate = strtotime("+1 year", $currentDate);
            break;
    }
}

// Build the SQL query for violations report
$sql = "
    SELECT 
        {$labelFormat} AS period_key,
        COUNT(*) AS total,
        SUM(CASE WHEN penaltyStatus = 'Paid' THEN 1 ELSE 0 END) AS settled,
        SUM(CASE WHEN TRIM(LOWER(penaltyStatus)) = 'pending' OR penaltyStatus IS NULL THEN 1 ELSE 0 END) AS unsettled,
        SUM(CASE WHEN penaltyStatus = 'Paid' THEN penaltyCharged ELSE 0 END) AS penalty_collected
    FROM violations 
    WHERE violationDate BETWEEN ? AND ?
    GROUP BY {$groupBy}
    ORDER BY {$orderBy} ASC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $startDateFormatted, $endDateFormatted);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $tableData = [];
    $chartData = ['labels' => [], 'total' => [], 'settled' => [], 'unsettled' => [], 'penalty_collected' => []];
    $existingPeriods = [];

    while ($row = $result->fetch_assoc()) {
        $existingPeriods[] = $row['period_key'];

        // Format the period label based on the duration
        $label = $row['period_key'];
        if ($reportDuration === 'monthly') {
            $label = date('F Y', strtotime($row['period_key'] . '-01'));
        }

        $entry = [
            'label' => $label,
            'total' => intval($row['total']),
            'settled' => intval($row['settled']),
            'unsettled' => intval($row['unsettled']),
            'penalty_collected' => floatval($row['penalty_collected']),
        ];

        // Add to table data and chart data
        $tableData[$row['period_key']] = $entry;
        $chartData['labels'][] = $label;
        $chartData['total'][] = intval($row['total']);
        $chartData['settled'][] = intval($row['settled']);
        $chartData['unsettled'][] = intval($row['unsettled']);
        $chartData['penalty_collected'][] = floatval($row['penalty_collected']);
    }

    // Add missing periods with zero values
    foreach ($timePeriods as $period) {
        if (!in_array($period, $existingPeriods)) {
            $label = $period;
            
            switch ($reportDuration) {
                case 'daily':
                    $label = date('Y-m-d', strtotime($period));
                    break;
                case 'weekly':
                    $label = $period; // Already in YYYY-WXX format
                    break;
                case 'monthly':
                    $label = date('F Y', strtotime($period . '-01'));
                    break;
                case 'yearly':
                    $label = $period;
                    break;
            }

            // Add missing data to table and chart
            $tableData[$period] = [
                'label' => $label,
                'total' => 0,
                'settled' => 0,
                'unsettled' => 0,
                'penalty_collected' => 0.0
            ];

            $chartData['labels'][] = $label;
            $chartData['total'][] = 0;
            $chartData['settled'][] = 0;
            $chartData['unsettled'][] = 0;
            $chartData['penalty_collected'][] = 0.0;
        }
    }

    // Sort the data by period_key
    ksort($tableData);
    $totalViolations = array_sum(array_column($tableData, 'total'));

    echo json_encode([
        'success' => true,
        'totalViolations' => $totalViolations,
        'tableData' => array_values($tableData),
        'chartData' => $chartData
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'No data found for the selected date range.']);
}

?>
