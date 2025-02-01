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

switch ($reportDuration) {
    case 'daily':
        $groupBy = "DATE(paymentDate)";
        $labelFormat = "DATE_FORMAT(paymentDate, '%Y-%m-%d')"; // Format as YYYY-MM-DD
        $orderBy = "DATE(paymentDate)";
        break;

    case 'weekly':
        $groupBy = "YEAR(paymentDate), WEEK(paymentDate, 1)";
        $labelFormat = "CONCAT(YEAR(paymentDate), '-W', LPAD(WEEK(paymentDate, 1), 2, '0'))"; // Format as YYYY-WXX
        $orderBy = "YEAR(paymentDate), WEEK(paymentDate, 1)";
        break;

    case 'monthly':
        $groupBy = "YEAR(paymentDate), MONTH(paymentDate)";
        $labelFormat = "DATE_FORMAT(paymentDate, '%Y-%m')"; // Store as YYYY-MM for sorting
        $orderBy = "YEAR(paymentDate), MONTH(paymentDate)";
        break;

    case 'yearly':
        $groupBy = "YEAR(paymentDate)";
        $labelFormat = "YEAR(paymentDate)"; // Format as YYYY
        $orderBy = "YEAR(paymentDate)";
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
        COUNT(*) AS total_transactions,
        SUM(amount) AS total_amount_collected
    FROM franchise_fee
    WHERE paymentDate BETWEEN ? AND ?
    GROUP BY {$groupBy}
    ORDER BY {$orderBy} ASC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $startDateFormatted, $endDateFormatted);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $tableData = [];
    $chartData = ['labels' => [], 'totalTransactions' => [], 'totalAmount' => []];
    $existingPeriods = [];

    while ($row = $result->fetch_assoc()) {
        $existingPeriods[] = $row['period_key'];

        $label = $row['period_key']; // Default to period_key
        if ($reportDuration === 'monthly') {
            $label = date('F Y', strtotime($row['period_key'] . '-01')); // Format as 'Month YYYY'
        }

        $entry = [
            'label' => $label,
            'totalTransactions' => intval($row['total_transactions']),
            'totalAmount' => floatval($row['total_amount_collected']),
        ];
        
        $tableData[$row['period_key']] = $entry;

        $chartData['data'][] = [
            'period_key' => $row['period_key'],
            'label' => $label,
            'totalTransactions' => intval($row['total_transactions']),
            'totalAmount' => floatval($row['total_amount_collected']),
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
                    $label = date('F Y', strtotime($period . '-01')); // Format as 'Month YYYY'
                    break;
                case 'yearly':
                    $label = $period;
                    break;
            }
            
            $tableData[$period] = [
                'label' => $label,
                'totalTransactions' => 0,
                'totalAmount' => 0.0
            ];
            
            $chartData['data'][] = [
                'period_key' => $period,
                'label' => $label,
                'totalTransactions' => 0,
                'totalAmount' => 0.0
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
        $chartData['totalTransactions'][] = $item['totalTransactions'];
        $chartData['totalAmount'][] = $item['totalAmount'];
    }
    unset($chartData['data']); // Remove the temporary data array

    $totalAmount = array_sum(array_column($tableData, 'totalAmount'));

    echo json_encode([
        'success' => true,
        'totalAmount' => $totalAmount,
        'tableData' => array_values($tableData), // Convert to indexed array
        'chartData' => $chartData
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'No data found for the selected date range.']);
}
?>
