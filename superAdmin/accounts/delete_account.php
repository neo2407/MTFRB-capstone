<?php
session_start();
include "../include/db_conn.php";

if (isset($_GET["id"])) {
    // Decode the ID from Base64 encoding
    $encoded_id = $_GET["id"];
    $id = base64_decode($encoded_id);

    // Validate the decoded ID
    if (filter_var($id, FILTER_VALIDATE_INT) === false) {
        $_SESSION['status'] = "Invalid ID.";
        $_SESSION['status_code'] = "error";
        header('Location: accounts.php');
        exit();
    }

    $upload_dir = '../../uploads/profile_pics/';

    // Retrieve account details
    $sqlSelect = "SELECT * FROM `accounts` WHERE id = ?";
    $stmtSelect = mysqli_prepare($conn, $sqlSelect);

    if ($stmtSelect) {
        mysqli_stmt_bind_param($stmtSelect, "i", $id);
        mysqli_stmt_execute($stmtSelect);
        $result = mysqli_stmt_get_result($stmtSelect);
        $accountDetails = mysqli_fetch_assoc($result);

        if ($accountDetails) {
            // Extract profile picture path
            $profile_picture = $accountDetails['profile_picture'];
            $profilePath = $upload_dir . $profile_picture;

            // Delete profile picture file if it exists
            if (file_exists($profilePath)) {
                unlink($profilePath);
            }

            // Insert account details into the deleted_accounts table
            $sqlInsertDeleted = "INSERT INTO `deleted_accounts` 
                (id, account_status, f_name, l_name, m_name, username, email, password, code, 
                job_position, created_at, account_type, profile_picture, contact_number, address, deleted_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

            $stmtInsertDeleted = mysqli_prepare($conn, $sqlInsertDeleted);

            if ($stmtInsertDeleted) {
                mysqli_stmt_bind_param(
                    $stmtInsertDeleted,
                    "issssssisssssss",
                    $accountDetails['id'],
                    $accountDetails['account_status'],
                    $accountDetails['f_name'],
                    $accountDetails['l_name'],
                    $accountDetails['m_name'],
                    $accountDetails['username'],
                    $accountDetails['email'],
                    $accountDetails['password'],
                    $accountDetails['code'],
                    $accountDetails['job_position'],
                    $accountDetails['created_at'],
                    $accountDetails['account_type'],
                    $accountDetails['profile_picture'],
                    $accountDetails['contact_number'],
                    $accountDetails['address']
                );

                mysqli_stmt_execute($stmtInsertDeleted);
                mysqli_stmt_close($stmtInsertDeleted);
            } else {
                $_SESSION['status'] = "Failed to log deleted account: " . mysqli_error($conn);
                $_SESSION['status_code'] = "error";
                header('Location: accounts.php');
                exit();
            }

            // Delete the account from the accounts table
            $sqlDelete = "DELETE FROM `accounts` WHERE id = ?";
            $stmtDelete = mysqli_prepare($conn, $sqlDelete);

            if ($stmtDelete) {
                mysqli_stmt_bind_param($stmtDelete, "i", $id);
                mysqli_stmt_execute($stmtDelete);

                if (mysqli_stmt_affected_rows($stmtDelete) > 0) {
                    // Log the action in logs_history table
                        $user_id = $_SESSION['user_id'];
                        $account_type = $_SESSION['account_type'];
                        $username = $_SESSION['username'];
                        $date_time = date('Y-m-d H:i:s');
                        $action = "Account deleted : $id.";
                        $franchise_no = isset($_SESSION['franchise_no']) ? $_SESSION['franchise_no'] : null;
            
                        $logQuery = "INSERT INTO logs_history (user_id, action, franchise_no, date_time, account_type, username) VALUES (?, ?, ?, ?, ?, ?)";
                        if ($logStmt = $conn->prepare($logQuery)) {
                            $logStmt->bind_param("isssss", $user_id, $action, $franchise_no, $date_time, $account_type, $username);
                            $logStmt->execute();
                            $logStmt->close();
                        }
                    $_SESSION['status'] = "Account deleted successfully";
                    $_SESSION['status_code'] = "success";
                } else {
                    $_SESSION['status'] = "Account not deleted";
                    $_SESSION['status_code'] = "error";
                }

                mysqli_stmt_close($stmtDelete);
            } else {
                $_SESSION['status'] = "Failed to prepare delete statement: " . mysqli_error($conn);
                $_SESSION['status_code'] = "error";
                header('Location: accounts.php');
                exit();
            }
        } else {
            $_SESSION['status'] = "Account not found.";
            $_SESSION['status_code'] = "error";
        }

        mysqli_stmt_close($stmtSelect);
    } else {
        $_SESSION['status'] = "Failed to retrieve account details: " . mysqli_error($conn);
        $_SESSION['status_code'] = "error";
    }

    header('Location: accounts.php');
    exit();
} else {
    $_SESSION['status'] = "Invalid request.";
    $_SESSION['status_code'] = "error";
    header('Location: accounts.php');
    exit();
}

// Close the database connection
mysqli_close($conn);
?>
