<?php
include "../include/db_conn.php";

header('Content-Type: application/json');

// Decode incoming JSON data
$data = json_decode(file_get_contents('php://input'), true);
$reportType = isset($data['reportType']) ? $data['reportType'] : null;
$reportDuration = isset($data['reportDuration']) ? strtolower($data['reportDuration']) : null;
$startDate = isset($data['startDate']) ? $data['startDate'] : null;
$endDate = isset($data['endDate']) ? $data['endDate'] : null;

// Validate input data
if (!$reportType || !$reportDuration || !$startDate || !$endDate) {
    echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
    exit;
}

// Format query dates to match database format
$startDateFormatted = date('Y-m-d 00:00:00', strtotime($startDate));
$endDateFormatted = date('Y-m-d 23:59:59', strtotime($endDate));

switch ($reportDuration) {
    case 'daily':
        $groupBy = "DATE(dateOfincident)";
        $labelFormat = "DATE_FORMAT(dateOfincident, '%Y-%m-%d')"; // Format as YYYY-MM-DD
        $orderBy = "DATE(dateOfincident)";
        break;

    case 'weekly':
        $groupBy = "YEAR(dateOfincident), WEEK(dateOfincident, 1)";
        $labelFormat = "CONCAT(YEAR(dateOfincident), '-W', LPAD(WEEK(dateOfincident, 1), 2, '0'))"; // Format as YYYY-WXX
        $orderBy = "YEAR(dateOfincident), WEEK(dateOfincident, 1)";
        break;

    case 'monthly':
        $groupBy = "YEAR(dateOfincident), MONTH(dateOfincident)";
        $labelFormat = "DATE_FORMAT(dateOfincident, '%Y-%m')"; // Store as YYYY-MM for sorting
        $orderBy = "YEAR(dateOfincident), MONTH(dateOfincident)";
        break;

    case 'yearly':
        $groupBy = "YEAR(dateOfincident)";
        $labelFormat = "YEAR(dateOfincident)"; // Format as YYYY
        $orderBy = "YEAR(dateOfincident)";
        break;

    default:
        echo json_encode([
            'success' => false,
            'message' => 'Invalid report duration. Must be daily, weekly, monthly, or yearly.',
            'received_duration' => $reportDuration
        ]);
        exit;
}

// Generate time periods array
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

// Build the SQL query
$sql = "
    SELECT 
        {$labelFormat} AS period_key,
        CASE 
            WHEN '$reportDuration' = 'daily' THEN DATE_FORMAT(dateOfincident, '%Y-%m-%d')
            WHEN '$reportDuration' = 'weekly' THEN CONCAT(YEAR(dateOfincident), '-W', LPAD(WEEK(dateOfincident, 1), 2, '0'))
            WHEN '$reportDuration' = 'monthly' THEN DATE_FORMAT(dateOfincident, '%M %Y')
            WHEN '$reportDuration' = 'yearly' THEN YEAR(dateOfincident)
        END AS label,
        COUNT(*) AS total,
        COUNT(CASE WHEN complaintStatus = 'Resolved' THEN 1 ELSE NULL END) AS resolved,
        COUNT(CASE WHEN complaintStatus = 'Dismissed' THEN 1 ELSE NULL END) AS dismissed,
        COUNT(CASE WHEN complaintStatus = 'For Validation' THEN 1 ELSE NULL END) AS for_validation
    FROM complaints 
    WHERE dateOfincident BETWEEN ? AND ?
    GROUP BY {$groupBy}
    ORDER BY {$orderBy} ASC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $startDateFormatted, $endDateFormatted);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $tableData = [];
    $chartData = ['labels' => [], 'total' => [], 'resolved' => [], 'dismissed' => [], 'for_validation' => []];
    $existingPeriods = [];

    while ($row = $result->fetch_assoc()) {
        $existingPeriods[] = $row['period_key'];
        $entry = [
            'label' => $row['label'],
            'total' => intval($row['total']),
            'resolved' => intval($row['resolved']),
            'dismissed' => intval($row['dismissed']),
            'for_validation' => intval($row['for_validation'])
        ];
        
        $tableData[$row['period_key']] = $entry;
        
        // Store data for sorting
        $chartData['data'][] = [
            'period_key' => $row['period_key'],
            'label' => $row['label'],
            'total' => intval($row['total']),
            'resolved' => intval($row['resolved']),
            'dismissed' => intval($row['dismissed']),
            'for_validation' => intval($row['for_validation'])
        ];
    }

    // Add missing periods with zero values
    foreach ($timePeriods as $period) {
        if (!in_array($period, $existingPeriods)) {
            $label = $period; // Default for yearly
            
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
            
            $tableData[$period] = [
                'label' => $label,
                'total' => 0,
                'resolved' => 0,
                'dismissed' => 0,
                'for_validation' => 0
            ];
            
            $chartData['data'][] = [
                'period_key' => $period,
                'label' => $label,
                'total' => 0,
                'resolved' => 0,
                'dismissed' => 0,
                'for_validation' => 0
            ];
        }
    }

    // Sort the data by period_key
    ksort($tableData);
    usort($chartData['data'], function($a, $b) {
        return strcmp($a['period_key'], $b['period_key']);
    });

    // Reorganize chart data into separate arrays
    foreach ($chartData['data'] as $item) {
        $chartData['labels'][] = $item['label'];
        $chartData['total'][] = $item['total'];
        $chartData['resolved'][] = $item['resolved'];
        $chartData['dismissed'][] = $item['dismissed'];
        $chartData['for_validation'][] = $item['for_validation'];
    }
    unset($chartData['data']); // Remove the temporary data array

    $totalComplaints = array_sum(array_column($tableData, 'total'));

    echo json_encode([
        'success' => true,
        'totalComplaints' => $totalComplaints,
        'tableData' => array_values($tableData), // Convert to indexed array
        'chartData' => $chartData
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'No data found for the selected date range.']);
}
?>