<?php
// Include database connection
include "../../include/db_conn.php";

// Fetch Order of Payment details based on the orderId
if (isset($_GET['orderId'])) {
    $id = $_GET['id'];
    $orderId = $_GET['orderId'];

    $sql = "SELECT * FROM applicants WHERE orderId = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        $orderDetails = $result->fetch_assoc();
        $stmt->close();
    } else {
        die("Error preparing the query: " . $conn->error);
    }
} else {
    die("Order ID not provided.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Order of Payment</title>
    <style>
        /* Add your CSS styling here to make it look like your uploaded image */
        body {
            font-family: Arial, sans-serif;
        }
        .print-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }
        .header, .footer {
            text-align: center;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .amount-words {
            margin-top: 20px;
            
        }
        
                .header {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px; /* Adjust spacing between logos and text */
        }
        
        .logo-container h3 {
            margin: 0;
            font-size: 1.5em; /* Adjust font size as needed */
            flex: 1; /* Allow heading to take available space */
            text-align: center;
        }
        
        .logo {
            width: 80px; /* Adjust the size of the logo */
            height: auto;
        }
        
         h2 {
            text-align: center;
            margin-top: 10px;
        }
    </style>
    <script>
        // Automatically trigger print dialog when the page loads
        window.onload = function() {
            window.print();
        };
    
        // Redirect to "verified applicants" after printing or closing the print dialog
        window.onafterprint = function() {
            window.location.href = "https://mtfrblucban.com/superAdmin/verifiedApplicants/edit.php?id=$id";
        };
    </script>
</head>
<body>
    
<div class="card">
    <div class="print-container">
        <div class="header">
            <div class="logo-container">
                <img src="../../assets/img/mtfrbLogo.png" alt="Left Logo" class="logo">
                <h3>Municipal Tricycle Franchising and Regulatory Board - Lucban</h3>
                <img src="../../assets/img/sbLogo.jpg" alt="Right Logo" class="logo">
            </div>
            <p style="margin-top:-10px;">88 A. Racelis Ave, Lucban, Quezon</p>
        </div>

        <h2>Order of Payment</h2>
        <p><strong>Order ID:</strong> <?= htmlspecialchars($orderDetails['orderId']); ?></p>
        <p><strong>Payor:</strong> <?= htmlspecialchars($orderDetails['first_name'] . ' ' . $orderDetails['last_name']); ?></p>
        <p><strong>Date:</strong> <?= htmlspecialchars($orderDetails['paymentDate']); ?></p>

        <table class="table">
            <thead>
                <tr>
                    <th>Nature of Collection</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= htmlspecialchars($orderDetails['nature']); ?></td>
                    <td><?= number_format($orderDetails['amount'], 2); ?></td>
                </tr>
                <tr>
                    <td><b>Total</b></td>
                    <td><?= number_format($orderDetails['amount'], 2); ?></td>
                </tr>
            </tbody>
        </table>
        <p class="amount-words"><strong>Amount in Words:</strong> <?= htmlspecialchars($orderDetails['amount_words']); ?></p>
        <div class="footer">
        </div>
    </div>
  </div>
</body>
</html>
