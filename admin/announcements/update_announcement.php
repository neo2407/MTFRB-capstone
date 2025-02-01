<?php
session_start(); // Start the session
include "../../include/db_conn.php";

if (isset($_POST["submit"])) {
    $edit_id = $_POST['id'];
    $title = isset($_POST['title']) ? trim(mysqli_real_escape_string($conn, $_POST['title'])) : '';
    $content = isset($_POST['content']) ? trim(mysqli_real_escape_string($conn, $_POST['content'])) : '';
    $announcement_pic = $_FILES['image']['name'];

    // Fetch existing data
    $updateAnnouncementQuery = "SELECT * FROM announcements WHERE id = '$edit_id'";
    $updateAnnouncementRun = mysqli_query($conn, $updateAnnouncementQuery);
    $announcement_row = mysqli_fetch_assoc($updateAnnouncementRun);

    $announcementPath = $announcement_row['image'];

    // Flag to track changes
    $changes = false;

    // Handle announcement image upload if a new file is uploaded
    if (!empty($announcement_pic)) {
        $hashedAnnouncement = md5(time() . $announcement_pic) . '.' . pathinfo($announcement_pic, PATHINFO_EXTENSION);
        $newAnnouncementPath = "../../uploads/announcements/" . $hashedAnnouncement;

        if (file_exists("../../uploads/announcements/" . $announcement_row['image'])) {
            unlink("../../uploads/announcements/" . $announcement_row['image']);
        }

        move_uploaded_file($_FILES['image']['tmp_name'], $newAnnouncementPath);
        $announcementPath = $hashedAnnouncement;
        $changes = true;
    }

    // Check for changes in title, content, or image
    if ($title !== $announcement_row['title'] || $content !== $announcement_row['content'] || $changes) {
        // Update query
        $sql = "UPDATE announcements SET title=?, content=?, image=? WHERE id = ?";

        // Prepare the statement
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Prepare failed: " . htmlspecialchars($conn->error));
        }

        // Bind parameters
        $stmt->bind_param('sssi', $title, $content, $announcementPath, $edit_id);

        // Execute the statement
        $result = $stmt->execute();

        // Log changes
        if ($result) {
            // Prepare log details
            $updatedFields = [];
            if ($title !== $announcement_row['title']) {
                $updatedFields[] = "Title changed from '{$announcement_row['title']}' to '$title'";
            }
            if ($content !== $announcement_row['content']) {
                $updatedFields[] = "Content changed from '{$announcement_row['content']}' to '$content'";
            }
            if ($changes) {
                $updatedFields[] = "Image updated";
            }

            $action = "Updated announcement ( " . implode(', ', $updatedFields);
            $user_id = $_SESSION['user_id'];
            $account_type = $_SESSION['account_type'];
            $username = $_SESSION['username'];
            $date_time = date('Y-m-d H:i:s');
            $franchise_no = isset($_SESSION['franchise_no']) ? $_SESSION['franchise_no'] : null;

            $logQuery = "INSERT INTO logs_history (user_id, action, franchise_no, date_time, account_type, username) VALUES (?, ?, ?, ?, ?, ?)";
            $logStmt = $conn->prepare($logQuery);

            if ($logStmt) {
                $logStmt->bind_param('isssss', $user_id, $action, $franchise_no, $date_time, $account_type, $username);
                $logStmt->execute();
                $logStmt->close();
            }

            $_SESSION['status'] = "Announcement Updated Successfully!";
            $_SESSION['status_code'] = "success";
        } else {
            $_SESSION['status'] = "Announcement not updated";
            $_SESSION['status_code'] = "error";
        }

        // Close the statement
        $stmt->close();
    } else {
        $_SESSION['status'] = "No changes detected";
        $_SESSION['status_code'] = "info";
    }

    header("Location: announcements.php?id=$edit_id");
    exit();
}
?>
