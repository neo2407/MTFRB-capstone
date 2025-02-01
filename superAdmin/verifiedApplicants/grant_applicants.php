<?php
// Function to generate the next custom primary key
if (!function_exists('getTFno')) {
    function getTFno($conn, $table) {
        // Ensure $table is properly escaped to prevent SQL injection
        $table = $conn->real_escape_string($table);

        $sql = "SELECT MAX(id) as max_id FROM $table";
        $result = $conn->query($sql);
        if ($result === FALSE) {
            die("Query failed: " . $conn->error);
        }
        
        $row = $result->fetch_assoc();
        $max_id = $row['max_id'];

        // If the table is empty, start with the base value (10)
        if ($max_id === null) {
            return 10;
        }

        // Increment the max ID by 10
        return $max_id + 10;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include "../../include/db_conn.php";

    // Set the Content-Type header to application/json
    header('Content-Type: application/json');

    $selected_applicants = isset($_POST['selected_applicants']) ? $_POST['selected_applicants'] : [];
    $destination_table = isset($_POST['destination_table']) ? $_POST['destination_table'] : '';

    if (!empty($selected_applicants) && !empty($destination_table)) {
        $conn->begin_transaction();
        try {
            foreach ($selected_applicants as $id) {
                // Retrieve the applicant's data from the source table
                $select_sql = "SELECT interviewStatus, paymentStatus, password, code, applicationDate, first_name, last_name, m_name, suffix, 
                                contact_num, email, sex, age, b_date, address, tricColor, tricType, toda, driver1_name, driver2_name, 
                                operatorsPic, toda_cert, valid_id, sedula, brgy_clr, driversPic1, driversPic2, license, med_res, cr, `or`, 
                                tricyclePics, tric_insp, deedSale, interview_sched 
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

                    // Check conditions before granting a franchise
                    if ($interviewStatus !== 'Done' || $paymentStatus !== 'Paid') {
                        echo json_encode([
                            'status' => 'warning', 
                            'message' => "All selected applicants must have their Interview Status as 'Done' and Payment Status as 'Paid' before granting a franchise."
                        ]);
                        exit; // Ensure no further output is sent
                    }

                    // Generate a unique TF number or get it based on the destination table
                    $TFno = getTFno($conn, $destination_table);

                    // Prepare data for insertion
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
                    $age = $conn->real_escape_string($row['age']);
                    $b_date = $conn->real_escape_string($row['b_date']);
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
                    $med_res = $conn->real_escape_string($row['med_res']);
                    $cr = $conn->real_escape_string($row['cr']);
                    $or = $conn->real_escape_string($row['or']);
                    $tricyclePics = $conn->real_escape_string($row['tricyclePics']);
                    $tric_insp = $conn->real_escape_string($row['tric_insp']);
                    $deedSale = $conn->real_escape_string($row['deedSale']);
                    $interview_sched = $conn->real_escape_string($row['interview_sched']);

                    // Insert data into the destination table
                    $insert_sql = "INSERT INTO $destination_table (id, password, code, applicationDate, first_name, last_name, m_name, suffix, 
                                    contact_num, email, sex, age, b_date, address, tricColor, tricType, toda, driver1_name, driver2_name, 
                                    operatorsPic, toda_cert, valid_id, sedula, brgy_clr, driversPic1, driversPic2, license, med_res, cr, `or`, 
                                    tricyclePics, tric_insp, deedSale, interview_sched) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($insert_sql);
                    $stmt->bind_param('issssssssssissssssssssssssssssssss', 
                        $TFno, $password, $code, $applicationDate, $first_name, $last_name, $m_name, $suffix, $contact_num, $email, $sex, 
                        $age, $b_date, $address, $tricColor, $tricType, $toda, $driver1_name, $driver2_name, $operatorsPic, $toda_cert, 
                        $valid_id, $sedula, $brgy_clr, $driversPic1, $driversPic2, $license, $med_res, $cr, $or, $tricyclePics, $tric_insp, 
                        $deedSale, $interview_sched
                    );

                    if (!$stmt->execute()) {
                        throw new Exception("Failed to insert applicant data into $destination_table: " . $stmt->error);
                    }

                    // Delete the applicant's data from the source table
                    $delete_sql = "DELETE FROM applicants WHERE id = ?";
                    $stmt = $conn->prepare($delete_sql);
                    $stmt->bind_param('i', $id);

                    if (!$stmt->execute()) {
                        throw new Exception("Failed to delete applicant data from the applicants table: " . $stmt->error);
                    }
                } else {
                    throw new Exception("Failed to retrieve applicant data for ID: $id");
                }
            }
            // Commit the transaction
            $conn->commit();
            echo json_encode([
                'status' => 'success',
                'message' => "Applicant/s granted a franchise successfully."
            ]);
        } catch (Exception $e) {
            // Rollback the transaction in case of an error
            $conn->rollback();
            echo json_encode([
                'status' => 'error',
                'message' => "Error: " . $e->getMessage()
            ]);
        } finally {
            $stmt->close();
            $conn->close();
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => "No applicants selected or destination table not provided."
        ]);
    }
}
?>