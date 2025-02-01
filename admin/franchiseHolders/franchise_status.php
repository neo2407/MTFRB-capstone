<!-- franchise status -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const expDateField = document.querySelector('input[name="expDate"]');
    const dtOfrenewalField = document.querySelector('input[name="dtOfrenewal"]');
    const statusField = document.querySelector('input[name="status"]');

    function updateStatus() {
        const expDate = expDateField.value;
        const dtOfrenewal = dtOfrenewalField.value;

        fetch(`franchise_status.php?expDate=${encodeURIComponent(expDate)}&dtOfrenewal=${encodeURIComponent(dtOfrenewal)}`)
            .then(response => response.text())
            .then(status => {
                statusField.value = status;
            })
            .catch(error => console.error('Error:', error));s
    }

    // Monitor changes on the relevant fields
    expDateField.addEventListener('change', updateStatus);
    dtOfrenewalField.addEventListener('change', updateStatus);
});
</script>




<?php
include "../include/db_conn.php";
date_default_timezone_set('Asia/Manila'); // Set the timezone

$currentDate = date('Y-m-d'); // Current date
$expDate = $_GET['expDate'] ?? ''; // Get expDate from AJAX request
$dtOfrenewal = $_GET['dtOfrenewal'] ?? ''; // Get dtOfrenewal from AJAX request

$franchise_status = 'Pending for Renewal'; // Default status

if ($currentDate > $expDate) {
    if (empty($dtOfrenewal) || $dtOfrenewal === '0000-00-00') {
        $franchise_status = 'Expired';
    } else {
        $franchise_status = 'Renewed';
    }
}

echo htmlspecialchars($franchise_status); // Return status
?>
