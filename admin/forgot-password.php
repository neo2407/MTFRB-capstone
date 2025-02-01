<?php 
include "adminLog_functions.php";

// Initialize the $email variable
$email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['email'])) {
        $email = $_POST['email'];
    }
    
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="icon" href="../assets/img/mtfrbLogo.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   
    <link rel="stylesheet"  href="assets/css/forgotpass2.css">
<!-- pre-loader -->
<style>
  /* Preloader */
#preloader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.9); 
    z-index: 9999; 
    display: flex;
    justify-content: center;
    align-items: center;
}

#preloader img {
    width: 75px; 
    height: auto;
}



.loading-text {
    font-family: 'Poppins';
    font-size: 20px; 
    color: #555;
    margin: 0;
    letter-spacing: 1px;
    text-transform: uppercase;
    animation: fadeIn 1.2s infinite alternate;
}

@keyframes fadeIn {
    0% {
        opacity: 0.3;
    }
    100% {
        opacity: 1;
    }
}



</style>

<script>
  
window.addEventListener('load', function() {
    const preloader = document.getElementById('preloader');
    const navbar = document.getElementById('navbar');

    setTimeout(() => {
        preloader.style.display = 'none';
        navbar.style.display = 'block'; 
    }, 1000); 
});
</script>

</head>

<body>
<!--pre-loader-->
<div id="preloader">
    <img src="../assets/img/output-onlinegiftools.gif" alt="Loading...">
    <p class="loading-text">Just a moment...</p>
</div>
<div class="new-pass">
        <form action="forgot-password.php" method="POST" autocomplete="" style="border-radius: 1rem;">
            <div class="form-content">
                            <img src="../assets/img/MTFRB LOGO 2.png" class="Logo">
                <div class="mb-md-5 mt-md-4 pb-1 text-center">
                    <h2 class="fw-bold mb-2 text-uppercase">Forgot Password</h2>
                    <p class="mb-5">Provide the email address associated with your account to reset your password</p>
                    
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

                    <div class="input-box">
                        <label class="input-label">Email</label>
                        <input type="email" name="email" id="email"  class="input-1" onfocus="setFocus(true)" onblur="setFocus(false)" required />
                    </div>

                    <button data-mdb-button-init data-mdb-ripple-init class="reset-btn btn btn-lg"
                    type="submit" name="check-email">Reset Password</button>

                     
                </div>

                

            </div>
        </form>
    </div>

    <script src="assets/js/translate.js"></script>
    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</body>
<script>
   function setFocus(on) {
    const element = document.activeElement;
    const inputBoxes = document.querySelectorAll('.input-box');

    if (on) {
        setTimeout(() => {
            element.parentNode.classList.add("focus");
        });
    } else {
        inputBoxes.forEach(box => {
            const input = box.querySelector('input');

            // Skip the currently focused element
            if (input === element) return;

            // Remove focus class if input is not active
            box.classList.remove("focus");

            // Add focus class if input has a value
            if (input.value) {
                box.classList.add("focus");
            }
        });
    }
}

// Ensure labels stay at the top if input fields have values on page load
window.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.input-box input').forEach(input => {
        if (input.value) {
            input.parentNode.classList.add('focus');
        }
    });
});
</script>

</html>