<?php 
include "applicantLog_functions.php";

// Initialize the $email variable
$email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have some code here that processes the form submission
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
    }
    // Add your form processing code here
    // For example, adding errors to $errors array
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link rel="icon" href="../assets/img/mtfrbLogo.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   
   <link rel="stylesheet"  href="assets/css/forgotpass.css">
</head>
<body>
    <div class="box">
        <form action="forgot-password.php" method="POST" autocomplete="">
                <h1 class="form-title">Forgot Password</h1>
                <p class="form-description">Forgot your password ? Don't worry we are just here to solve your problem ! Just enter your e-mail address to proceed.</p>
                <?php
                        if (!empty($errors)) {
                            ?>
                            <div class="alert alert-danger text-center">
                                <?php 
                                    foreach($errors as $error){
                                        echo $error;
                                    }
                                ?>
                            </div>
                            <?php
                        }
                    ?>
                <input type="email" name="email" id="email" placeholder="Your e-mail address"><br>
                <button  type="submit" name="check-email">Reset my Password</button>

         </form>
    </div>
    
</body>
</html>
<!--<script src="assets/js/translate.js"> </script>-->
  <!-- <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>->