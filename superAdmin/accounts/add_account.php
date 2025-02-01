<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Account Modal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .swal2-container {
            z-index: 1060 !important; /* Ensure SweetAlert2 is on top of Bootstrap modal */
        }
    </style>
    <style>
    .custom-width {
        max-width: 700px; /* Adjust the width as needed */
    }
    </style>
</head>
<body>
   <div class="modal fade" id="add_account_Modal" tabindex="-1" role="dialog" aria-labelledby="add_account_ModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog custom-width" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_account_ModalLabel">Add Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="insert_account.php" method="post" enctype="multipart/form-data" style='margin-bottom: 10px;'>
                        <div class="form-group row">
                            <div class="col-md-5">
                                <label class="form-label">First Name:</label>
                                <input type="text" class="form-control" name="f_name" placeholder="Albert" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Last Name:</label>
                                <input type="text" class="form-control" name="l_name" placeholder="Einstein" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Middle Name:</label>
                                <input type="text" class="form-control" name="m_name" placeholder="Santos" required>
                            </div>
                        </div>
                  
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-label">Username:</label>
                                <input type="text" class="form-control" name="username" placeholder="username" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email:</label>
                                <input type="email" class="form-control" name="email" placeholder="name@example.com" required>
                            </div>
                        </div>
                   
                        <div class="form-group row">
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
                    
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-label">Job Position</label>
                                <input type="text" class="form-control" name="job_position" placeholder="Job Position" required>
                            </div>
                            <div class="col-md-6">
                                <label for="accountType">Account Type</label>
                                <select id="account_type" name="account_type" class="form-control custom-select" required>
                                    <option value="">Select Account Type</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Super Admin">Super Admin</option>
                                </select>
                            </div>
                        </div>
                       
                        <div class="form-group row">
                        <div class="col-md-6">
                                <label class="form-label">Upload Profile Picture</label>
                                <input type="file" class="form-control-file form-control" name="profile_picture" accept="image/*"required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Contact Number</label>
                                <input type="text" class="form-control" name="contact_number" placeholder="123-456-7890">
                            </div>
                        </div>
                                               
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="form-label">Address</label>
                                <textarea class="form-control" name="address" rows="2" placeholder="Enter address"></textarea>
                            </div>
                        </div>
                       
                        <div class="form-group row">
                            <div class="col text-right">
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
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
</html>
