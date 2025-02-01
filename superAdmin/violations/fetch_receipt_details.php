<?php
include "../../include/db_conn.php";

if (isset($_POST['ticketNo'])) {
    $ticketNo = $_POST['ticketNo'];

    // Fetch violation details
    $sql = "SELECT * FROM violations WHERE ticketNo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ticketNo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($violation = $result->fetch_assoc()) {
        echo "
        <h5>Ticket No: {$violation['ticketNo']}</h5>
        <p>Tricycle Franchise No: {$violation['TFno']}</p>
        <p>Date: " . date('Y-m-d') . "</p>
        <p>No. of Offense: {$violation['offense']}</p>
        <table class='table'>
            <thead>
                <tr>
                    <th>Nature of Collection</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Violation</td>
                    <td>{$violation['amount']}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th>Total</th>
                    <th>{$violation['amount']}</th>
                </tr>
            </tfoot>
        </table>
        <p>Amount in Words: " . convertNumberToWords($violation['amount']) . "</p>
        ";
    } else {
        echo "No violation details found.";
    }

    $stmt->close();
    $conn->close();
}

function convertNumberToWords($number) {
    // Implement number-to-words conversion logic here
    return "Fifty Pesos Only"; // Example
}
?>
