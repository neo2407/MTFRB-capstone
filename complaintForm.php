<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Form</title>
    <link rel="icon" href="assets/img/mtfrbLogo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="assets/css/form.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-light shadow-sm p-3 mb-0 bg-white">
        <div class="container-lg">
            <a class="navbar-brand" href="index.php">
                <img src="assets/img/MTFRB Lucban.jpg" class="logo-pic" alt="Logo of MTFRB Lucban">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="modal" data-bs-target="#navModal">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                <div id="google_translate_element"></div> 
                    <li class="nav-item">
                        <a href="index.php" class="btn btn-primary">Home</a>
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
                        <li class="nav-item">
                            <a class="nav-link" href="#">Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <section class="Form d-flex justify-content-center">
        <div class="content">
            <form action="complaintsUser.php" id="complaint_form" method="post" enctype="multipart/form-data"
                class="complaint-form row g-3 w-75 mx-auto">
                <p class="text-center fs-3 fw-semibold">
                    File a Complaint
                </p>

                <div class="border p-3 border-gray rounded">
                    <p class="fs-5 fw-semibold mt-3 mb-2">Complainant Information</p>
                <div class="form-group row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="last_name" id="l_name" placeholder="Dela Cruz" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">First Name</label>
                        <input type="text" class="form-control" name="first_name" id="f_name" placeholder="Juan" required>
                    </div>

                    <div class="col-md-4">
                        <label for="inputPassword4" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" name="m_name" id="middle_name" placeholder="Reyes" required>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label class="form-label" data-mdb-input-mask-init data-mdb-input-mask="+69">Contact
                            No</label>
                      <input type="text" class="form-control" id="contactNum" name="contactNum" placeholder="09xxxxxxxxx" required>
                    <span id="contactError" style="color: red; display: none;">Contact number must be exactly 11 digits and contain only numbers.</span>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label class="form-label" data-mdb-input-mask-init data-mdb-input-mask="+69">Email
                        </label>
                        <input type="text" class="form-control" id="_email" name="email" placeholder="example@gmail.com"
                            required>
                    </div>
                </div>
                </div>

                <div class="border p-3 border-gray rounded">
                    <p class="fs-5 fw-semibold mt-3 mb-0">Complaint Details</p>
                <div class="form-group row mb-2 mt-2">
                    <div class="col-md-5 mb-2">
                        <label class="form-label">Date and Time of Complaint</label>
                        <input type="datetime-local" class="form-control" id="dateOfincident" name="dateOfincident" required>
                    </div>
                    <div class="col-md-7">
                        <label class="form-label">Description of Complaint</label>
                        <textarea class="form-control" id="	descOfincident" name="descOfincident" rows="4"
                            placeholder="Type the reason of complaint here..." style="resize: none;"
                            required></textarea>
                    </div>
                </div>
                </div>
                
                <div class="border p-3 border-gray rounded">
                    <p class="fs-5 fw-semibold mt-4 mb-0">Tricycle Information</p>
                    <div class="form-group row mb-3 mt-3">
                        <?php
                        $TFno = isset($_GET['TFno']) ? htmlspecialchars($_GET['TFno']) : '';
                        $colorOftric = isset($_GET['colorOftric']) ? htmlspecialchars($_GET['colorOftric']) : '';
                        $madeOf = isset($_GET['madeOf']) ? htmlspecialchars($_GET['madeOf']) : '';
                        ?>
                        
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Tricycle Franchise No.</label>
                            <input type="number" class="form-control" id="TFno" name="TFno" 
                                   placeholder="Type the Tricycle Franchise No." value="<?= $TFno ?>" required>
                        </div>
                        
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Tricycle Color</label> 
                            <input type="text" class="form-control" id="colorOftric" name="colorOftric" 
                                   placeholder="Blue" value="<?= $colorOftric ?>" required>
                        </div>
                        
                        <div class="col-md-4 mb-2">
                            <label for="madeOf" class="form-label">Body Built</label>
                            <select id="madeOf" name="madeOf" class="form-control rounded" required>
                                <option value="">Select</option>
                                <option value="Tricycle" <?= $madeOf == "Tricycle" ? 'selected' : '' ?>>Tricycle</option>
                                <option value="Tricycle(Back-to-Back)" <?= $madeOf == "Tricycle(Back-to-Back)" ? 'selected' : '' ?>>Tricycle(Back-to-Back)</option>
                                <option value="Tuktuk" <?= $madeOf == "Tuktuk" ? 'selected' : '' ?>>Tuktuk</option>
                            </select>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label class="form-label">Driver Description</label>
                            <textarea class="form-control" id="descOfdriver" name="descOfdriver" rows="4"
                                placeholder="Type the decription of the driver here..." style="resize: none;"
                                required></textarea>
                        </div>
                    </div>
                </div>

                <div class="border p-3 border-gray rounded">
                    <div class="mb-2">
                        <div class="form-group row mb-2">
                            <div class="col-md-6">
                                <p class="fs-6 fw-semibold mt-4 mb-1">Supporting Evidence</p>
                                <label for="filePath"></label>
                                <input type="file" class="form-control-file" id="file" name="evidence"
                                    accept="image/*,video/*" onchange="return fileValidation()" required>
                                <div id="imagePreview" class="imagePreview"></div>
                            </div>
                            <div class="col-md-5">
                                <p class="fs-6 fw-semibold mt-4 mb-0">Follow-Up Preferences</p>
                                <small class="text-muted">Preffered Date and Time for Contact</small>
                                <input type="datetime-local" class="form-control" id="dtOfcontact" name="dtOfcontact" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row mt-3 mb-2 mx-auto">
                    <div class="col-md-12 Note">
                        <small><strong><i class="fa fa-exclamation-circle"></i></strong>
                            Please ensure that you are available for contact during your
                            selected date. MTFRB office hours are from
                            8:00 AM to 5:00 PM. We are unable to make calls in the evening.</small>
                    </div>
                </div>
                <button type="submit" name="submit" class="btn btn-warning">Submit</button>
            </form>
        </div>

       <!-- Data Privacy Act Modal -->
        <div class="modal fade" id="privacyModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="privacyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="width: 90%; max-width: 500px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="privacyModalLabel">Data Privacy Act Acknowledgment</h5>
                    </div>
                    <div class="modal-body">
                        <p>Note: Your privacy is important to us. By proceeding with this application, you acknowledge
                            and agree to the following:</p>
                        <ul>
                            <li><strong>Data Collection and Usage:</strong> We collect your personal information to
                                process your complaint and for related administrative purposes.</li>
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
        <script>
        // Show the modal when the page loads if not previously accepted
        document.addEventListener("DOMContentLoaded", function() {
            var privacyModal = new bootstrap.Modal(document.getElementById('privacyModal'));
            var checkbox = document.getElementById('privacyActCheck');
            var acceptButton = document.getElementById('privacyAcceptButton');
        
            // Check if the user has already accepted the privacy policy
            if (!localStorage.getItem('privacyAccepted')) {
                privacyModal.show();
            }
        
            // Enable the "Accept and Continue" button when the checkbox is checked
            checkbox.addEventListener('change', function() {
                acceptButton.disabled = !checkbox.checked;
            });
        
            // Close the modal and save acceptance status
            acceptButton.addEventListener('click', function() {
                if (checkbox.checked) {
                    localStorage.setItem('privacyAccepted', 'true'); // Save acceptance in localStorage
                    privacyModal.hide();
                } else {
                    alert("Please agree to the Data Privacy Act before proceeding.");
                }
            });
        });
        </script>
    </section>
    <script src="assets/js/complaint-form.js"></script>

  
<script>
document.getElementById('contactNum').addEventListener('input', function () {
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

 <script>
   // Function to save form data to localStorage on input
document.getElementById('complaint_form').addEventListener('input', function (e) {
   // console.log('Storing:', e.target.id, e.target.value); // Debugging
    localStorage.setItem(e.target.id, e.target.value);
});

// Function to load form data from localStorage on page load
window.onload = function () {
    const formElements = document.querySelectorAll('#complaint_form input, #complaint_form select, #complaint_form textarea');
    
    formElements.forEach(function (element) {
        const storedValue = localStorage.getItem(element.id);
        if (storedValue) {
            element.value = storedValue; // Only populate if localStorage has data
        }
    });
};

// Clear localStorage and form fields after form submission
document.getElementById('complaint_form').addEventListener('submit', function (e) {
    // Prevent default form submission behavior (for testing purposes only)
    // e.preventDefault(); // Uncomment if needed to test submission logic

    // Delay the clearing process to ensure the form is submitted first
    setTimeout(() => {
        const formElements = document.querySelectorAll('#complaint_form input, #complaint_form select, #complaint_form textarea');

        formElements.forEach(function (element) {
            localStorage.removeItem(element.id); // Remove localStorage value
            element.value = ''; // Clear form field value
        });
    }, 500); // Delay to allow form submission to complete (adjust if necessary)
});
</script>
<!--<?php include "include/scripts.php";?>-->
<!-- Bootstrap JS (required) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

</body>

</html>