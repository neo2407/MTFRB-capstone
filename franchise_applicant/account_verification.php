<?php
session_start(); // Start session if needed
include "../include/db_conn.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';
require '../phpmailer/src/Exception.php';

$email = "";
$first_name = "";
$last_name = "";
$m_name = "";
$contact_num = "";

$errors = array();

// Function to send email
function sendEmail($recipient, $subject, $body, &$errorMsg) {
    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mtfrblucban2024@gmail.com';  
        $mail->Password = 'uway leyk zkah dcda';  
        $mail->SMTPSecure = 'ssl';
        $mail->Port =  465;;

         $mail->setFrom('mtfrblucban2024@gmail.com', 'MTFRB Lucban Office');
        $mail->addAddress($recipient);
        $mail->addBCC('mtfrblucban2024@gmail.com', 'MTFRB Lucban Office');  

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        // Check if the error message indicates an invalid recipient
        if (strpos($mail->ErrorInfo, 'Address not found') !== false || 
            strpos($mail->ErrorInfo, 'Invalid address') !== false) {
            $errorMsg = "The email address does not exist or cannot receive messages.";
        } else {
            $errorMsg = "Failed to send verification code! Please check the email address.";
        }
        return false;
    }
}

/**function isEmailValid($email, &$errorMsg) {
    $apiKey = '3ea72a3ec6481d3d60f2d1d7ad30f066';  //  Mailboxlayer API key
    $url = "http://apilayer.net/api/check?access_key=$apiKey&email=" . urlencode($email) . "&smtp=1&format=1";

    $response = file_get_contents($url);
    if ($response === FALSE) {
        $errorMsg = "Failed to validate the email address.";
        return false;
    }

    $data = json_decode($response, true);

    // Check if the email is invalid or fake based on API response
    if (!$data['format_valid'] || !$data['smtp_check']) {
        $errorMsg = "The email address you entered is fake or invalid.";
        return false;
    }
    
    return true;
}**/ 

date_default_timezone_set('Asia/Manila');

// User Registration and Email Verification
if (isset($_POST['signup'])) {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $m_name = mysqli_real_escape_string($conn, $_POST['m_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact_num = mysqli_real_escape_string($conn, $_POST['contact_num']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
    $account_created_at = date("m/d/Y h:i A");
    $new_acc = 1;

    
   //$errorMsg = "";  // To store email validation errors

    /* Validate email using Mailboxlayer API
    if (!isEmailValid($email, $errorMsg)) {
        $_SESSION['status'] = $errorMsg;
        $_SESSION['status_code'] = "error";
        header('Location: account-registration.php');
        exit();
    }*/

       // Email validation
       if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['status'] = "Invalid email address!";
        $_SESSION['status_code'] = "error";
        // Store input values in the session to repopulate
        $_SESSION['form_data'] = $_POST;
        header('Location: account-registration.php');
        exit();
    }

        // Validate: Check if it's exactly 11 characters and only numbers
       if (!preg_match('/^\d{11}$/', $contact_num)) {
        $_SESSION['status'] = "Invalid contact number! It must be exactly 11 digits.";
        $_SESSION['status_code'] = "error";
        // Store input values in the session to repopulate
        $_SESSION['form_data'] = $_POST;
        header('Location: account-registration.php');
        exit();
    }
    
    if ($password !== $cpassword) {
        //$errors['password'] = "Confirm password not matched!";
        $_SESSION['status'] = "Confirm password not matched!";
        $_SESSION['status_code'] = "error";
        // Store input values in the session to repopulate
        $_SESSION['form_data'] = $_POST;
        header('Location: account-registration.php');
        exit();
    }

     // Regular expression for password validation
    $passwordRegex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/";
    if ($password !== $passwordRegex) {
       
        // Validate password strength
        if (!preg_match($passwordRegex, $password)) {
            $_SESSION['status'] = "Password must be at least 8 characters long, contain uppercase, lowercase, and a number.";
            $_SESSION['status_code'] = "warning";
            // Store input values in the session to repopulate
             $_SESSION['form_data'] = $_POST;
            header("Location: account-registration.php");
            exit();
        }
    
    }
    
    $query = "SELECT * FROM applicants WHERE first_name = ? AND last_name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $first_name, $last_name);
    $stmt->execute();
    $resultName = $stmt->get_result();

    if ($resultName->num_rows > 0) {
        //$errors['name'] = "The name you have entered is already registered!";
        $_SESSION['status'] = "The name you have entered is already registered!";
        $_SESSION['status_code'] = "error";
        // Store input values in the session to repopulate
        $_SESSION['form_data'] = $_POST;
        header('Location: account-registration.php');
        exit();
    }
 

   // Array of tables to check
$tables = ['applicants', 'jan_operators', 'feb_operators', 'march_operators', 'apr_operators', 'may_operators', 'jun_operators', 'jul_operators', 'aug_operators', 'sep_operators', 'oct_operators'];

// Check if the email exists in the applicants table first
$query = "SELECT email FROM applicants WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {
    $_SESSION['status'] = "Email that you have entered is already registered!";
    $_SESSION['status_code'] = "error";
    $_SESSION['form_data'] = $_POST;
    header('Location: account-registration.php');
    exit();
}

// If not found in applicants, check other tables
foreach ($tables as $table) {
    $query = "SELECT email FROM $table WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $_SESSION['status'] = "Email that you have entered is already registered!";
        $_SESSION['status_code'] = "error";
        $_SESSION['form_data'] = $_POST;
        header('Location: account-registration.php');
        exit();
    }
}

    
    if (count($errors) === 0) {
        $encpass = password_hash($password, PASSWORD_BCRYPT);
        $code = rand(999999, 111111);
        $status = "notverified";
    
        $insert_data = "INSERT INTO applicants (first_name, last_name, m_name, contact_num, email, password, code, acc_status, account_created_at, new_acc) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_data);
        $acc_status = "notverified";
        $stmt->bind_param("sssssssssi", $first_name, $last_name, $m_name, $contact_num, $email, $encpass, $code, $acc_status, $account_created_at, $new_acc);
        $data_check = $stmt->execute();
    
        if ($data_check) {
            // Store the ID of the newly inserted applicant
            $applicant_id = $conn->insert_id;
            $_SESSION['id'] = $applicant_id; // Storing the ID in session
    
            $subject = "Email Verification Code";
            $message = "To complete your account verification, please enter the following one-time code (OTP) on our website: $code<br><br>
            If you didn't request this verification, please ignore this email.<br><br>
            Thank you!";


            $errorMsg = ""; // To hold any error message
    
            if (sendEmail($email, $subject, $message, $errorMsg)) {
                $_SESSION['info'] = "We've sent a verification code to your email - $email to activate your account";
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                $_SESSION['first_name'] = $first_name;
                $_SESSION['last_name'] = $last_name;
                $_SESSION['m_name'] = $m_name;
                $_SESSION['contact_num'] = $contact_num;
                header('Location: user-otp.php');
                exit();
            } else {
                $errors['otp-error'] = "Failed to send verification code! Please check the email address.";
            }
        } else {
            $errors['db-error'] = "Failed to insert data into database!";
        }
    }
}

// Verification Code Submission
if (isset($_POST['check'])) {
    $_SESSION['info'] = "";
    $otp_code = mysqli_real_escape_string($conn, $_POST['otp']);

    $check_code = "SELECT * FROM applicants WHERE code = ?";
    $stmt = $conn->prepare($check_code);
    $stmt->bind_param("i", $otp_code);
    $stmt->execute();
    $code_res = $stmt->get_result();

    if ($code_res->num_rows > 0) {
        $fetch_data = $code_res->fetch_assoc();
        $fetch_code = $fetch_data['code'];
        $email = $fetch_data['email'];
        $applicant_id = $fetch_data['id']; // Fetching applicant ID
        $code = 0;
        $status = 'verified';

        $update_otp = "UPDATE applicants SET code = ?, acc_status = ? WHERE email = ?";
        $stmt = $conn->prepare($update_otp);
        $stmt->bind_param("iss", $code, $status, $email);
        $update_res = $stmt->execute();

        if ($update_res) {
            // Store the applicant ID in session for further use
            $_SESSION['id'] = $applicant_id;
            $_SESSION['status'] = "Account Successfully Registered!";
            $_SESSION['status_code'] = "success";
            $_SESSION['email'] = $email;
            header('Location: franchiseApplication.php');
            exit();
        } else {
            $errors['otp-error'] = "Failed while updating code!";
        }
    } else {
        $errors['otp-error'] = "You've entered incorrect code!";
    }
}



// Login Validation
if (isset($_POST['continue'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    $check_email = "SELECT * FROM applicants WHERE email = '$email'";
    $res = mysqli_query($conn, $check_email);



    if (mysqli_num_rows($res) > 0) {
        $fetch = mysqli_fetch_assoc($res);
        $fetch_pass = $fetch['password'];
        $user_id = $fetch['id']; 
        $first_name = $fetch['first_name'];
        $last_name = $fetch['last_name'];  
        $m_name = $fetch['m_name'];
        $contact_num = $fetch['contact_num'];
        $acc_status = $fetch['acc_status']; // Fetch account status

        if ($acc_status !== 'verified') {
            $errors['continue'] = "Your account is currently Not Verified. Please enter the verification code sent your email upon account registration.";
        } else if(password_verify($password, $fetch_pass)) {
            $_SESSION['email'] = $email;
            $_SESSION['first_name'] = $first_name;
            $_SESSION['last_name'] = $last_name; // Store username in session
            $_SESSION['m_name'] = $m_name;
            $_SESSION['contact_num'] = $contact_num;
            

            // Optionally, log the successful login attempt here

            header('Location: franchiseApplication.php');
            exit();
        } else {
            $errors['continue'] = "Incorrect email or password!";
        }
    } else {
        $errors['continue'] = "It looks like your acccount is not yet registered";
    }

   
}

?>