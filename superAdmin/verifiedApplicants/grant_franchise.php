<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "../../include/db_conn.php";
    header('Content-Type: application/json');

    $data = json_decode(file_get_contents("php://input"), true);
    
    $TFno = $data['TFno'] ?? null;
    $target_table = $data['targetTable'] ?? null;
    $selected_applicants = $data['selectedApplicantIds'] ?? [];
    $expDate = $data['expDate'];
    $dayBan = $data['dayBan'];

    // Validate input data
    if (!$TFno || !$target_table || empty($selected_applicants)) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required data.']);
        exit;
    }

    try {
        foreach ($selected_applicants as $id) {
            // Retrieve the applicant's data from the source table
            $select_sql = "SELECT interviewStatus, paymentStatus, password, code, applicationDate, first_name, last_name, m_name, suffix, 
                            contact_num, email, sex, b_date, age, address, tricColor, tricType, toda, driver1_name, driver2_name, 
                            operatorsPic, toda_cert, valid_id, sedula, brgy_clr, driversPic1, driversPic2, license, license_no, license_class, license_exp, med_res, cr, `or`, 
                            tricyclePics, tric_insp, deedSale, interview_sched,  nature, amount, paymentDate, order_payment_Image, orderId
                            FROM applicants 
                            WHERE id = ?";
            $stmt = $conn->prepare($select_sql);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
        
                $interviewStatus = $row['interviewStatus'];
                $paymentStatus = $row['paymentStatus'];
                $amount = $row['amount'];
                $nature = $row['nature'];
                $orderId = $row['orderId'];
                $paymentDate = $row['paymentDate'];
                $order_payment_Image = $row['order_payment_Image'];

                // Check conditions before granting a franchise
                if ($interviewStatus !== 'Done' || $paymentStatus !== 'Paid') {
                    echo json_encode([ 
                        'status' => 'warning', 
                        'message' => "Applicant must have their Interview Status as 'Done' and Payment Status as 'Paid' before granting a franchise." 
                    ]);
                    exit;
                }

                // Prepare data for insertion into the destination table
                $password = $conn->real_escape_string($row['password']);
                $code = $conn->real_escape_string($row['code']);
                $applicationDate = $conn->real_escape_string($row['applicationDate']);
                $first_name = $conn->real_escape_string($row['first_name']);
                $last_name = $conn->real_escape_string($row['last_name']);
                $m_name = $conn->real_escape_string($row['m_name']);
                $suffix = $conn->real_escape_string($row['suffix']);
                $contact_num = $conn->real_escape_string($row['contact_num']);
                $email = $conn->real_escape_string($row['email']);
                $sex = $conn->real_escape_string($row['sex']);
                $b_date = $conn->real_escape_string($row['b_date']);
                $age = $conn->real_escape_string($row['age']);
                $address = $conn->real_escape_string($row['address']);
                $tricColor = $conn->real_escape_string($row['tricColor']);
                $tricType = $conn->real_escape_string($row['tricType']);
                $toda = $conn->real_escape_string($row['toda']);
                $driver1_name = $conn->real_escape_string($row['driver1_name']);
                $driver2_name = $conn->real_escape_string($row['driver2_name']);
                $operatorsPic = $conn->real_escape_string($row['operatorsPic']);
                $toda_cert = $conn->real_escape_string($row['toda_cert']);
                $valid_id = $conn->real_escape_string($row['valid_id']);
                $sedula = $conn->real_escape_string($row['sedula']);
                $brgy_clr = $conn->real_escape_string($row['brgy_clr']);
                $driversPic1 = $conn->real_escape_string($row['driversPic1']);
                $driversPic2 = $conn->real_escape_string($row['driversPic2']);
                $license = $conn->real_escape_string($row['license']);
                $license_no = $conn->real_escape_string($row['license_no']);
                $license_class = $conn->real_escape_string($row['license_class']);
                $license_exp = $conn->real_escape_string($row['license_exp']);
                $med_res = $conn->real_escape_string($row['med_res']);
                $cr = $conn->real_escape_string($row['cr']);
                $or = $conn->real_escape_string($row['or']);
                $tricyclePics = $conn->real_escape_string($row['tricyclePics']);
                $tric_insp = $conn->real_escape_string($row['tric_insp']);
                $deedSale = $conn->real_escape_string($row['deedSale']);
                $interview_sched = $conn->real_escape_string($row['interview_sched']);
    
                // Insert data into the destination table (e.g., franchise holders table)
                $insert_sql = "INSERT INTO $target_table (TFno, password, code, applicationDate, expDate, dayBan, first_name, last_name, m_name, suffix, 
                                contact_num, email, sex, b_date, age,  address, tricColor, tricType, toda, driver1_name, driver2_name, 
                                operatorsPic, toda_cert, valid_id, sedula, brgy_clr, driversPic1, driversPic2, license, license_no, license_class, license_exp, med_res, cr, `or`, 
                                tricyclePics, tric_insp, deedSale, interview_sched) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($insert_sql);
                if (!$stmt) {
                    throw new Exception("Error preparing statement: " . $conn->error);
                }
                $stmt->bind_param('isssssssssssssissssssssssssssssssssssss', 
                    $TFno, $password, $code, $applicationDate, $expDate, $dayBan, $first_name, $last_name, $m_name, $suffix, $contact_num, $email, $sex, $b_date,
                    $age,  $address, $tricColor, $tricType, $toda, $driver1_name, $driver2_name, $operatorsPic, $toda_cert, 
                    $valid_id, $sedula, $brgy_clr, $driversPic1, $driversPic2, $license, $license_no, $license_class, $license_exp, $med_res, $cr, $or, $tricyclePics, $tric_insp, 
                    $deedSale, $interview_sched
                );
                if (!$stmt->execute()) {
                    throw new Exception("Error executing insert statement: " . $stmt->error);
                }

                // Insert payment information into the franchise_fee table
                $insert_fee_sql = "INSERT INTO franchise_fee (orderId, TFno, paymentDate, amount, nature, order_payment_Image) 
                                   VALUES (?, ?, ?, ?, ?, ?)";
                $stmt_fee = $conn->prepare($insert_fee_sql);
                if (!$stmt_fee) {
                    throw new Exception("Error preparing fee statement: " . $conn->error);
                }
                $stmt_fee->bind_param('ssssss', $orderId, $TFno, $paymentDate, $amount, $nature, $order_payment_Image);
                if (!$stmt_fee->execute()) {
                    throw new Exception("Error executing fee insert statement: " . $stmt_fee->error);
                }

                // Optionally delete from the applicants table after successfully inserting into the target table
                $delete_sql = "DELETE FROM applicants WHERE id = ?";
                $delete_stmt = $conn->prepare($delete_sql);
                if (!$delete_stmt) {
                    throw new Exception("Error preparing delete statement: " . $conn->error);
                }
                $delete_stmt->bind_param('i', $id);
                $delete_stmt->execute();
            }
        }

       // Commit transaction
        $conn->commit();
        echo json_encode(['status' => 'success', 'message' => 'Franchise granted successfully.']);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
    } finally {
        $conn->close();
    }
}
?>
