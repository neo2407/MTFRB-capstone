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




// Login Validation
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    $check_email = "SELECT * FROM applicants WHERE email = '$email'";
    $res = mysqli_query($conn, $check_email);

    // Prepare logging details
    $login_status = 'failed';
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $user_id = null;
    $first_name = null;
    $last_name = null;
    $operatorsPic = null; // Initialize profile_pic variable

    if (mysqli_num_rows($res) > 0) {
        $fetch = mysqli_fetch_assoc($res);
        $fetch_pass = $fetch['password'];
        $user_id = $fetch['id']; // Assuming `id` is the primary key in the `applicants` table
        $first_name = $fetch['first_name'];
        $last_name = $fetch['last_name'];  // Assuming `username` is a field in the `applicants` table
        $operatorsPic = $fetch['operatorsPic']; // Fetch the profile picture URL

        if (password_verify($password, $fetch_pass)) {
            $_SESSION['email'] = $email;
            $_SESSION['first_name'] = $first_name;
            $_SESSION['last_name'] = $last_name; // Store username in session
            $_SESSION['operatorsPic'] = $operatorsPic; // Store profile picture in session
            $login_status = 'success'; // Update status to success

            // Optionally, log the successful login attempt here

            header('Location: dashboard/applicantDash.php');
            exit();
        } else {
            $errors['login'] = "Incorrect email or password!";
        }
    } else {
        $errors['login'] = "It looks like you do not have an account to login! Click the Register Link below to Apply for a Tricycle Franchise.";
    }

    // Optionally, log the failed login attempt here
}

// Password Reset Request
if (isset($_POST['check-email'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $check_email = "SELECT * FROM applicants WHERE email='$email'";
    $run_sql = mysqli_query($conn, $check_email);

    if (mysqli_num_rows($run_sql) > 0) {
        $code = rand(999999, 111111);
        $insert_code = "UPDATE applicants SET code = $code WHERE email = '$email'";
        $run_query =  mysqli_query($conn, $insert_code);

        if ($run_query) {
            $subject = "Password Reset Code";
            $message = "Your password reset code is $code";

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
    $check_code = "SELECT * FROM applicants WHERE code = $otp_code";
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

    if ($password !== $cpassword) {
        $errors['password'] = "Confirm password not matched!";
    } else {
        $code = 0;
        $email = $_SESSION['email'];
        $encpass = password_hash($password, PASSWORD_BCRYPT);
        $update_pass = "UPDATE applicants SET code = $code, password = '$encpass' WHERE email = '$email'";
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
    header('Location: applicant_login.php');
    exit();
}

?>
