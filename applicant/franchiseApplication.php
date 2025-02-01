<?php 

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tricycle Franchise Application</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://kit.fontawesome.com/845a1cacb6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link rel="icon" href="assets/img/mtfrbLogo.png">
    <link rel="stylesheet" href="assets/css/application-form.css">

    
   
   
  

</head>

<body>
    <section class="Form d-flex justify-content-center">
        <div class="content">
        <form action="user-apply.php" method="post" enctype="multipart/form-data">
            <div class="stepperForm application-form row g-3 w-75 mx-auto">
            <p class="text-center fs-4 fw-semibold mb-3">
                    <img src="../assets/img/tric.jpg" alt="Tricycle Icon" style="width: 24px; height: 24px; margin-left:10px; vertical-align: middle;"> 
                           Tricycle Franchise Application
                </p>
                <div class="stepper w-75 mx-auto">
                    <div class="progress-line">
                        <div id="stepperProgressBar" class="progress-bar"></div>
                    </div>
                    <div class="step" id="step1Indicator">
                        <span class="circle">1</span>
                    </div>
                    <div class="step" id="step2Indicator">
                        <span class="circle">2</span>
                    </div>
                    <div class="step" id="step3Indicator">
                        <span class="circle">3</span>
                    </div>
                   
                </div>

                <!-- Step 1 -->
        
            <div class="step-content" id="step1">
                <div class="card">
                    
                    <div class="form-group row" style="margin-bottom:20px;">
                        <p class="text-center fs-4 fw-semibold">Basic Information</p>
                        <div class="col-md-4">
                            <label for="last_name" class="form-label fw-semibold">Last Name</label>
                            <input type="text" class="form-control" name="last_name" placeholder="Dela Cruz" required>
                        </div>

                        <div class="col-md-4">
                            <label for="first_name" class="form-label fw-semibold">First Name</label>
                            <input type="text" class="form-control" name="first_name" placeholder="Juan" required>
                        </div>

                        <div class="col-md-4">
                            <label for="m_name" class="form-label fw-semibold">Middle Name</label>
                            <input type="text" class="form-control" name="m_name" placeholder="Reyes">
                        </div>
                    </div>

                <div class="form-group row" style="margin-bottom:20px">
                    <div class="col-md-4">
                        <label for="b_date" class="form-label fw-semibold">Birth Date</label>
                        <input type="date" class="form-control" name="b_date" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Age</label>
                        <input type="number" class="form-control" name="age"  placeholder="20" required>
                    </div>

                    <div class="col-md-4">
                        <label for="contct_num" class="form-label fw-semibold">Contact Number</label>
                        <input type="text" class="form-control" id="contact_num" name="contact_num" placeholder="09xxxxxxxxx" required>
<span id="contactError" style="color: red; display: none;">Contact number must be exactly 11 digits and contain only numbers.</span>
                    </div>
                    
                </div>

                <div class="form-group row" style="margin-bottom:20px">
                
                    <div class="col-md-6">
                        <label  for="address" class="form-label fw-semibold">Address</label>
                        <input type="text" class="form-control" name="address" placeholder="House No#, St, Brgy, Municipality" required> 
                    </div>
                    
                    <div class="col-md-4" style="margin-left: 60px; margin-top: 40px;">
                      
                        <label for="sex" class="form-label fw-semibold" style="margin-bottom:10px;">Sex</label>
                        &nbsp;
                            <input type="radio" class="form-check-input" name="sex" id="Male" value="Male">
                            <label for="male" class="form-input-label">Male</label>
                            &nbsp;
                            <input type="radio" class="form-check-input" name="sex" id="Female" value="Female">
                            <label for="female" class="form-input-label">Female</label>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <p class="text-center fs-4 fw-semibold">Tricyle Information</p>
                <div class="form-group row" style="margin-bottom:20px">
                    <div class="col-md-6">
                        <label for="driver1_name" class="form-label fw-semibold">Registered Driver #1</label>
                        <input type="text" class="form-control" name="driver1_name" placeholder="Pedro A. Ruiz">
                    </div>
                    <div class="col-md-6">
                        <label for="driver2_name" class="form-label fw-semibold">Registered Driver #2</label>
                        <input type="text" class="form-control" name="driver2_name" placeholder="Rolan O. Santos">
                    </div>
                </div>

                <div class="form-group row" style="margin-bottom:20px">
                    <div class="col-md-4">
                        <label for="tricTColor" class="form-label fw-semibold">Tricycle Color</label>
                        <input type="text" class="form-control" name="tricColor" placeholder="Blue Stainless">
                    </div>
                    <div class="col-md-4" style="margin-bottom:20px">
                        <label for="tricType" class="form-label fw-semibold">Vehicle Type</label>
                        <br>
                        <select id="tricType" name="tricType" class="form-control rounded" required>
                            <option value="">Select</option>
                            <option value="Tricycle">Tricycle</option>
                            <option value="Tuktuk">Tuktuk</option>
                        </select>
                    </div>

                    <div class="col-md-4" style="margin-bottom:20px">
                        <label for="toda" class="form-label fw-semibold">TODA</label>
                        <br>
                        <select id="toda" name="toda" class="form-control rounded" required>
                            <option value="">Select TODA</option>
                            <option value="Not a member of Toda">Not a member of Toda</option>
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
                </div> 

                <br>
                <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-primary" id="step1NextBtn" onclick="nextStep()">
                            Next <i class="fa-solid fa-forward"></i>
            </div>
            </div>
            
            
                <!-- Step 2 -->
                <div class="step-content" id="step2" style="display:none;">
                    <div class="tricycle-unit row g-2">
                        <div class="card">
                        <p class="text-center fs-4 fw-semibold">Tricycle Unit Requirements</p>
                        
                        <div class="form-group row" style="margin-bottom:20px;">
                            <div class="form-group row" style="margin-bottom:20px;">
                                <div class="col-md-6">
                                    <label for="cr" class="form-label fw-semibold">(CR) Certificate of Registration from LTO</label>
                                    <input class="form-control mb-2" type="file" id="cr" name="cr" accept="image/*, .pdf"
                                        onchange="return fileValidation(this)" required>
                                    <div id="preview1" class="image-preview"></div>
                                </div>
                            
                                <div class="col-md-6">
                                    <label for="deedSale" class="form-label fw-semibold mt-0">Deed of Sale (Notarized)</label>
                                    <input class="form-control mb-2" type="file" id="deedSale" name="deedSale" accept="image/*, .pdf"
                                        onchange="return fileValidation(this)">
                                    <div id="preview2" class="image-preview"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row" style="margin-bottom:20px;">
                            <div class="col-md-6">
                                <label for="or" class="form-label fw-semibold mt-0 mb-0">(OR) Official Receipt from LTO </label>
                                <small class="form-text text-muted mt-0" style="font-size: 0.75rem; color: #6c757d; margin-top: 0;">
                                    (If not updated, Fill up Promissory Note)
                                </small>
                                <input class="form-control mb-2" type="file" id="or" name="or" accept="image/*, .pdf"
                                    onchange="return fileValidation(this)" required>
                                <div id="preview3" class="image-preview"></div>
                            </div>
                         

                            <div class="col-md-6">
                                <label for="tricyclePics" class="form-label fw-semibold mt-0 mb-0"> Tricycle Pictures </label>
                                <small class="form-text text-muted mt-0"> (Front - Side - Back- Inside) </small>
                                <input class="form-control mb-2" type="file" id="tricyclePics" name="tricyclePics[]" accept=".jpeg, .png"
                                    onchange="return fileValidation(this)" multiple required>
                                <div id="preview4" class="image-preview"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                    <div class="tricycle-unit row g-2">
                        <div class="card">
                        <p class="text-center fs-4 fw-semibold">Operator Requirements</p>

                        <div class="form-group row" style="margin-bottom:20px;">
                            <div class="col-md-6">
                                <label for="operatorsPic" class="form-label fw-semibold mb-0">Operator Picture</label>
                                <small class="form-text text-muted mt-0">(1pc.size 2x2)</small>
                                <input class="form-control mb-1" type="file" id="operatorsPic" name="operatorsPic" accept=".jpeg, .png"
                                    onchange="return fileValidation(this)" required>
                                <div id="preview5" class="image-preview"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="sedula" class="form-label fw-semibold mt-0 mb-0">Sedula</label>
                               <small class="form-text text-muted mt-0">(Must be issue in the last 6 months)</small>
                                <input class="form-control mb-1" type="file" id="sedula" name="sedula" accept="image/*, .pdf"
                                    onchange="return fileValidation(this)" required>
                                <div id="preview6" class="image-preview"></div>
                            </div>
                        </div>
                        <div class="form-group row" style="margin-bottom:20px;">
                            <div class="col-md-6">
                                <label for="toda_cert" class="form-label fw-semibold mt-0">TODA Certificate</label>
                                <input class="form-control mb-1" type="file" id="toda_cert" name="toda_cert" accept="image/*, .pdf"
                                    onchange="return fileValidation(this)" required>
                                <div id="preview7" class="image-preview"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="valid_id" class="form-label fw-semibold mt-0">PSA /  Voter's ID</label>
                                <input class="form-control mb-1" type="file" id="valid_id" name="valid_id" accept="image/*, .pdf"
                                    onchange="return fileValidation(this)" required>
                                <div id="preview8" class="image-preview"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                    <div class="tricycle-unit row g-2">
                        <div class="card">
                        <p class="text-center fs-4 fw-semibold">Driver Requirements</p>

                        <div class="form-group row" style="margin-bottom:20px;">
                            <div class="col-md-6">
                                <label for="driversPic1" class="form-label fw-semibold mb-0">Driver Picture #1</label>
                                <small class="form-text text-muted mt-0">(Size 2x2)</small>
                                <input class="form-control mb-1" type="file" id="driversPic1" name="driversPic1" accept=".jpeg, .png"
                                    onchange="return fileValidation(this)" required>
                                <div id="preview9" class="image-preview"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="driversPic2" class="form-label fw-semibold mt-0 mb-0">Driver Picture #2 </label>
                                <small class="form-text text-muted mt-0">(Size 2x2)</small>
                                <input class="form-control mb-1" type="file" id="driversPic2" name="driversPic2" accept=".jpeg, .png"
                                    onchange="return fileValidation(this)" required>
                                <div id="preview10" class="image-preview"></div>
                            </div>
                        </div>
                        <div class="form-group row" style="margin-bottom:20px;">
                            <div class="col-md-6">
                                <label for="license" class="form-label fw-semibold mt-0">Professional Driver’s
                                    License</label>
                                <input class="form-control mb-1" type="file" id="license"  name="license" accept=".jpeg, .png"
                                    onchange="return fileValidation(this)" required>
                                <div id="preview11" class="image-preview"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="med_res" class="form-label fw-semibold mt-0">Medical Result / Health Card</label>
                                <input class="form-control mb-1" type="file" id="med_res"  name="med_res" accept="image/*, .pdf"
                                    onchange="return fileValidation(this)" required>
                                <div id="preview12" class="image-preview"></div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-secondary" id="step1BackBtn" onclick="prevStep()" disabled>
                            <i class="fa-solid fa-left"></i> Back
                        </button>
                        <button type="button" class="btn btn-primary" id="step1NextBtn" onclick="nextStep()">
                            Next <i class="fa-solid fa-forward"></i>
                        </button>
                        </div>
                    </div> 
            </div>
            
                <!-- Step 3 -->
                <div class="step-content" id="step3" style="display:none;">
                    <div class="tricycle-unit row g-2">
                        <div class="card">
                        <div class="form-group row" style="margin-bottom:20px;">
                            <p class="text-center fs-4 fw-semibold">Account Information</p>
                            <div class="col-md-12">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="example@gmail.com" required>
                            </div>
                     
                           <div class="form-group row" style="margin-bottom:20px;">
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
                    </div>
                </div>
                    <br>
                    <div class="container form-container g-3">
                        <p class="fs-6 fw-semibold">Data Privacy Act Acknowledgment</p>
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
                                the deletion of your personal data. For any concerns, View the contact information in the MTFRB Lucban website .</li>
                        </ul>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="privacyActCheck" required>
                            <label class="form-check-label" for="privacyActCheck">
                                I agree to the Data Privacy Act
                            </label>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" id="step3BackBtn" onclick="prevStep()">
                        <i class="fa-solid fa-left"></i> Back
                    </button>
                    <button type="submit" class="btn btn-primary" name="submit">Submit <i class="fa-solid fa-right-to-bracket" style="color: #fff"></i></button>
                    </button>
                    
                </div>
                </div>
                
            </form>
        </div>
    </section>
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
    <style>
        .is-invalid {
            border-color: #dc3545;
            padding-right: calc(1.5em + .75rem);
        }
        .form-text.text-danger {
            color: #dc3545;
        }
    </style>
   
 
   <script src="assets/js/application-form.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
    <script src="assets/js/translate.js"> </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <?php include "scripts.php";?>
</body>


</html>