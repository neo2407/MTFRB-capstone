<?php
session_start(); // Start session if needed
include "../include/db_conn.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';
require '../phpmailer/src/Exception.php';

$errors = array();

// Function to send email
function sendEmail($recipient, $subject, $body) {
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = 0; // Enable verbose debug output (0 for no output)
        $mail->isSMTP(); // Set mailer to use SMTP
        $mail->Host       = 'smtp.gmail.com'; // Specify main and backup SMTP servers
        $mail->SMTPAuth   = true; // Enable SMTP authentication
        $mail->Username   = 'websystem2024@gmail.com'; // SMTP username
        $mail->Password   = 'iuyq sdag qzrw ztxi'; // SMTP password
        $mail->SMTPSecure = 'ssl'; // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = 465; // TCP port to connect to

        //Recipients
        $mail->setFrom('websystem2024@gmail.com', 'MTFRB Lucban Office');
        $mail->addAddress($recipient); // Add a recipient

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}


// Set time zone
date_default_timezone_set('Asia/Manila');


// Login Validation
if (isset($_POST['login'])) {
    // Sanitize inputs
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    
    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM accounts WHERE email = ? ");
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        exit("Error preparing statement.");
    }
    
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    // Prepare logging details
    $login_status = 'failed';
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $user_id = null;
    $username = "Unknown User";
    $account_type = 'Unknown';
    $profile_picture = null;
    $login_time = date('Y-m-d H:i:s'); // Get current time in Asia/Manila timezone

        // Convert IPv6 loopback to IPv4
        if ($ip_address == '::1') {
            $ip_address = '127.0.0.1';
        }

    if ($res->num_rows > 0) {
        $fetch = $res->fetch_assoc();
        $fetch_pass = $fetch['password'];
        $user_id = $fetch['id'];
        $username = $fetch['username'];
        $account_type = $fetch['account_type'];
        $profile_picture = $fetch['profile_picture'];
        $account_status = $fetch['account_status']; 
        $l_name = $fetch['l_name']; 
        $f_name = $fetch['f_name']; 
        $m_name = $fetch['m_name']; 
        $address = $fetch['address']; 
        $job_position = $fetch['job_position']; 
        $account_status = $fetch['account_status']; 
        $contact_number = $fetch['contact_number']; 
   

        // Check if account is active
        if ($account_status !== 'Active') {
            $errors['email'] = "Your account is currently deactivated. Request  for account activation to the Super Admin.";
    
        } else if($account_type !== 'Admin'){
            $errors['email'] = "Your account type is not Admin, you do not have permission to login";
        
        
        }else if (password_verify($password, $fetch_pass)) {
            // Store session details upon successful login
            $_SESSION['f_name'] = $f_name;
            $_SESSION['l_name'] = $l_name;
            $_SESSION['m_name'] = $m_name;
            $_SESSION['email'] = $email;
            $_SESSION['contact_number'] = $contact_number;
            $_SESSION['username'] = $username;
            $_SESSION['job_position'] = $job_position;
            $_SESSION['account_type'] = $account_type;
            $_SESSION['account_status'] = $account_status;
            $_SESSION['profile_picture'] = $profile_picture;
            $_SESSION['address'] = $address;
            $_SESSION['user_id'] = $user_id;
            $login_status = 'success';
            
            // Insert log for successful login
            $stmt = $conn->prepare("
                INSERT INTO logs (user_id, username, email, account_type, login_status, ip_address, user_agent, logout_time, login_time)
                VALUES (?, ?, ?, ?, ?, ?, ?, 'Active' , ?)
            ");
            if (!$stmt) {
                error_log("Prepare failed: " . $conn->error);
                exit("Error preparing statement.");
            }
            $stmt->bind_param("isssssss", $user_id, $username, $email, $account_type, $login_status, $ip_address, $user_agent, $login_time);
            $stmt->execute();

            // Redirect to dashboard
            header('Location: dashboard/adminDash.php');
            exit();
        } else {
            $errors['email'] = "Incorrect email or password!";
        }
    } else {
        $errors['email'] = "It looks like you do not have an account to login! Ask the Super Admin to create you an account.";
    }

   // Insert log for failed login
    $stmt = $conn->prepare("
        INSERT INTO logs (user_id, username, email, account_type, login_status, ip_address, user_agent, login_time, logout_time)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Failed')
    ");
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        exit("Error preparing statement.");
    }
    
    // Note: No need to pass `logout_time` here, as it is explicitly set to 'Failed' in the SQL
    $stmt->bind_param("isssssss", $user_id, $username, $email, $account_type, $login_status, $ip_address, $user_agent, $login_time);
    $stmt->execute();
}




// Password Reset Request
if (isset($_POST['check-email'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $check_email = "SELECT * FROM accounts WHERE email='$email'";
    $run_sql = mysqli_query($conn, $check_email);

    if (mysqli_num_rows($run_sql) > 0) {
        $code = rand(999999, 111111);
        $insert_code = "UPDATE accounts SET code = $code WHERE email = '$email'";
        $run_query =  mysqli_query($conn, $insert_code);

        if ($run_query) {
            $subject = "Password Reset Code";
            $message = "Your password reset code is $code. <br><br>
            If you didn't request this verification, please ignore this email.<br><br>
            Thank you!";

            if (sendEmail($email, $subject, $message)) {
                $_SESSION['info'] = "We've sent a password reset OTP to your email - $email";
                $_SESSION['email'] = $email;
                header('Location: reset-code.php');
                exit();
            } else {
                $errors['otp-error'] = "Failed while sending code!";
            }
        } else {
            $errors['db-error'] = "Something went wrong!";
        }
    } else {
        $errors['email'] = "This email address does not exist!";
    }
}


// Password Reset Verification
if (isset($_POST['check-reset-otp'])) {
    $_SESSION['info'] = "";
    $otp_code = mysqli_real_escape_string($conn, $_POST['otp']);
    $check_code = "SELECT * FROM accounts WHERE code = $otp_code";
    $code_res = mysqli_query($conn, $check_code);

    if (mysqli_num_rows($code_res) > 0) {
        $fetch_data = mysqli_fetch_assoc($code_res);
        $email = $fetch_data['email'];
        $_SESSION['email'] = $email;
        $_SESSION['info'] = "Please create a new password .";
        header('Location: new-password.php');
        exit();
    } else {
        $errors['otp-error'] = "You've entered incorrect code!";
    }
}

// Password Change
if (isset($_POST['change-password'])) {
    $_SESSION['info'] = "";
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);

    // Password strength regex
    $password_regex = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8,}$/';

    if (!preg_match($password_regex, $password)) {
        $errors['password'] = "Password must be at least 8 characters, include uppercase, lowercase, and numbers.";
    } elseif ($password !== $cpassword) {
        $errors['password'] = "Confirm password not matched!";
    } else {
        $code = 0;
        $email = $_SESSION['email'];
        $encpass = password_hash($password, PASSWORD_BCRYPT);
        $update_pass = "UPDATE accounts SET code = $code, password = '$encpass' WHERE email = '$email'";
        $run_query = mysqli_query($conn, $update_pass);

        if ($run_query) {
            $_SESSION['info'] = "Your password has been changed. You can now login with your new password.";
            header('Location: password-changed.php');
            exit();
        } else {
            $errors['db-error'] = "Failed to change your password!";
        }
    }
}

// If login now button clicked
if (isset($_POST['login-now'])) {
    header('Location: admin_login.php');
    exit();
}

?>
