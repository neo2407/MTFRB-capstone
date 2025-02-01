<?php include "applicantLog_functions.php"; ?>
<?php 
$email = $_SESSION['email'];
 if($email == false){
 header('Location: applicant_login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code Verification</title>
    <link rel="icon" href="../assets/img/mtfrbLogo.png">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!--<link rel="stylesheet" href="assets/css/new-pass.css">-->
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
        margin: 0; /* Ensure no margin around the body */
    }

    .new-pass {
        width: 100%;  /* Full width of the viewport */
        height: 100%; /* Full height of the viewport */
        padding: -32rem; /* Padding for space around the form */
        box-sizing: border-box;  /* Include padding in width and height */
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
    }

    form {
        background-color: #ffffff;
        color: #3468C0;
        border-radius: 1rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        position: relative;
        z-index: 1;
        width: 90%; /* Adjust form width to 90% of the screen */
        max-width: 500px; /* Limit max width for form */
        height: auto; /* Allow height to adjust based on content */
        overflow: auto; /* Prevent overflow issues */
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
    
    a {
        text-decoration: none;
    }

    .new-pass img.Logo {
        position: absolute;
        z-index: 0;
        opacity: 0.1;
        width: 100%;
        height: 100%; /* Ensure the logo fills the entire height */
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        pointer-events: none;
    }
    
   @media screen and (max-width: 768px) {
    form {
        width: 90%; /* Occupy most of the screen width */
        max-width: 600px; /* Reduce max width for smaller screens */
        margin: 0 auto; /* Center the form */
    }

    .new-pass {
        padding: 1rem; /* Add padding for better spacing */
    }

    h2 {
        font-size: 1.25rem; /* Adjust heading size */
    }

    .btn {
        font-size: 14px;
        padding: 10px;
    }

    .input-box .input-1 {
        padding: 10px;
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

<div class="new-pass" class="justify-content-center align-items-center">
    <form action="#" method="POST" autocomplete=""  style="border-radius: 1rem;">
            <div class="form-content text-center">
                            <img src="../assets/img/MTFRB LOGO 2.png" class="Logo">
                <div class="mb-md-5 mt-md-4 pb-1 text-center">
                    <h2 class="fw-bold mb-3 text-uppercase">Code Verification</h2>
                    <p class="mb-5">Check your email and enter the verification code in the form field.</p>
                <?php 
                    if(isset($_SESSION['info'])){
                        ?>
                        <div class="alert alert-success text-center" style="padding: 0.4rem 0.4rem">
                            <?php echo $_SESSION['info']; ?>
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                    if(count($errors) > 0){
                        ?>
                        <div class="alert alert-danger text-center">
                            <?php
                            foreach($errors as $showerror){
                                echo $showerror;
                            }
                            ?>
                        </div>
                        <?php
                    }
                ?>
             <div class="input-box">
                <label class="input-label">Code</label>   
                <input type="number" name="otp" id="otp"  class="input-1" onfocus="setFocus(true)" onblur="setFocus(false)" required />
            </div>

            <button type="submit" type="submit" name="check-reset-otp" data-mdb-button-init data-mdb-ripple-init class="back-btn btn btn-lg">Continue</button>
            </div>
         </div>
    </form>
</div>

</body>
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




</html>