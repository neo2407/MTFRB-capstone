<?php
session_start(); // Start the session
include "../include/db_conn.php";

if (isset($_POST["submit"])) {
    // Decode the ID if it's Base64 encoded
    $encoded_id = $_POST['id'];
    $id = base64_decode($encoded_id);

    // Validate the decoded ID to ensure it's an integer
    if (filter_var($id, FILTER_VALIDATE_INT) === false) {
        $_SESSION['status'] = "Invalid ID.";
        $_SESSION['status_code'] = "error";
        header("Location: edit_account.php?id=" . $encoded_id);
        exit();
    }

    $f_name = mysqli_real_escape_string($conn, $_POST['f_name']);
    $l_name = mysqli_real_escape_string($conn, $_POST['l_name']);
    $m_name = mysqli_real_escape_string($conn, $_POST['m_name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $job_position = mysqli_real_escape_string($conn, $_POST['job_position']);
    $account_type = mysqli_real_escape_string($conn, $_POST['account_type']);
    $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $account_status = mysqli_real_escape_string($conn, $_POST['account_status']);
    $editProfile = $_FILES['profile_picture']['name'];

    // Fetch existing data
    $updateData = "SELECT * FROM `accounts` WHERE id = $id";
    $update_run = mysqli_query($conn, $updateData);
    if (!$update_run) {
        $_SESSION['status'] = "Failed to fetch existing data.";
        $_SESSION['status_code'] = "error";
        header("Location: edit_account.php?id=" . $encoded_id);
        exit();
    }

    $result = mysqli_fetch_assoc($update_run);

    // Check if the email is changing
    if ($email !== $result['email']) {
        // Check if the new email already exists in the database
        $emailCheck = "SELECT id FROM accounts WHERE email = ?";
        $stmt = $conn->prepare($emailCheck);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            // If email already exists, set session message and redirect
            $_SESSION['status'] = "Email is already in use.";
            $_SESSION['status_code'] = "error";
            header("Location: edit_account.php?id=" . $encoded_id);
            exit();
        }
        $stmt->close();
    }

    // Proceed with the rest of the fields and update as usual
    $profilePath = $result['profile_picture'];
    $changes = false;
    $changeLog = [];

    // Handle profile upload if a new file is uploaded
    if (!empty($_FILES['profile_picture']['name'])) {
        $hashedProfile = md5(time() . $editProfile) . '.' . pathinfo($editProfile, PATHINFO_EXTENSION);
        $profilePath = "../../uploads/profile_pics/" . $hashedProfile;
        if (file_exists("../../uploads/profile_pics/" . $result['profile_picture'])) {
            unlink("../../uploads/profile_pics/" . $result['profile_picture']);
        }
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profilePath);
        $profilePath = $hashedProfile; // Store only the filename
        $changes = true;
        $changeLog[] = "Profile picture updated.";
    }

    // Check for changes and add to the change log
    if ($f_name !== $result['f_name']) {
        $changeLog[] = "First name changed from " . $result['f_name'] . " to " . $f_name;
        $changes = true;
    }
    if ($l_name !== $result['l_name']) {
        $changeLog[] = "Last name changed from " . $result['l_name'] . " to " . $l_name;
        $changes = true;
    }
    if ($m_name !== $result['m_name']) {
        $changeLog[] = "Middle name changed from " . $result['m_name'] . " to " . $m_name;
        $changes = true;
    }
    if ($username !== $result['username']) {
        $changeLog[] = "Username changed from " . $result['username'] . " to " . $username;
        $changes = true;
    }
    if ($email !== $result['email']) {
        $changeLog[] = "Email changed from " . $result['email'] . " to " . $email;
        $changes = true;
    }
    if ($job_position !== $result['job_position']) {
        $changeLog[] = "Job position changed from " . $result['job_position'] . " to " . $job_position;
        $changes = true;
    }
    if ($address !== $result['address']) {
        $changeLog[] = "Address changed from " . $result['address'] . " to " . $address;
        $changes = true;
    }
    if ($contact_number !== $result['contact_number']) {
        $changeLog[] = "Contact number changed from " . $result['contact_number'] . " to " . $contact_number;
        $changes = true;
    }
    if ($account_type !== $result['account_type']) {
        $changeLog[] = "Account type changed from " . $result['account_type'] . " to " . $account_type;
        $changes = true;
    }
    if ($account_status !== $result['account_status']) {
        $changeLog[] = "Account status changed from " . $result['account_status'] . " to " . $account_status;
        $changes = true;
    }

    if ($changes) {
        // Perform the update query
        $updateAccount = "UPDATE accounts SET f_name=?, l_name=?, m_name=?, username=?, email=?, job_position=?, 
                        account_type=?, contact_number=?, `address`=?, profile_picture=?, account_type=?, account_status=? WHERE id=?";

        // Prepare the statement
        $stmt = $conn->prepare($updateAccount);

        // Bind parameters
        $stmt->bind_param('ssssssssssssi', $f_name, $l_name, $m_name, $username, $email, $job_position, 
                        $account_type, $contact_number, $address, $profilePath, $account_type, $account_status, $id);

        // Execute the statement
        $result = $stmt->execute();

        // Log the changes in logs_history table
        $user_id = $_SESSION['user_id'];
        $account_type = $_SESSION['account_type'];
        $username = $_SESSION['username'];
        $date_time = date('Y-m-d H:i:s');
        $action = "Account updated for ID $id. Changes: " . implode(", ", $changeLog);
        $franchise_no = isset($_SESSION['franchise_no']) ? $_SESSION['franchise_no'] : null;

        $logQuery = "INSERT INTO logs_history (user_id, action, franchise_no, date_time, account_type, username) VALUES (?, ?, ?, ?, ?, ?)";
        if ($logStmt = $conn->prepare($logQuery)) {
            $logStmt->bind_param("isssss", $user_id, $action, $franchise_no, $date_time, $account_type, $username);
            $logStmt->execute();
            $logStmt->close();
        }

        // Check the result and set session status
        if ($result) {
            $_SESSION['status'] = "Account Information Updated Successfully!";
            $_SESSION['status_code'] = "success";
        } else {
            $_SESSION['status'] = "Data not updated";
            $_SESSION['status_code'] = "error";
        }

        // Close the statement
        $stmt->close();
    } else {
        $_SESSION['status'] = "No changes detected";
        $_SESSION['status_code'] = "info";
    }

    header("Location: edit_account.php?id=" . $encoded_id);
    exit();
}
?>
