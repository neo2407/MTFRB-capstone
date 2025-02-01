
<?php
session_start();

// Unset all of the session variables
$_SESSION = array();
session_unset();
// Destroy the session
session_destroy();

// Redirect to the login page after logout
header("Location:applicant_login.php");
exit();
?>
