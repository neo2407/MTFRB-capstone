<?php
// Database connection
session_start(); // Start the session
include "../include/db_conn.php";

// Define month-to-table mapping
$monthTables = [
    1 => "jan_operators",
    2 => "feb_operators",
    3 => "march_operators",
    4 => "apr_operators",
    5 => "may_operators",
    6 => "jun_operators",
    7 => "jul_operators",
    8 => "aug_operators",
    9 => "sep_operators",
    0 => "oct_operators" // 0 maps to October
];

// Get the ID and month
$id = $_GET['id'] ?? null;
$month = $_GET['month'] ?? null; 

if (!$id || $month === null || !isset($monthTables[$month % 10])) {
    die("Invalid request. Please provide a valid ID and month.");
}

// Determine the table to query
$table = $monthTables[$month % 10];

// Fetch data from the appropriate table
$sql = "SELECT * FROM $table WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    die("No data found for the given ID and month.");
}

// Generate receipt number and date
$receiptNumber = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
$dateGenerated = date('Y-m-d');

// Output receipt
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order of Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .receipt-container {
            width: 100%;
            max-width: 700px;
            margin: auto;
            border: 1px solid #000;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            height: 80px;
        }
        .details, .amount-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .details td {
            padding: 5px;
        }
        .amount-table th, .amount-table td {
            border: 1px solid #000;
            text-align: left;
            padding: 8px;
        }
        .amount-table th {
            background-color: #f2f2f2;
        }
        .total-row td {
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="header">
            <img src="../../assets/img/mtfrbLogo.png" alt="Logo 1" style="float: left;">
            <img src="../../assets/img/sbLogo.png" alt="Logo 2" style="float: right;">
            <h3>Municipal Tricycle Franchising Regulatory Board - Lucban</h3>
            <p>88 A. Racelis Ave, Lucban, 4328 Quezon</p>
            <h4>ORDER OF PAYMENT</h4>
        </div>
        <table class="details">
            <tr>
                <td><strong>Receipt No:</strong> <?php echo $receiptNumber; ?></td>
                <td><strong>Date:</strong> <?php echo $dateGenerated; ?></td>
            </tr>
            <tr>
                <td><strong>Tricycle Franchise No:</strong> <?php echo htmlspecialchars($row['franchise_no']); ?></td>
                <td><strong>Payor:</strong> <?php echo htmlspecialchars($row['name']); ?></td>
            </tr>
        </table>
        <table class="amount-table">
            <thead>
                <tr>
                    <th>Nature of Collection</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Franchise Renewal</td>
                    <td>PHP <?php echo number_format($row['renewal_payment'], 2); ?></td>
                </tr>
                <?php if (!empty($row['penalty'])): ?>
                <tr>
                    <td>Penalty</td>
                    <td>PHP <?php echo number_format($row['penalty'], 2); ?></td>
                </tr>
                <?php endif; ?>
                <tr class="total-row">
                    <td>Total</td>
                    <td>PHP <?php echo number_format($row['renewal_payment'] + ($row['penalty'] ?? 0), 2); ?></td>
                </tr>
            </tbody>
        </table>
        <div class="footer">
            <p><strong>Amount in Words:</strong> 
                <?php
                // Convert total to words
                function convertToWords($number) {
                    $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                    return ucfirst($f->format($number)) . " pesos only.";
                }
                echo convertToWords($row['renewal_payment'] + ($row['penalty'] ?? 0));
                ?>
            </p>
            
            <div style="display: flex; justify-content: right; text-align: center;">
                <div>
                <p>_________________</p>
                <p><strong>Signature</strong></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
