<?php
// Function to calculate expiration date
function calculateExpirationDate($id) {
    $idStr = (string)$id;
    $secondToLastDigit = (int)$idStr[strlen($idStr) - 2];
    $lastDigit = (int)$idStr[strlen($idStr) - 1];

    if (in_array($secondToLastDigit, [1, 2, 3])) {
        $expirationDay = 7;
    } elseif (in_array($secondToLastDigit, [4, 5, 6])) {
        $expirationDay = 14;
    } elseif (in_array($secondToLastDigit, [7, 8])) {
        $expirationDay = 21;
    } else { // 0 and 9
        $expirationDay = 28;
    }

    $months = [
        1 => '01',
        2 => '02',
        3 => '03',
        4 => '04',
        5 => '05',
        6 => '06',
        7 => '07',
        8 => '08',
        9 => '09',
        0 => '10'
    ];

    $expirationMonth = $months[$lastDigit];
    $currentYear = date('Y');
    $expirationYear = $currentYear + 1;

    return $expirationDay . '/' . $expirationMonth . '/' . $expirationYear;
}

// Function to calculate day banned
function calculateDayBanned($id) {
    $idStr = (string)$id;
    $lastDigit = (int)$idStr[strlen($idStr) - 1];

    $daysBanned = [
        0 => 'Monday',
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Tuesday',
        4 => 'Wednesday',
        5 => 'Wednesday',
        6 => 'Thursday',
        7 => 'Thursday',
        8 => 'Friday',
        9 => 'Friday'
    ];

    return $daysBanned[$lastDigit];
}

$id = $_GET['id'];

$months = ['jan', 'feb', 'march', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct'];
$row = null;
$table_found = '';

foreach ($months as $month) {
    $table_name = $month . '_operators';
    $sql = "SELECT * FROM $table_name WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $table_found = $table_name;
        break;
    }
}

if ($row) {
    $dtOfrenewal = $row['dtOfrenewal'];
    $expDate = $row['expDate'];

    $expirationDate = calculateExpirationDate($id);
    $dayBanned = calculateDayBanned($id);

    // Convert dates to DateTime objects for comparison
    $renewalDate = DateTime::createFromFormat('d/m/Y', $dtOfrenewal);
    $expirationDateObj = DateTime::createFromFormat('d/m/Y', $expirationDate);

    if ($dtOfrenewal == '00/00/0000') {
        if ($expirationDateObj < new DateTime()) {
            $status = 'Expired';
        } else {
            $status = 'Pending for Renewal';
        }
    } elseif ($renewalDate < $expirationDateObj) {
        $status = 'Renewed';
        // Add one year to the expiration date
        $expirationDateObj->modify('+1 year');
        $expirationDate = $expirationDateObj->format('d/m/Y');
    } else {
        $status = 'Expired';
    }

    // Update the database with the calculated values and status
    $updateSql = "UPDATE $table_found SET expDate = '$expirationDate', dayBan = '$dayBanned', status = '$status' WHERE id = $id";
    if (mysqli_query($conn, $updateSql)) {
        // echo "Record updated successfully.<br>";
    } else {
        echo "Error updating record: " . mysqli_error($conn) . "<br>";
    }
}
?>