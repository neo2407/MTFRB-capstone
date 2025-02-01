<?php 

    include "applicantLog_functions.php";

  
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <!--<link rel="stylesheet" href="assets/css/loginDesign.css">-->
  
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background: #3468C0 url('../../assets/img/bg-lucban.png') no-repeat center center fixed;
        background-size: cover;
        overflow: hidden;
    }

    .login {
        width: 100%;
        max-width: 550px;
        padding: 1rem;
        position: relative; /* Added for logo positioning */
    }
    form {
            background-color: #ffffff;
            color: #3468C0;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            position: relative;
            z-index: 1;
           
            
        }
    
        h2 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 1rem;
        }
    
        .input-box {
            margin: 1rem 0;
            position: relative;
        }
    
        .input-box select {
            width: 100%;
            padding: 10px;
        border: 1px solid #2780c2;
        border-radius: 5px;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
    }

      .btn {
        display: block;
        width: 100%;
        padding: 10px;
        background-color: #2780c2; /* Primary button color */
        border: none;
        border-radius: 5px; /* Smooth rounded corners */
        color: white; /* White text color */
        font-size: 16px;
        font-weight: bold;
        text-align: center;
        cursor: pointer;
        margin: 20px 0; /* Top and bottom spacing */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Add a subtle shadow for contrast */
        transition: all 0.3s ease; /* Smooth hover transition */
        backdrop-filter: blur(3px); /* Slight blur effect for better readability */
        opacity: 0.95; /* Slightly transparent for a sleek look */
    }
    
    .btn:hover {
        background-color: #3468C0; /* Slightly darker blue on hover */
        opacity: 1; /* Fully opaque on hover */
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3); /* Elevated shadow on hover */
        color:#FFFFFF;
    }
    
    .btn:active {
        transform: translateY(2px); /* Pressed effect */
    }
    
        .input-box.active-grey .input-1 {
        border: 1px solid #dadce0;
    }
    
    .input-box.active-grey .input-label {
        color: #80868b;
        top: -8px;
        background: #fff;
        font-size: 11px;
        transition: 250ms;
    }
    
    .input-box {
        position: relative;
        margin: 10px 0;
    }
    
    .input-box .input-label {
        position: absolute;
        color: #80868b;
        font-size: 16px;
        font-weight: 400;
        max-width: calc(100% - (2 * 8px));
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        left: 8px;
        top: 13px;
        padding: 0 8px;
        transition: 250ms;
        user-select: none;
        pointer-events: none;
    }
    
    .input-box .input-1 {
        box-sizing: border-box;
        height: 50px;
        width: 100%;
        border-radius: 4px;
        color: #202124;
        border: 1px solid #dadce0;
        padding: 13px 15px;
        transition: 250ms;
    }
    
    .input-box .input-1:focus {
        outline: none;
        border: 2px solid #1a73e8;
        transition: 250ms;
    }
    
    .input-box.error .input-label {
        color: #f44336;
        top: -8px;
        background: #fff;
        font-size: 11px;
        transition: 250ms;
    }
    
    .input-box.error .input-1 {
        border: 2px solid #f44336;
    }
    
    .input-box.focus .input-label,
    .input-box.active .input-label {
        color: #1a73e8;
        top: -8px;
        background: #fff;
        font-size: 11px;
        transition: 250ms;
    }
    
    .input-box.active .input-1 {
        border: 2px solid #1a73e8;
    }
    
    
    .input-box {
        position: relative;
        margin: 10px 0;
    }
    
    .input-label {
        position: absolute;
        color: #80868b;
        font-size: 16px;
        font-weight: 400;
        max-width: calc(100% - (2 * 8px));
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        left: 8px;
        top: 13px;
        padding: 0 8px;
        transition: 250ms;
        user-select: none;
        pointer-events: none;
    }
    
    .input-1 {
        box-sizing: border-box;
        height: 50px;
        width: 100%;
        border-radius: 4px;
        color: #202124;
        border: 1px solid #dadce0;
        padding: 13px 15px;
        transition: 250ms;
    }
    
    input {
        background: #fff;
    }
    
    label {
        cursor: default;
    }
    
    a{
        text-decoration: none;
    }



    .login img.Logo {
        position: absolute;
        z-index: 0; /* Behind the form */
        opacity: 0.1; /* Lower opacity for subtle background */
        width: 100%; /* Dynamic size relative to the form */
        max-width: 700px; /* Prevent excessive scaling on large screens */
        height: auto;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        pointer-events: none; /* Ensure the image doesn’t interfere with user input */
    }

    @media (max-width: 480px) {
        .login {
            max-width:100%;
            padding: 0.5rem;
        }

        h2 {
            font-size: 1.5rem;
        }

        .btn {
            font-size: 14px;
            padding: 8px;
        }

        .input-box select {
            font-size: 13px;
        }

        .login img.Logo {
            width: 100%; /* Adjust logo size for smaller screens */
            max-width: 700px; /* Limit the maximum size on very small screens */
        }
    }
  </style>

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

/** show pasword **/
/* Adjust toggle-password position */
.toggle-password {
    position: absolute;
    right: 15px; /* Position icon at the right end of the input */
    top: 50%; /* Center vertically within the input field */
    transform: translateY(-50%); /* Adjust for perfect centering */
    cursor: pointer;
    color: #80868b;
    z-index: 2;
}

/* Add padding to the input field to avoid text overlap */
.input-box .input-1 {
    padding-right: 45px !important; /* Ensure there's enough space for the icon */
    box-sizing: border-box;
    height: 50px;
    width: 100%;
    border-radius: 4px;
    color: #202124;
    border: 1px solid #dadce0;
    padding: 13px 15px;
    transition: 250ms;
}

/* Hover effect for the icon */
.toggle-password:hover {
    color: #1a73e8; /* Highlight icon on hover */
}

</style>

<script>
  
window.addEventListener('load', function() {
    const preloader = document.getElementById('preloader');
    const navbar = document.getElementById('navbar');

    setTimeout(() => {
        preloader.style.display = 'none';
        //navbar.style.display = 'block'; 
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
<form action="applicant_login.php" method="POST" autocomplete="" style="border-radius: 1rem;">
            <div class="form-content text-center">
                            <img src="../assets/img/MTFRB LOGO 2.png" class="Logo">
                <div class="mb-md-5 mt-md-4 pb-1">
                    <h2 class="fw-bold mb-2 text-uppercase">Applicant Login</h2>
                    <p class="mb-5">Please enter your email and password</p>

                
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
                 <input type="password" id="password" name="password" class="input-1" onfocus="setFocus(true)" onblur="setFocus(false)" />
                <i class="toggle-password fas fa-eye" id="togglePassword"></i>
            </div>

            <p class="small pb-lg-2"><a class="forgot-password" href="forgot-password.php">Forgot password?</a></p>

            <button data-mdb-button-init data-mdb-ripple-init class="login-btn btn btn-lg px-5"
                type="submit" name="login" >Login</button>

</div>

<div>
<p class="fs-6">Don't Have an Account? <a href="account-registration.php" class="fw-bold">Register</a>
</p>
</div>

</div>
</form>
</div>

<script src="assets/js/translate.js"></script>
<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

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

<script>
   // Add toggle password functionality
const togglePassword = document.getElementById('togglePassword');
const passwordInput = document.getElementById('password');

togglePassword.addEventListener('click', () => {
    const type = passwordInput.type === 'password' ? 'text' : 'password';
    passwordInput.type = type;

    // Toggle the eye icon
    togglePassword.classList.toggle('fa-eye-slash');
});
</script>
</body>
</html>
