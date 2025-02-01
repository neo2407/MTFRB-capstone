<?php 

    include "applicantLog_functions.php";
    
    if (isset($_SESSION['status']) && isset($_SESSION['status_code'])): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: "<?php echo $_SESSION['status']; ?>",
                icon: "<?php echo $_SESSION['status_code']; ?>",
                showConfirmButton: true,
                timer: 5000
            }).then(function() {
                // Optional: Redirect to a different page after alert
                window.location.href = "applicant_login.php"; // Change if needed
            });
        });
    </script>
    <?php
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);
endif;
  
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

   <!-- <link rel="stylesheet" href="assets/css/LoginDesign.css">-->
   
   <style>
       @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'poppins';
    html {
    font-size: 16px; /* Base font size for the root */
    font-family: Poppins;
    }
}



body {
    
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: #3468C0 url('../../assets/img/bg-lucban.png') no-repeat center center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: 100% 100%;
    overflow: hidden;
}


.btn{
    cursor: pointer;
    width: 100%;
    background-color: #2780c2;
    border-color: #2780c2;
    border: 1px;
    color: white;
    font-family: Poppins;
    font-weight: 500;
    border-radius: 5px;
}

.btn:hover {
    background-color: #2780c2;
    border-color: #2780c2;
    color: white;
}

.btn:active {
    background-color: #3468C0;
    border-color: #3468C0;
    color: aliceblue;
    transform: translateY(2px);
    transition-duration: .35s;
}

.login{
    padding: 1rem;
}

form {
    background-color: #ffffff;
    color: #3468C0;
}

.form-content{
    padding: 3rem;
}

h2{
    font-family: Poppins;
}

.login {
    position: relative;
    width: 100%;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.login img.Logo {
    position: absolute;
    z-index: -1;
    opacity: 0.1; /* Lower opacity for subtle background */
    width: 400px; /* Adjust image size */
    height: auto;
    top: 50%; /* Centering the image */
    left: 50%;
    transform: translate(-50%, -50%);
}

.form-content {
    position: relative;
    z-index: 1; /* Ensure the form is in front */
    background: white;
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
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

@media only screen and (min-width: 360px) and (max-width: 480px) { 
    .login{
        padding-left: 9rem;
        padding: 1rem;
        padding-bottom: 5rem;
    }

    .login-btn{
        margin-bottom: 20px;
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


</head>

<body>

    <div class="login" class="justify-content-center align-items-center">
        <form action="applicant_login.php" method="POST" autocomplete="" style="border-radius: 1rem;>
        <div class="form-content text-center">
         <img src="/assets/img/MTFRB LOGO 2.png" class="Logo">
                <div class="mb-md-5 mt-md-4 pb-1">
                    <h2 class="fw-bold mb-2 text-uppercase">Applicant Login</h2>
                    <p class="mb-5">Please enter your email and password!</p>
         <?php if(count($errors) > 0): ?>
                        <div class="alert alert-danger text-center">
                            <?php foreach($errors as $error): ?>
                                <?php echo $error; ?>
                            <?php endforeach; ?>
                        </div>
         <?php endif; ?>
            <div class="input-box">
                <input type="text" name="email" required value="<?php echo isset($email) ? $email : ''; ?>"> 
                <label>Email</label>
            </div>

              <div class="input-box">
                <input  type="password" name="password" required>
                <label>Password</label>
            </div>


               <p class="small pb-lg-2"><a class="forgot-password" href="forgot-password.php">Forgot password?</a></p>

            </div>


            <button data-mdb-button-init data-mdb-ripple-init class="login-btn btn btn-lg px-5" type="submit" name="login>Login</button>
            
            
           </div>

                <div>
                    <p class="fs-6">Don't Have an Account? Apply Now! <a href="franchiseApplication.php" class="fw-bold">Register</a>
                    </p>
                </div>

            </div>
        </form>
    </div>

<script src="assets/js/translate.js"> </script>
    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</body>

<script>
    function setFocus(on) {
        var element = document.activeElement;
        var inputBoxes = document.querySelectorAll('.input-box');

        if (on) {
            setTimeout(function () {
                element.parentNode.classList.add("focus");
            });
        } else {
            inputBoxes.forEach(function (box) {
                var input = box.querySelector('input');
                if (input === element) return; // Skip the currently focused element

                // Remove focus class if this input is not active
                box.classList.remove("focus");

                // If the input has a value, keep the focus class
                if (input.value) {
                    box.classList.add("focus");
                }
            });
        }
    }
</script>

</html>

