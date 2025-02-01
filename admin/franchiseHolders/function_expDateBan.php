<?php


// Function to calculate expiration date
function calculateExpirationDate($TFno) {
    $TFnoStr = (string)$TFno;
    $secondToLastDigit = (int)substr($TFnoStr, -2, 1);
    $lastDigit = (int)substr($TFnoStr, -1);

    $expirationDay = match (true) {
        in_array($secondToLastDigit, [1, 2, 3]) => 7,
        in_array($secondToLastDigit, [4, 5, 6]) => 14,
        in_array($secondToLastDigit, [7, 8]) => 21,
        default => 28,
    };

    $months = [
        1 => '01', 2 => '02', 3 => '03', 4 => '04',
        5 => '05', 6 => '06', 7 => '07', 8 => '08',
        9 => '09', 0 => '10'
    ];

    $expirationMonth = $months[$lastDigit] ?? '01';
    $currentYear = date('Y');
    $expirationYear = $currentYear + 1;

    return "$expirationDay/$expirationMonth/$expirationYear";
}

// Function to calculate day banned
function calculateDayBanned($TFno) {
    $lastDigit = (int)substr((string)$TFno, -1);
    $daysBanned = [
        0 => 'Monday', 1 => 'Monday', 2 => 'Tuesday', 3 => 'Tuesday',
        4 => 'Wednesday', 5 => 'Wednesday', 6 => 'Thursday', 7 => 'Thursday',
        8 => 'Friday', 9 => 'Friday'
    ];
    return $daysBanned[$lastDigit] ?? 'Unknown';
}

// Validate and fetch input
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    die("Invalid ID provided.");
}

// Find the record in monthly tables
$months = ['jan', 'feb', 'march', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct'];
$row = null;
$table_found = '';

foreach ($months as $month) {
    $table_name = $month . '_operators';
    $sql = "SELECT * FROM $table_name WHERE id = $id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $table_found = $table_name;
        break;
    }
}

if ($row) {
    $TFno = $row['TFno'] ?? null;
    $dtOfRenewal = $row['dtOfrenewal'] ?? '';
    $expDate = $row['expDate'] ?? '';

    if (!$TFno) {
        die("TFno is missing for the record.");
    }

    // Calculate expiration date and day banned
    $expirationDate = calculateExpirationDate($TFno);
    $dayBanned = calculateDayBanned($TFno);

    // Determine the status
    $currentDate = date('d/m/Y');
    if (!empty($dtOfRenewal) && $dtOfRenewal !== '00/00/0000') {
        // Add one year to the expiration date if dtOfRenewal is not empty
        $expDateParts = explode('/', $expirationDate);
        $expirationYear = (int)$expDateParts[2] + 1;
        $expirationDate = $expDateParts[0] . '/' . $expDateParts[1] . '/' . $expirationYear;

        $status = 'Renewed';
    } else {
        if (strtotime(str_replace('/', '-', $expirationDate)) < strtotime(str_replace('/', '-', $currentDate))) {
            $status = 'Expired';
        } else {
            $status = 'Pending for Renewal';
        }
    }

    // Update the database
    $updateSql = $conn->prepare("UPDATE $table_found SET expDate = ?, dayBan = ?, status = ? WHERE TFno = ?");
    $updateSql->bind_param('sssi', $expirationDate, $dayBanned, $status, $TFno);

    if ($updateSql->execute()) {
        // echo "Record updated successfully.";
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "No matching record found.";
}

$conn->close();
?>
