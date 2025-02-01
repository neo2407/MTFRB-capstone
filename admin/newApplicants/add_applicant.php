<?php
session_start();
include "../include/db_conn.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Applicant Modal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .swal2-container {
            z-index: 1060 !important; /* Ensure SweetAlert2 is on top of Bootstrap modal */
        }
    </style>
</head>
<body>
    <div class="modal fade" id="add_applicant_Modal" tabindex="-1" role="dialog" aria-labelledby="add_applicant_ModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog custom-width" role="document" style="max-width: 700px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_applicant_ModalLabel">Add Applicant</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="multiStepForm" action="insert_applicant.php" method="post" enctype="multipart/form-data">
                        <!-- Step 1: Applicant Info -->
                        <div id="step-1" class="step">
                        <p class="text-center fs-4 fw-semibold">Applicant & Tricycle Information</p>
                            <div class="form-group row">
                                <div class="col-md-5">
                                    <label class="form-label">First Name:</label>
                                    <input type="text" class="form-control" name="first_name" placeholder="Albert" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Last Name:</label>
                                    <input type="text" class="form-control" name="last_name" placeholder="Einstein" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Middle Name:</label>
                                    <input type="text" class="form-control" name="m_name" placeholder="Santos" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-4">
                                <label class="form-label">Contact Number:</label>
                                    <input type="text" class="form-control" id="contact_num" name="contact_num" placeholder="09xxxxxxxxx" required>
                                    <span id="contactError" style="color: red; display: none;">Contact number must be exactly 11 digits and contain only numbers.</span>
                                 </div>

                                <div class="col-md-4">
                                    <label class="form-label">Birth Date:</label>
                                    <input type="date" class="form-control" name="b_date" required>
                                </div>
                                
                                <div class="col-md-4">
                                    <label class="form-label">Age:</label>
                                    <input type="number" class="form-control" placeholder="45" name="age" required>
                                </div>
                               
                            </div>

                            <div class="form-group row">
                                
                                <div class="col-md-6">
                                    <label for="sex">Sex</label>
                                    <select id="sex" name="sex" class="form-control custom-select" required>
                                        <option value="">Select Sex</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control" name="address" rows="1" placeholder="Enter address"></textarea>
                                </div>
                            </div>

                                                   
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-label">Registered Driver 1</label>
                                <input type="text" class="form-control" name="driver1_name" placeholder="Juan B. Dela Cuz" required>
                            </div>
                            <div class="col-md-6">
                            <label class="form-label">Registered Driver 2</label>
                            <input type="text" class="form-control" name="driver2_name" placeholder="Enter N/A if no registered driver 2" >
                            </div>
                        </div>
                            <div class="form-group row">
                            <div class="col-md-4">
                                <label for="madeOf" class="form-label">Vehicle Type</label>
                                    <select id="madeOf" name="tricType"  class="form-control custom-select" required>
                                        <option value="">Select</option>
                                        <option value="Tricycle">Tricycle</option>
                                        <option value="Tricycle(Back-to-Back)">Tricycle(Back-to-Back)</option>
                                        <option value="Tuktuk">Tuktuk</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tricycle Color</label>
                                <input type="text" class="form-control" id="colorOftric" name="tricColor" placeholder="Blue">
                            </div>
                            <div class="col-md-4">
                            <label for="toda" class="form-label fw-semibold">TODA</label>
                                <select id="toda" name="toda"  class="form-control custom-select" required>
                                    <option value="">Select TODA</option>
                                    <option value="Not Member of TODA">Not Member of TODA</option>
                                    <option value="ASIT">ASIT</option>
                                    <option value="CALMAR">CALMAR</option>
                                    <option value="CSIDE">CSIDE</option>
                                    <option value="FABIE">FABIE</option>
                                    <option value="GSLV">GSLV</option>
                                    <option value="KILIB">KILIB</option>
                                    <option value="KULAPI">KULAPI</option>
                                    <option value="LRE 200">LRE 200</option>
                                    <option value="LUCBAN">LUCBAN</option>
                                    <option value="MAKATC">MAKATC</option>
                                    <option value="MARKET">MARKET</option>
                                    <option value="MMD">MMD</option>
                                    <option value="MMDT">MMDT</option>
                                    <option value="MMK">MMK</option>
                                    <option value="MMONTE">MMONTE</option>
                                    <option value="NAGSIMANO">NAGSIMANO</option>
                                    <option value="ONGVILLE">ONGVILLE</option>
                                    <option value="PALOLA">PALOLA</option>
                                    <option value="PECTO">PECTO</option>
                                    <option value="PEL">PEL</option>
                                    <option value="PEL SERVICE">PEL SERVICE</option>
                                    <option value="PIIS">PIIS</option>
                                    <option value="PSL">PSL</option>
                                    <option value="SAMBAT">SAMBAT</option>
                                    <option value="SLSU">SLSU</option>
                                    <option value="SLSU AYUTI">SLSU AYUTI</option>
                                    <option value="TBT">TBT</option>
                                    <option value="TMG">TMG</option>
                                    <option value="TUKTUK B.">TUKTUK B.</option>
                                    <option value="UNAVP">UNAVP</option>
                                </select>
                            </div>
                            
                        </div>
                       <div class="form-group row">
                            <div class="col-md-4">
                                <label class="form-label">Driver's License No</label>
                                <input type="text" class="form-control" name="license_no" placeholder="D09-00-000000" required>
                            </div>
                            <div class="col-md-4">
                            <label class="form-label">License Classification</label>
                            <input type="text" class="form-control" name="license_class" placeholder="Professional" required >
                            </div>
                             <div class="col-md-4">
                            <label class="form-label">License Expiration</label>
                            <input type="date" class="form-control" name="license_exp"  required >
                            </div>
                        </div>
                        
                        

                            <!-- Next button -->
                            <div class="form-group row">
                                <div class="col text-right">
                                    <button type="button" id="next-1" class="btn btn-primary">Next</button>
                                </div>
                            </div>
                        </div>
                            <!-- Step 3:Account Info -->
                        <div id="step-2" class="step" style="display: none;">
                        <div class="form-group row">
                            <p class="text-center fs-4 fw-semibold">Account Information</p>
                            <div class="col-md-12">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="example@gmail.com" required>
                            </div>

    
                            <div class="form-group row" >
                                <div class="col-md-6">
                                    <label for="password" class="form-label fw-semibold">Password</label>
                                    <input type="password" id="password" class="form-control" name="password" placeholder="********" required>
                                    <small id="password-strength-message" class="form-text text-danger"></small> <!-- Password strength message -->
                                </div>

                                <div class="col-md-6">
                                    <label for="confirm-password" class="form-label fw-semibold">Confirm Password</label>
                                    <input type="password" id="confirm-password" class="form-control" name="confirm-password" placeholder="********">
                                    <small id="password-message" class="form-text text-danger"></small> <!-- Password match message -->
                                </div>
                            </div>
                        </div>

                        <div class="container form-container g-3">
                        <p class="fs-6 fw-bold">Data Privacy Act Acknowledgment</p>
                        <h6>Note: Your privacy is important to us. By proceeding with this application, you acknowledge
                            and agree to the following:</h6>
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
                                the deletion of your personal data. For any concerns, View the contact information in the MTFRB Lucban website .</li>
                        </ul>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="privacyActCheck" required>
                            <label class="form-check-label" for="privacyActCheck">
                                I agree to the Data Privacy Act
                            </label>
                        </div>
                        
                           <br>
                            <!-- Back and Submit buttons -->
                            <div class="form-group row">
                                <div class="col text-left">
                                    <button type="button" id="back-2" class="btn btn-secondary">Back</button>
                                </div>
                                <div class="col text-right">
                                    <button type="submit" name="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>

                            </div>
                            
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        // Step navigation logic with validation and SweetAlert
        $('#next-1').click(function () {
            if (validateStep1()) { // Validate Step 1
                $('#step-1').hide(); // Hide step 1
                $('#step-2').show(); // Show step 2
            } else {
                showValidationAlert(); // Show SweetAlert if validation fails
            }
        });

        $('#back-3').click(function () {
            // Navigate back to step 1
            $('#step-2').hide();
            $('#step-1').show();
        });

        // Validation for Step 1
        function validateStep1() {
            var isValid = true;

            $('#step-1 input, #step-1 select, #step-1 textarea').each(function () {
                if ($(this).val() === '') {
                    isValid = false;
                    $(this).addClass('is-invalid'); // Add Bootstrap invalid class
                } else {
                    $(this).removeClass('is-invalid'); // Remove invalid class if valid
                }
            });

            return isValid;
        }

        // Validation for Step 2
        function validateStep2() {
            var isValid = true;

            // Validate email
            var email = $('input[name="email"]').val();
            if (email === '' || !validateEmail(email)) {
                isValid = false;
                $('input[name="email"]').addClass('is-invalid');
            } else {
                $('input[name="email"]').removeClass('is-invalid');
            }

            // Validate password
            var password = $('#password').val();
            var confirmPassword = $('#confirm-password').val();
            if (password.length < 8) {
                isValid = false;
                $('#password').addClass('is-invalid');
                $('#password-strength-message').text('Password must be at least 8 characters.');
            } else if (password !== confirmPassword) {
                isValid = false;
                $('#confirm-password').addClass('is-invalid');
                $('#password-message').text('Passwords do not match.');
            } else {
                $('#password').removeClass('is-invalid');
                $('#password-strength-message').text('');
                $('#confirm-password').removeClass('is-invalid');
                $('#password-message').text('');
            }

            // Validate Data Privacy Act checkbox
            if (!$('#privacyActCheck').is(':checked')) {
                isValid = false;
                $('#privacyActCheck').addClass('is-invalid');
            } else {
                $('#privacyActCheck').removeClass('is-invalid');
            }

            return isValid;
        }

        // Email validation helper function
        function validateEmail(email) {
            var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email);
        }

        // SweetAlert for validation failure
        function showValidationAlert() {
            Swal.fire({
                icon: 'warning',
                title: 'All fields are required!',
                text: 'Please fill in all required fields before proceeding.',
                confirmButtonText: 'OK',
            });
        }
    });
</script>




     <script>
    document.addEventListener('DOMContentLoaded', function () {
        const passwordField = document.getElementById('password');
        const confirmPasswordField = document.getElementById('confirm-password');
        const passwordMessage = document.getElementById('password-message');
        const passwordStrengthMessage = document.getElementById('password-strength-message');

        function validatePasswordMatch() {
            if (passwordField.value !== confirmPasswordField.value) {
                passwordMessage.textContent = 'Passwords do not match.';
                confirmPasswordField.classList.add('is-invalid');
            } else {
                passwordMessage.textContent = '';
                confirmPasswordField.classList.remove('is-invalid');
            }
        }

        function validatePasswordStrength() {
            const password = passwordField.value;
            const strongPasswordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/;
            if (password.length < 8) {
                passwordStrengthMessage.textContent = 'Password should be at least 8 characters long.';
                passwordField.classList.add('is-invalid');
            } else if (!strongPasswordPattern.test(password)) {
                passwordStrengthMessage.textContent = 'Password should include  uppercase letter, lowercase letter, and number.';
                passwordField.classList.add('is-invalid');
            } else {
                passwordStrengthMessage.textContent = '';
                passwordField.classList.remove('is-invalid');
            }
        }

        passwordField.addEventListener('input', function () {
            validatePasswordMatch();
            validatePasswordStrength();
        });
        confirmPasswordField.addEventListener('input', validatePasswordMatch);
    });
</script>
    <style>
        .is-invalid {
            border-color: #dc3545;
            padding-right: calc(1.5em + .75rem);
        }
        .form-text.text-danger {
            color: #dc3545;
        }
    </style>

<script>
document.getElementById('contact_num').addEventListener('input', function () {
    var contactInput = this.value;
    var errorMessage = document.getElementById('contactError');

    // Check if the input is exactly 11 digits and contains only numbers
    if (/^\d{11}$/.test(contactInput)) {
        errorMessage.style.display = 'none'; // Hide error if valid
        this.setCustomValidity(''); // Clear invalid state
    } else {
        errorMessage.style.display = 'block'; // Show error if invalid
        this.setCustomValidity('Invalid'); // Set invalid state for form validation
    }
});
</script>

</body>
<?php include "../../include/scripts.php"; ?>
</html>