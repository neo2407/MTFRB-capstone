<?php
include "../include/db_conn.php";

/*Fetch new applications
$new_applications_sql = "SELECT id, first_name, last_name FROM applicants WHERE is_new = 1 ORDER BY applicationDate DESC";
$new_applications_result = mysqli_query($conn, $new_applications_sql);
$new_applications = mysqli_fetch_all($new_applications_result, MYSQLI_ASSOC);*/
 
// Fetch new complaints
$new_complaints_sql = "SELECT id, first_name, last_name FROM complaints WHERE is_new = 1";
$new_complaints_result = mysqli_query($conn, $new_complaints_sql);
$new_complaints = mysqli_fetch_all($new_complaints_result, MYSQLI_ASSOC);


// Fetch unseen notifications / update files
$notifications_sql = "SELECT id, message FROM notifications WHERE seen = 0  ORDER BY id DESC";
$notifications_result = mysqli_query($conn, $notifications_sql);
$notifications = mysqli_fetch_all($notifications_result, MYSQLI_ASSOC);

// Combine both counts
$total_notifications =  count($new_complaints) + count($notifications)  ;

// Prepare the response
$response = [
    'count' => $total_notifications,
    //'applications' => $new_applications,
    'complaints' => $new_complaints,
    'notifications' => $notifications
];

echo json_encode($response);
?>
