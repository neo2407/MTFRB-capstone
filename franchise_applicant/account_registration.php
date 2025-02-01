<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Registration</title>
    <link rel="icon" href="assets/img/mtfrbLogo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="assets/css/account-form.css" rel="stylesheet">
</head>

<body>
<nav class="navbar navbar-expand-md navbar-light shadow-sm p-3 mb-0 bg-white" style="height:67px;">
        <div class="container-lg">
            <a class="navbar-brand" href="../index.php">
                <img src="assets/img/MTFRB Lucban.jpg" class="logo-pic" alt="Logo of MTFRB Lucban">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="modal" data-bs-target="#navModal">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item ">
                    <a href="index.php" class="btn btn-white" aria-current="page"></a>
                </li>
            </ul>
        </div>
        </div>
    </nav>

    <!-- Modal -->
    <div class="modal fade" id="navModal" tabindex="-1" aria-labelledby="navModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Home</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <section class="Form d-flex justify-content-center">
        <div class="content">
            <form action="applicant_account_reg.php" method="post" enctype="multipart/form-data"
                class="complaint-form row g-3 w-75 mx-auto">
                <p class="text-center fs-3 fw-semibold">
                    Account Registration
                </p>

                <div class="border p-3 border-gray rounded">
                <div class="form-group row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="last_name" placeholder="Dela Cruz" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">First Name</label>
                        <input type="text" class="form-control" name="first_name" placeholder="Juan" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Middle Name</label>
                        <input type="text" class="form-control" name="m_name" placeholder="Reyes" required>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label class="form-label">Contact Number</label>
                        <input type="number" class="form-control" id="contactNum" name="contact_num"
                            placeholder="09xxxx xxx xxxx" required>
                    </div>
                    <div class="col-md-6 mt-2" style="margin-bottom:10px;">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="example@gmail.com"
                            required>
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" id="password" class="form-control" name="password" placeholder="********" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                        <small id="password-strength-message" class="form-text text-danger"></small>
                    </div>

                    <div class="col-md-6">
                        <label for="confirm-password" class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" id="confirm-password" class="form-control" name="confirm-password" placeholder="********">
                            <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                        <small id="password-message" class="form-text text-danger"></small>
                    </div>


                     
                </div>
                </div>
                <button type="submit" name="submit" class="btn btn-warning">Register</button>
            </form>
        </div>

        <!-- Data Privacy Act Modal -->

        <div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="privacyModalLabel">Data Privacy Act Acknowledgment</h5>
                    </div>
                    <div class="modal-body">
                        <p>Note: Your privacy is important to us. By proceeding with this application, you acknowledge
                            and agree to the following:</p>
                        <ul>
                            <li><strong>Data Collection and Usage:</strong> We collect your personal information to
                                process your franchise application and for related administrative purposes.</li>
                            <li><strong>Data Sharing:</strong> Your data may be shared with relevant government agencies
                                as required by law.</li>
                            <li><strong>Data Security:</strong> We employ appropriate security measures to protect your
                                data against unauthorized access and disclosure.</li>
                            <li><strong>Data Retention:</strong> Your personal data will be retained for as long as
                                necessary to fulfill the purposes outlined, unless a longer retention period is required
                                or permitted by law.</li>
                            <li><strong>Rights to Your Data:</strong> You have the right to access, correct, or request
                                the deletion of your personal data. For any concerns, view the contact information on the MTFRB Lucban website.</li>
                        </ul>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="privacyActCheck" required>
                            <label class="form-check-label" for="privacyActCheck">
                                I agree to the Data Privacy Act
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="privacyAcceptButton" disabled>Accept and Continue</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    </section>

    <!-- JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/account-form.js"></script>
    <script src="assets/js/translate.js"></script>
    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

  <?php include "scripts.php";?>

  <script>
   document.addEventListener('DOMContentLoaded', function () {
    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('confirm-password');
    const passwordMessage = document.getElementById('password-message');
    const passwordStrengthMessage = document.getElementById('password-strength-message');
    const togglePassword = document.getElementById('togglePassword');
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');

    function validatePasswordMatch() {
        if (passwordField.value !== confirmPasswordField.value) {
            passwordMessage.textContent = 'Passwords do not match';
        } else {
            passwordMessage.textContent = '';
        }
    }

    function validatePasswordStrength() {
        const password = passwordField.value;
        const regex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{8,}$/;
        if (!regex.test(password)) {
            passwordStrengthMessage.textContent = 'Password must contain at least 8 characters, including uppercase, lowercase, and numbers';
        } else {
            passwordStrengthMessage.textContent = '';
        }
    }

    // Toggle visibility of password
    function toggleVisibility(inputField, icon) {
        if (inputField.type === 'password') {
            inputField.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            inputField.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    togglePassword.addEventListener('click', function () {
        const icon = togglePassword.querySelector('i');
        toggleVisibility(passwordField, icon);
    });

    toggleConfirmPassword.addEventListener('click', function () {
        const icon = toggleConfirmPassword.querySelector('i');
        toggleVisibility(confirmPasswordField, icon);
    });

    passwordField.addEventListener('input', validatePasswordStrength);
    confirmPasswordField.addEventListener('input', validatePasswordMatch);
});
  </script>
  <script>
// Show the modal when the page loads
document.addEventListener("DOMContentLoaded", function() {
    var privacyModal = new bootstrap.Modal(document.getElementById('privacyModal'));
    privacyModal.show();

    // Enable the "Accept and Continue" button when checkbox is checked
    var checkbox = document.getElementById('privacyActCheck');
    var acceptButton = document.getElementById('privacyAcceptButton');

    checkbox.addEventListener('change', function() {
        acceptButton.disabled = !checkbox.checked;
    });

    // Close the modal only if the checkbox is checked
    acceptButton.addEventListener('click', function() {
        if (checkbox.checked) {
            privacyModal.hide();
        } else {
            alert("Please agree to the Data Privacy Act before proceeding.");
        }
    });
});
</script>
<!-- Bootstrap JS (required) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

</body>

</html>
