<?php
session_start(); // Start the session

// Check if the form is submitted and toggle value is set
if (isset($_POST['maintenance_toggle'])) {
    // Check the value of the toggle and update the session variable
    if ($_POST['maintenance_toggle'] == 'on') {
        $_SESSION['maintenance_mode'] = true; // Turn on maintenance mode
    } else {
        $_SESSION['maintenance_mode'] = false; // Turn off maintenance mode
    }
}

// Redirect back to the maintenance view page
header("Location: maintenance_view.php");
exit();
?>
