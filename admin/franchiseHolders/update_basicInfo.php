<?php
session_start(); // Start the session
include "../include/db_conn.php";

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST["submit"])) {
    $id = $_POST['id'];
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $m_name = trim($_POST['m_name'] ?? '');
    $b_date = trim($_POST['b_date'] ?? '');
    $age = trim($_POST['age'] ?? '0');
    $address = trim($_POST['address'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $sex = trim($_POST['sex'] ?? '');
    $contact_num = trim($_POST['contact_num'] ?? '');
    $driver1_name = trim($_POST['driver1_name'] ?? '');
    $driver2_name = trim($_POST['driver2_name'] ?? '');
    $tricColor = trim($_POST['tricColor'] ?? '');
    $tricType = trim($_POST['tricType'] ?? '');
    $toda = trim($_POST['toda'] ?? '');
    $dtOfrenewal = trim($_POST['dtOfrenewal'] ?? '');
    $license_no = trim($_POST['license_no'] ?? '');
    $license_class = trim($_POST['license_class'] ?? '');
    $license_exp = trim($_POST['license_exp'] ?? '');

    // Fetch existing data
    $updateData = "SELECT * FROM `jan_operators` WHERE id = ? UNION 
                   SELECT * FROM `feb_operators` WHERE id = ? UNION 
                   SELECT * FROM `march_operators` WHERE id = ? UNION 
                   SELECT * FROM `apr_operators` WHERE id = ? UNION 
                   SELECT * FROM `may_operators` WHERE id = ? UNION 
                   SELECT * FROM `jun_operators` WHERE id = ? UNION 
                   SELECT * FROM `jul_operators` WHERE id = ? UNION 
                   SELECT * FROM `aug_operators` WHERE id = ? UNION 
                   SELECT * FROM `sep_operators` WHERE id = ? UNION 
                   SELECT * FROM `oct_operators` WHERE id = ?";

    $stmt = $conn->prepare($updateData);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("iiiiiiiiii", $id, $id, $id, $id, $id, $id, $id, $id, $id, $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    // Variables to track changes
    $changes = false;

    // Check for changes
    if ($result && (
        $last_name !== $result['last_name'] || $first_name !== $result['first_name'] ||
        $m_name !== $result['m_name'] || $age !== $result['age'] || $contact_num !== $result['contact_num'] || 
        $email !== $result['email'] || $address !== $result['address'] || 
        $driver1_name !== $result['driver1_name'] || $driver2_name !== $result['driver2_name'] || 
        $tricColor !== $result['tricColor'] || $tricType !== $result['tricType'] || 
        $toda !== $result['toda'] || $dtOfrenewal !== $result['dtOfrenewal'] || 
        $license_no !== $result['license_no'] || $license_class !== $result['license_class'] || $license_exp !== $result['license_exp']
    )) {
        $changes = true;
    }

    if ($changes) {
        $tables = ['jan_operators', 'feb_operators', 'march_operators', 'apr_operators', 'may_operators', 'jun_operators', 'jul_operators', 'aug_operators', 'sep_operators', 'oct_operators'];
        $updateSuccessful = false;

        foreach ($tables as $table) {
            $query = "UPDATE $table SET last_name=?, first_name=?, m_name=?, age=?, contact_num=?, email=?, address=?, driver1_name=?, driver2_name=?, tricColor=?, tricType=?, toda=?, dtOfrenewal=?, license_no=?, license_class=?, license_exp=? WHERE id=?";
            $stmt = $conn->prepare($query);

            if ($stmt) {
                $stmt->bind_param("ssssssssssssssssi", $last_name, $first_name, $m_name, $age, $contact_num, $email, $address, $driver1_name, $driver2_name, $tricColor, $tricType, $toda, $dtOfrenewal, $license_no,  $license_class, $license_exp, $id);
                $updateSuccessful = $stmt->execute() || $updateSuccessful;
                $stmt->close();
            }
        }

        $_SESSION['status'] = $updateSuccessful ? "Tricycle Operator Information Updated Successfully" : "Update Failed";
        $_SESSION['status_code'] = $updateSuccessful ? "success" : "error";
    } else {
        $_SESSION['status'] = "No changes detected";
        $_SESSION['status_code'] = "info";
    }

    header("Location: edit_operatorDash.php?id=$id");
    exit;
}
?>
