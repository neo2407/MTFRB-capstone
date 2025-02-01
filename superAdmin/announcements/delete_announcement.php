<?php
session_start();
include "../../include/db_conn.php";

// Set content type to JSON
header('Content-Type: application/json');

$response = array();

if (isset($_POST["id"])) { // Use POST instead of GET
    $id = $_POST["id"];

    $uploadDirAnnouncement = '../../uploads/announcements/';

    // Retrieve the file paths from the database
    $sqlSelect = "SELECT image FROM `announcements` WHERE id = ?";
    $stmtSelect = mysqli_prepare($conn, $sqlSelect);

    if ($stmtSelect) {
        mysqli_stmt_bind_param($stmtSelect, "i", $id);
        mysqli_stmt_execute($stmtSelect);
        mysqli_stmt_bind_result($stmtSelect, $image);
        mysqli_stmt_fetch($stmtSelect);
        mysqli_stmt_close($stmtSelect);

        $announcementPicPath =  $uploadDirAnnouncement . $image;

        // Unlink (delete) the announcement image file
        if (file_exists($announcementPicPath)) {
            unlink($announcementPicPath);
        }
    }

    // Prepare the SQL statement for deletion
    $sqlDelete = "DELETE FROM `announcements` WHERE id = ?";
    $stmtDelete = mysqli_prepare($conn, $sqlDelete);

    if ($stmtDelete) {
        // Bind the parameter
        mysqli_stmt_bind_param($stmtDelete, "i", $id);

        // Execute the statement
        mysqli_stmt_execute($stmtDelete);

        // Check if the deletion was successful
        if (mysqli_stmt_affected_rows($stmtDelete) > 0) {
            $response['success'] = true;
            $response['message'] = 'Announcement deleted successfully';
        } else {
            $response['success'] = false;
            $response['message'] = 'Data not deleted';
        }

        // Close the statement
        mysqli_stmt_close($stmtDelete);
    } else {
        $response['success'] = false;
        $response['message'] = 'Failed: ' . mysqli_error($conn);
    }
} else {
    $response['success'] = false;
    $response['message'] = 'Invalid request.';
}

// Close the database connection
mysqli_close($conn);

// Send the JSON response
echo json_encode($response);
?>
