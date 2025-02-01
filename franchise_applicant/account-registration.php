<?php 
include "account_verification.php";
$isRegistered = false;

// Retrieve form data from session (if available)
$formData = $_SESSION['form_data'] ?? [];

// Clear the form data from the session to avoid reuse
unset($_SESSION['form_data']);  
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> Account Registration</title>
    <link rel="icon" href="../assets/img/MTFRB LOGO 2.png">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!--<link rel="stylesheet" href="assets/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="assets/css/registration.css">

    
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

.register {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: #3468C0 url('../../assets/img/bg-lucban.png') no-repeat center center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: 100% 100%;
    overflow: hidden;
    overflow-y: auto; /* Allow vertical scrolling */
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
    
    <div class="register" class="justify-content-center align-items-center" >
        <form action="account-registration.php" method="post" method="POST" autocomplete="" style="border-radius: 1rem;">
            <div class="form-content text-center">
                            <img src="../assets/img/MTFRB LOGO 2.png" class="Logo">
                <div class="mb-md-3 mt-md-3 pb-1">
                    <h2 class="fw-bold mb-2 text-uppercase">Account Registration</h2>
                    <p class="mb-5">Welcome! Fill in the details below to register and start your journey with us.</p>
                        <?php
                        if(count($errors) == 1){
                            ?>
                            <div class="alert alert-danger text-center">
                                <?php
                                foreach($errors as $showerror){
                                    echo $showerror;
                                }
                                ?>
                            </div>
                            <?php
                        }elseif(count($errors) > 1){
                            ?>
                            <div class="alert alert-danger">
                                <?php
                                foreach($errors as $showerror){
                                    ?>
                                    <li><?php echo $showerror; ?></li>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                     <div class="row" style="margin-top:-30px;">
                        <div class="input-box col-sm-4">
                            <label class="input-label">Last  Name</label>
                            <input type="text" class="input-1" onfocus="setFocus(true)" onblur="setFocus(false)" name="last_name" required value="<?= htmlspecialchars($formData['last_name'] ?? '') ?>" pattern="[A-Za-z\s]+" title="Please enter a valid first name using letters only."/>
                        </div>

                        <div class="input-box col-sm-4" >
                            <label class="input-label">First  Name</label>
                            <input type="text" class="input-1" onfocus="setFocus(true)" onblur="setFocus(false)" name="first_name" required value="<?= htmlspecialchars($formData['first_name'] ?? '') ?>" pattern="[A-Za-z\s]+" title="Please enter a valid first name using letters only."/>
                        </div>

                        <div class="input-box col-sm-4" >
                            <label class="input-label">Middle Name</label>
                            <input type="text" class="input-1" onfocus="setFocus(true)" onblur="setFocus(false)" name="m_name" required value="<?= htmlspecialchars($formData['m_name'] ?? '') ?>"  pattern="[A-Za-z\s]+" title="Please enter a valid first name using letters only."/>
                        </div>
                    
                    </div>
                        <div class="input-box">
                            <label class="input-label">Email</label>
                            <input type="email" class="input-1" onfocus="setFocus(true)" onblur="setFocus(false)" name="email" required value="<?= htmlspecialchars($formData['email'] ?? '') ?>"/>
                            <!--<small>Enter a valid and active email address</small>-->
                        </div>

                        <div class="input-box">
                            <label class="input-label">Contact Number</label>
                            <input type="number" class="input-1" onfocus="setFocus(true)" onblur="setFocus(false)" name="contact_num" required value="<?= htmlspecialchars($formData['contact_num'] ?? '') ?>"/>
                        </div>
                   
                            <div class="input-box ">
                                <label class="input-label">Password</label>
                                <input type="password" class="input-1" id="password" onfocus="setFocus(true)" onblur="setFocus(false)" name="password" oninput="validatePassword()" required/>
                                <span class="toggle-password" style="position: absolute; right: 15px; top: 45%;" onclick="togglePassword('password', 'toggle-icon')">
                                    <i class="fas fa-eye" id="toggle-icon"></i>
                                </span>
                                <small id="password-strength-message" class="form-text text-danger"></small>
                            </div>
                            
                            <div class="input-box ">
                                <label class="input-label">Confirm Password</label>
                                <input type="password" class="input-1" id="confirm-password" onfocus="setFocus(true)" onblur="setFocus(false)" name="cpassword" oninput="validatePassword()" required/>
                                <span class="toggle-password" style="position: absolute; right: 15px; top: 45%;" onclick="togglePassword('confirm-password', 'toggle-icon-confirm')">
                                    <i class="fas fa-eye" id="toggle-icon-confirm"></i>
                                </span>
                                <small id="password-message" class="form-text text-danger"></small>
                            </div>
                        
                    
                    </div>
                    <button data-mdb-button-init data-mdb-ripple-init class="login-btn btn btn-lg"
                        type="submit" name="signup">Register</button>
                        <br>
                        <br>
                        <div>
                            <p class="fs-6">Account Already Registered? <a href="applicant_login.php" class="fw-bold">Click Here</a></p>
                        </div>
                </div>
            </div>
        </form>
    </div>
<!-- Data Privacy Act Modal -->
<div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel">
    <div class="modal-dialog modal-dialog-centered" style="width: 90%; max-width: 500px;">
        <div class="modal-content"> 
            <div class="modal-header">
                <h5 class="modal-title" id="privacyModalLabel">Data Privacy Act Acknowledgment of 2012</h5>
            </div>
            <div class="modal-body">
                <p>Note: Your privacy is important to us. By proceeding with this application, you acknowledge and agree to the following:</p>
                <ul>
                    <li><strong>Data Collection and Usage:</strong> We collect your personal information to process your franchise application and for related administrative purposes.</li>
                    <li><strong>Data Sharing:</strong> Your data may be shared with relevant government agencies as required by law.</li>
                    <li><strong>Data Security:</strong> We employ appropriate security measures to protect your data against unauthorized access and disclosure.</li>
                    <li><strong>Data Retention:</strong> Your personal data will be retained for as long as necessary to fulfill the purposes outlined, unless a longer retention period is required or permitted by law.</li>
                    <li><strong>Rights to Your Data:</strong> You have the right to access, correct, or request the deletion of your personal data. For any concerns, view the contact information on the MTFRB Lucban website.</li>
                </ul>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="privacyActCheck" required>
                    <label class="form-check-label" for="privacyActCheck">I agree to the Data Privacy Act</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="privacyAcceptButton" disabled>Accept and Continue</button>
            </div>
        </div>
    </div>
</div>

<!-- Add this custom CSS -->
<style>
    /* Center the modal content */
    .modal-dialog-centered {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .modal-dialog {
        max-width: 500px; /* Maximum width of modal */
        width: 100%; /* 100% width, but limited by max-width */
    }

    /* Media query for small devices (tablets) */
    @media (max-width: 768px) {
        .modal-dialog {
            width: 90%; /* Width adjustment for tablets and smaller screens */
        }
    }

    /* Media query for very small devices (phones) */
    @media (max-width: 576px) {
        .modal-dialog {
            width: 95%; /* Width adjustment for very small screens */
        }
    }

    /* Optional: To ensure the modal content adjusts properly */
    .modal-content {
        padding: 15px; /* Adding padding inside the modal content */
    }
</style>





 <!-- JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!--<script src="assets/js/account-form.js"></script>-->
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


    function togglePassword(inputId, iconId) {
        var inputField = document.getElementById(inputId);
        var icon = document.getElementById(iconId);
        if (inputField.type === "password") {
            inputField.type = "text";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            inputField.type = "password";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    function validatePassword() {
        var password = document.getElementById('password').value;
        var confirmPassword = document.getElementById('confirm-password').value;
        var passwordMessage = document.getElementById('password-message');
        var passwordStrengthMessage = document.getElementById('password-strength-message');

        // Regular expression for password validation
        var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/;

        // Validate password strength
        if (!passwordRegex.test(password)) {
            passwordStrengthMessage.innerText = 'Password must be at least 8 characters long, contain uppercase, lowercase, and a number.';
            passwordStrengthMessage.classList.add('text-danger');
        } else {
            passwordStrengthMessage.innerText = '';
        }

        // Check if passwords match
        if (password !== confirmPassword) {
            passwordMessage.innerText = 'Passwords do not match.';
            passwordMessage.classList.add('text-danger');
        } else {
            passwordMessage.innerText = '';
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Check if the user is registered
        var isRegistered = <?php echo json_encode($isRegistered); ?>;

        // Check if the user has already accepted the Data Privacy Act
        var hasAcceptedPrivacy = localStorage.getItem('hasAcceptedPrivacy') === 'true';

        // Get the modal element
        var privacyModalElement = document.getElementById('privacyModal');

        // Show the modal only if the user is not registered and has not accepted the privacy act
        if (!isRegistered && !hasAcceptedPrivacy) {
            var privacyModal = new bootstrap.Modal(privacyModalElement, {
                backdrop: 'static', // Prevent closing the modal by clicking outside
                keyboard: false // Prevent closing the modal with the Esc key
            });
            privacyModal.show();
            privacyModalElement.removeAttribute('inert'); // Remove inert so it is focusable
        } else {
            // If the user has accepted the privacy act, make the modal inert
            privacyModalElement.setAttribute('inert', ''); // Set inert to disable interaction and focus
        }

        // Enable the "Accept and Continue" button when the checkbox is checked
        var checkbox = document.getElementById('privacyActCheck');
        var acceptButton = document.getElementById('privacyAcceptButton');

        checkbox.addEventListener('change', function() {
            acceptButton.disabled = !checkbox.checked;
        });

        // Close the modal and store acceptance in localStorage
        acceptButton.addEventListener('click', function() {
            if (checkbox.checked) {
                privacyModal.hide();
                localStorage.setItem('hasAcceptedPrivacy', 'true');
                privacyModalElement.setAttribute('inert', ''); // Set inert back to prevent focus/interaction
            } else {
                alert("Please agree to the Data Privacy Act before proceeding.");
            }
        });
    });
</script>




<?php include "scripts.php";?>

<!-- Bootstrap JS (required) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>