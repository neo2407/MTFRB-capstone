<?php 

    
include "account_verification.php";
  
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> Applicant Login Form</title>
    <link rel="icon" href="../assets/img/MTFRB LOGO 2.png">
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="assets/css/loginDesign.css">

    
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
       // navbar.style.display = 'block'; 
    }, 1000); 
});
</script>

</head>

<body>
<!--pre-loader-->
<div id="preloader">
    <img src="assets/img/output-onlinegiftools.gif" alt="Loading...">
    <p class="loading-text">Just a moment...</p>
</div>
<div class="login" class="justify-content-center align-items-center">
<form action="acc-already-registered.php" method="POST" autocomplete="" style="border-radius: 1rem;">
            <div class="form-content text-center">
                            <img src="../assets/img/MTFRB LOGO 2.png" class="Logo">
                <div class="mb-md-5 mt-md-4 pb-1">
                    <h2 class="fw-bold mb-2 text-uppercase">Registered Account</h2>
                    <p class="mb-5">Please enter your email and password use upon account Registration</p>

                
                <?php if(count($errors) > 0): ?>
                                <div class="alert alert-danger text-center">
                                    <?php foreach($errors as $error): ?>
                                        <?php echo $error; ?>
                                    <?php endforeach; ?>
                                </div>
                <?php endif; ?>

            <div class="input-box">
                <label class="input-label">Email</label>
                <input type="text" class="input-1" name="email" onfocus="setFocus(true)" onblur="setFocus(false)" name="email" required value="<?php echo isset($email) ? $email : ''; ?>" />
            </div>

            <div class="input-box">
                <label class="input-label">Password</label>
                <input type="password" name="password" class="input-1" onfocus="setFocus(true)" onblur="setFocus(false)" />
            </div>

            <!--<p class="small pb-lg-2"><a class="forgot-password" href="forgot-password.php">Forgot password?</a></p>-->

            <button data-mdb-button-init data-mdb-ripple-init class="login-btn btn btn-lg px-5"
                type="submit" name="continue" >Continue</button>

</div>

<div>
<p class="fs-6">Account Not Verified? <a href="user-otp.php" class="fw-bold">Click Here</a>
</p>
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
