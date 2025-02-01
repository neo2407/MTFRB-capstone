<?php
session_start();
require_once "../../include/db_conn.php";

// Function to log actions
function logAction($conn, $user_id, $action, $franchise_no = null) {
    $logQuery = "INSERT INTO logs_history (user_id, action, franchise_no, date_time, account_type, username) 
                 VALUES (?, ?, ?, NOW(), ?, ?)";
    
    if ($logStmt = $conn->prepare($logQuery)) {
        $logStmt->bind_param("issss", 
            $user_id,
            $action,
            $franchise_no,
            $_SESSION['account_type'],
            $_SESSION['username']
        );
        
        $result = $logStmt->execute();
        $logStmt->close();
        return $result;
    }
    return false;
}

// Function to get old data
function getOldData($conn, $id) {
    $query = "SELECT ticketNo, violationDate, violationType, TFno, penaltyCharged, 
              penaltyStatus, offenseType, enforcer 
              FROM violations WHERE id = ?";
    
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $oldData = $result->fetch_assoc();
        $stmt->close();
        return $oldData;
    }
    return null;
}

// Function to compare and format changes
function formatChanges($oldData, $newData) {
    $changes = [];
    $fields = [
        'ticketNo' => 'Ticket Number',
        'violationDate' => 'Violation Date',
        'violationType' => 'Violation Type',
        'TFno' => 'TF Number',
        'penaltyCharged' => 'Penalty Charged',
        'penaltyStatus' => 'Penalty Status',
        'offenseType' => 'Offense Type',
        'enforcer' => 'Enforcer'
    ];
    
    foreach ($fields as $field => $label) {
        if ($oldData[$field] != $newData[$field]) {
            $changes[] = "$label: {$oldData[$field]} → {$newData[$field]}";
        }
    }
    
    return !empty($changes) 
        ? "Changes made: " . implode(" | ", $changes)
        : "No changes were made to the data";
}

if (isset($_POST['submit'])) {
    try {
        // Validate session
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['account_type']) || !isset($_SESSION['username'])) {
            throw new Exception("Unauthorized access");
        }

        // Get old data before update
        $oldData = getOldData($conn, $_POST['id']);
        if (!$oldData) {
            throw new Exception("Could not retrieve original record");
        }

        // Prepare the update statement
        $updateQuery = "UPDATE violations SET 
            ticketNo = ?, 
            violationDate = ?, 
            violationType = ?, 
            TFno = ?, 
            penaltyCharged = ?, 
            penaltyStatus = ?, 
            offenseType = ?, 
            enforcer = ?
            WHERE id = ?";
            
        if ($stmt = $conn->prepare($updateQuery)) {
            // Create array of new data for comparison
            $newData = [
                'ticketNo' => $_POST['ticketNo'],
                'violationDate' => $_POST['violationDate'],
                'violationType' => $_POST['violationType'],
                'TFno' => $_POST['TFno'],
                'penaltyCharged' => $_POST['penaltyCharged'],
                'penaltyStatus' => $_POST['penaltyStatus'],
                'offenseType' => $_POST['offenseType'],
                'enforcer' => $_POST['enforcer']
            ];

            // Bind parameters
            $stmt->bind_param("ssssssssi",
                $newData['ticketNo'],
                $newData['violationDate'],
                $newData['violationType'],
                $newData['TFno'],
                $newData['penaltyCharged'],
                $newData['penaltyStatus'],
                $newData['offenseType'],
                $newData['enforcer'],
                $_POST['id']
            );
            
            // Execute the update
            if ($stmt->execute()) {
                // Format the changes for logging
                $changeLog = formatChanges($oldData, $newData);
                $action = "Updated violation record #{$_POST['ticketNo']} - " . $changeLog;
                $franchise_no = isset($_SESSION['franchise_no']) ? $_SESSION['franchise_no'] : null;
                
                if (logAction($conn, $_SESSION['user_id'], $action, $franchise_no)) {
                    $_SESSION['status'] = "Violators Information Updated Successfully";
                    $_SESSION['status_code'] = "success";
                } else {
                    $_SESSION['status'] = "Update successful but logging failed";
                    $_SESSION['status_code'] = "warning";
                }
            } else {
                throw new Exception("Failed to update violation record");
            }
            
            $stmt->close();
        } else {
            throw new Exception("Failed to prepare update statement");
        }
        
    } catch (Exception $e) {
        $_SESSION['status'] = "Error: " . $e->getMessage();
        $_SESSION['status_code'] = "error";
    }
    
    // Redirect regardless of outcome
    header("Location: edit_Violations.php?ticketNo=" . urlencode($_POST['ticketNo']));
    exit();
}

// Close the connection
mysqli_close($conn);
?>