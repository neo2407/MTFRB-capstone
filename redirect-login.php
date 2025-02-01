<?php
// Check if user type is set
if (isset($_POST['user_type'])) {
    $userType = $_POST['user_type'];

    // Redirect based on user type
    switch ($userType) {
        case 'applicant':
            header('Location: franchise_applicant/applicant_login.php');
            break;
        case 'tricycle_operator':
            header('Location: tricycle_operator/operator_login.php');
            break;
        case 'admin':
            header('Location: admin/admin_login.php');
            break;
        case 'superadmin':
             header('Location: superAdmin/superAdmin_login.php');
             break;

        // Add more cases for additional user types
        default:
            header('Location: login.php'); // Redirect to default or error page
            break;
    }
    exit(); // Ensure no further code is executed
} else {
    // Redirect to default or error page if no user type is set
    header('Location: login.php');
    exit();
}
