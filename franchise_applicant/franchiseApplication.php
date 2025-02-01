<?php
session_start(); 

$email = $_SESSION['email'];
if($email == false){
 header('Location:account-registration.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tricycle Franchise Application</title>
    <script src="https://kit.fontawesome.com/845a1cacb6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    
    <!-- Include Bootstrap CSS and JS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="icon" href="assets/img/mtfrbLogo.png">
    <link rel="stylesheet" href="assets/css/application-form.css">

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
<!--<nav class="navbar navbar-expand-md navbar-light shadow-sm p-3 mb-0 bg-white">
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
    </nav>-->
    <section class="Form d-flex justify-content-center">
        <div class="content">
        <form action="user-apply.php" id="application_form" method="post" enctype="multipart/form-data">
            <div class="stepperForm application-form row g-3  mx-auto">
            <p class="text-center fs-4 fw-semibold mb-3">
                    <img src="../assets/img/tric.jpg" alt="Tricycle Icon" style="width: 24px; height: 24px; margin-left:10px; vertical-align: middle;"> 
                           Tricycle Franchise Application
                </p>
               <!-- <div class="stepper w-75 mx-auto">
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

                    </div>-->


                <!-- Step 1 -->

                    <div class="step-content" id="step1">
                                <div class="border p-3 border-gray rounded mb-2">

                                <div class="form-group row" style="margin-bottom:20px;">
                                <p class="text-center fs-4 fw-semibold">Basic Information</p>
                                <div class="col-md-4">
                                    <label for="last_name" class="form-label fw-semibold">Last Name</label>
                                    <input type="text" class="form-control"name="last_name" 
                                        value="<?php echo isset($_SESSION['last_name']) ? $_SESSION['last_name'] : ''; ?> " 
                                        required readonly>
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="first_name" class="form-label fw-semibold">First Name</label>
                                    <input type="text" class="form-control" name="first_name" 
                                        value="<?php echo isset($_SESSION['first_name']) ? $_SESSION['first_name'] : ''; ?>" 
                                        required readonly>
                                </div>

                                <div class="col-md-4">
                                    <label for="m_name" class="form-label fw-semibold">Middle Name</label>
                                    <input type="text" class="form-control" name="m_name" 
                                        value="<?php echo isset($_SESSION['m_name']) ? $_SESSION['m_name'] : ''; ?>" 
                                        required readonly>
                                </div>
                            </div>

                        <div class="form-group row" style="margin-bottom:10px">
                            
                       
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Birth Date</label>
                                <input type="date" class="form-control" name="b_date" id="b_date" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Age</label>
                                <input type="number" class="form-control" name="age" id="age" placeholder="20" readonly>
                            </div>
                            
                         <div class="col-md-4">
                                <label for="sex" class="form-label fw-semibold">Sex</label>
                            <div class="radio-box" style="border: 1px solid #cccccc;  padding:7px; border-radius: 5px; display: flex; gap: 10px; ">
                                <div>
                                    <input type="radio" class="form-check-input" name="sex" id="Male" value="Male">
                                    <label for="Male" class="form-input-label">Male</label>
                                </div>
                                <div>
                                    <input type="radio" class="form-check-input" name="sex" id="Female" value="Female">
                                    <label for="Female" class="form-input-label">Female</label>
                                </div>
                            </div>
                        </div>
                    </div>
                        
                        <script>
                          document.getElementById('b_date').addEventListener('change', function () {
                            const today = new Date();
                            const birthDate = new Date(this.value);
                        
                            // Check if the selected date is beyond today
                            if (birthDate > today) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Invalid Birth Date',
                                    text: 'The selected birth date is invalid.',
                                    confirmButtonText: 'Okay',
                                }).then(() => {
                                    this.value = ''; // Clear the invalid date
                                    document.getElementById('age').value = ''; // Clear the age field
                                });
                                return; // Exit the function
                            }
                        
                            // Calculate age
                            let age = today.getFullYear() - birthDate.getFullYear();
                            const monthDifference = today.getMonth() - birthDate.getMonth();
                        
                            // Adjust age if the current month is before the birth month or the day has not yet passed
                            if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
                                age--;
                            }
                        
                            // Check if age is below 18
                            if (age < 18) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Age Restriction',
                                    text: 'Applicant must be at least 18 years old.',
                                    confirmButtonText: 'Okay',
                                }).then(() => {
                                    this.value = ''; // Clear the invalid date
                                    document.getElementById('age').value = ''; // Clear the age field
                                });
                                return; // Exit the function
                            }
                        
                            // Set the calculated age
                            document.getElementById('age').value = age;
                        });

                        </script>
                       

                        <div class="form-group row" style="margin-bottom:10px">
                            <div class="col-md-6">
                                <label for="contact_num" class="form-label fw-semibold">Contact Number</label>
                                <input type="text" class="form-control" name="contact_num" 
                                        value="<?php echo isset($_SESSION['contact_num']) ? $_SESSION['contact_num'] : ''; ?>" 
                                        required readonly>
                                </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input type="email" class="form-control" name="email" 
                                    value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" 
                                    required readonly>
                            </div>
                        
                        </div>

                        <div class="form-group row" style="margin-bottom:10px">
                        
                            <div class="col-md-6">
                                <label  for="street" class="form-label fw-semibold">Address</label>
                                <input type="text" class="form-control" name="street" id="street" placeholder="St./Subd/Comp" required> 
                            </div>
                            <div class="col-md-6">
                                
                                <label for="brgy" class="form-label fw-semibold"> </label>
                                  
                                    <select id="brgy" name="brgy" id="brgy" class="form-control rounded" required style="margin-top:8px;">
                                        <option value="">Select Brgy</option>
                                        <option value="BRGY. ABANG">BRGY. ABANG</option>
                                        <option value="BRGY. ALILIW">BRGY. ALILIW</option>
                                        <option value="BRGY. ATULINAO">BRGY. ATULINAO</option>
                                        <option value="BRGY. AYUTI">BRGY. AYUTI</option>
                                        <option value="BARANGAY 1">BARANGAY 1</option>
                                        <option value="BARANGAY 2">BARANGAY 2</option>
                                        <option value="BARANGAY 3">BARANGAY 3</option>
                                        <option value="BARANGAY 4">BARANGAY 4</option>
                                        <option value="BARANGAY 5">BARANGAY 5</option>
                                        <option value="BARANGAY 6">BARANGAY 6</option>
                                        <option value="BARANGAY 7">BARANGAY 7</option>
                                        <option value="BARANGAY 8">BARANGAY 8</option>
                                        <option value="BARANGAY 9">BARANGAY 9</option>
                                        <option value="BARANGAY 10">BARANGAY 10</option>
                                        <option value="BRGY. IGANG">BRGY. IGANG</option>
                                        <option value="BRGY. KABATETE">BRGY. KABATETE</option>
                                        <option value="BRGY. KAKAWIT">BRGY. KAKAWIT</option>
                                        <option value="BRGY. KALANGAY">BRGY. KALANGAY</option>
                                        <option value="BRGY. KALYAAT">BRGY. KALYAAT</option>
                                        <option value="BRGY. KILIB">BRGY. KILIB</option>
                                        <option value="BRGY. KULAPI">BRGY. KULAPI</option>
                                        <option value="BRGY. MAHABANG PARANG">BRGY. MAHABANG PARANG</option>
                                        <option value="BRGY. MALUPAK">BRGY. MALUPAK</option>
                                        <option value="BRGY. MANASA">BRGY. MANASA</option>
                                        <option value="BRGY. MAY-IT">BRGY. MAY-ITSLSU</option>
                                        <option value="BRGY. NAGSIMANO">BRGY. NAGSIMANO</option>
                                        <option value="BRGY. NALUNAO">BRGY. NALUNAO</option>
                                        <option value="BRGY. PALOLA">BRGY. PALOLA</option>
                                        <option value="BRGY. PIIS">BRGY. PIIS</option>
                                        <option value="BRGY. SAMIL">BRGY. SAMIL</option>
                                        <option value="BRGY. TIAWE">BRGY. TIAWE</option>
                                        <option value="BRGY. TINAMNAN">BRGY. TINAMNAN</option>
                                    </select> 
                            </div>
                            
                         </div>
                        </div>

                        <div class="border p-3 border-gray rounded mb-2">
                            <p class="text-center fs-4 fw-semibold">Tricycle Information</p>
                            <div class="form-group row" style="margin-bottom:10px">
                                <div class="row">
                                    <label for="d1_last_name" class="form-label fw-semibold text-center">Registered Driver
                                        #1</label>
                                        <div class="col-md-4">
                                    <label for="d1_last_name" class="form-label fw-semibold">Last Name</label>
                                    <input type="text" class="form-control" name="d1_last_name" id="d1_last_name" placeholder="Dela Cruz">
                                </div>

                                <div class="col-md-4">
                                    <label for="d1_first_name" class="form-label fw-semibold">First Name</label>
                                    <input type="text" class="form-control" name="d1_first_name" id="d1_first_name" placeholder="Juan">
                                </div>

                                <div class="col-md-4">
                                    <label for="d1_m_name" class="form-label fw-semibold">Middle Name</label>
                                    <input type="text" class="form-control" name="d1_m_name" id="d1_m_name" placeholder="Ruz">
                                </div>
                                    
                                </div>

                                <div class="row">
                                    <label for="driver1_name" class="form-label fw-semibold text-center mt-3">Registered Driver #2(Optional)</label>
                                        <div class="col-md-4">
                                            <label for="d2_last_name" class="form-label fw-semibold">Last Name</label>
                                            <input type="text" class="form-control" name="d2_last_name" id="d2_last_name" placeholder="Santos">
                                        </div>
        
                                        <div class="col-md-4">
                                            <label for="d2_first_name" class="form-label fw-semibold">First Name</label>
                                            <input type="text" class="form-control" name="d2_first_name" id="d2_first_name" placeholder="Rolan">
                                        </div>
        
                                        <div class="col-md-4">
                                            <label for="d2_m_name" class="form-label fw-semibold">Middle Name</label>
                                            <input type="text" class="form-control" name="d2_m_name" id="d2_m_name" placeholder="Ocampo">
                                        </div>
                                    
                                </div>
                            </div>

                            <div class="form-group row" style="margin-bottom:10px">
                                <div class="col-md-4 mt-2">
                                    <label for="tricColor" class="form-label fw-semibold">Tricycle Color</label>
                                    <input type="text" class="form-control" name="tricColor" id="tricColor"
                                        placeholder="Blue Stainless">
                                </div>
                                <div class="col-md-4 mt-2" style="margin-bottom:20px">
                                    <label for="tricType" class="form-label fw-semibold">Body Built</label>
                                    <br>
                                    <select id="tricType" name="tricType" id="tricType" class="form-control rounded" required>
                                        <option value="">Select</option>
                                        <option value="Tricycle">Tricycle</option>
                                        <option value="Tricycle(Back-to-Back)">Tricycle(Back-to-Back)</option>
                                        <option value="Tuktuk">Tuktuk</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mt-2" style="margin-bottom:10px">
                                    <label for="toda" class="form-label fw-semibold">TODA</label>
                                    <br>
                                    <select id="toda" name="toda" id="toda" class="form-control rounded" required>
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

                                <div class="col-md-4 mt-2">
                                    <label for="license_no" class="form-label fw-semibold">Driver's License Number</label>
                                    <input type="text" class="form-control" name="license_no" id="license_no" placeholder="Ex: D00-00-000000">
                                </div>
                                
                               

                                <div class="col-md-4 mt-2">
                                    <label for="license_exp" class="form-label fw-semibold">Driver's License Expiration</label>
                                    <input type="date" class="form-control" name="license_exp" id="license_exp" placeholder="Ex: 2025/01/05">
                                </div>

                            </div>

                        </div>
                        <div class="d-flex justify-content-end mt-1">
                            <button type="button" class="btn btn-primary" id="step1NextBtn" onclick="nextStep()">
                                Next <i class="fa-solid fa-forward"></i>
                            </button>
                        </div>
                    </div>
                  
                    <!-- Step 2 -->
                    <div class="step-content" id="step2" style="display:none;">
                        <div class="tricycle-unit row g-2">
                            <div class="border p-3 border-gray rounded mb-2">
                                <p class="text-center fs-4 fw-semibold">Tricycle Unit Requirements</p>

                                <div class="form-group row">
                                    

                                    <!--<div class="col-md-6">
                                        <label for="deedSale" class="form-label fw-semibold">Deed of Sale
                                            (Notarized)</label>
                                        <input class="form-control" type="file" id="deedSale" name="deedSale"
                                            accept="image/*, .pdf" onchange="return fileValidation(this)" >
                                        <div id="preview2" class="image-preview"></div>
                                    </div>-->

                                  <div class="col-md-6">
                                      <label for="or" class="form-label fw-semibold" style="margin-bottom:-10px;">Sales Invoice /(OR) Official Receipt from LTO</label>
                                      <br>
                                      <small class="form-text text-muted mt-0">
                                        (If not updated, Fill up Promissory Note)
                                      </small>
                                      <input class="form-control" type="file" id="or" name="or" 
                                             accept="image/*, .pdf" onchange="return fileValidation(this)" required>
                                      <div id="preview1" class="image-preview"></div>
                                    </div>
                                    
                                    
                                    
                                    <div class="col-md-6">
                                        <label for="cr" style="margin-bottom:10px;" class="form-label fw-semibold">(CR) Certificate of Registration from LTO</label>
                                        <input class="form-control" style="margin-top:15px;" type="file" id="cr" name="cr" accept="image/*, .pdf"
                                            onchange="return fileValidation(this)" required>
                                        <div id="preview3" class="image-preview"></div>
                                    </div>
                                    
                                   <!-- File Input -->
                             
                                    <div class="col-md-12">
                                      <label for="tricyclePics" class="form-label fw-semibold mt-0 mb-0"> Tricycle Pictures </label>
                                         <br>
                                        <small class="form-text text-muted mt-0"> (Upload Four Pictures)(Front - Back - Motor Side - InsideFront) </small>
                                        <br>
                                       <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">Upload Tricycle Pictures</button>
                                
                                    
                                   <!-- Preview Section -->
                                    <div id="allPreviews" class="mt-3 d-flex gap-2 flex-wrap"></div>
                                        </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="uploadModalLabel">Upload Tricycle Picture</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="uploadForm" enctype="multipart/form-data" novalidate>
                                                        <label for="tricycleImage" id="imageLabel">Upload Front Picture</label>
                                                        <input type="file" id="tricycleImage" name="tricyclePics" accept=".jpeg, .jpg, .png">
                                                        <button type="button" id="uploadBtn" class="btn btn-success mt-3">Upload</button>
                                                    </form>
                                                    <div id="preview" class="mt-3"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <script>
                                      // Steps for uploading pictures
                                    const steps = ["Front", "Back", "Motor Side", "InsideFront"];
                                    let uploadStep = 0; // Step tracker
                                    let images = {}; // Store image data
                                    
                                    document.getElementById("uploadBtn").addEventListener("click", function () {
                                        const fileInput = document.getElementById("tricycleImage");
                                        const file = fileInput.files[0];
                                    
                                        if (!file) {
                                            alert("Please select a file.");
                                            return;
                                        }
                                    
                                        const validExtensions = ["jpeg", "png", "jpg", "gif"];
                                        const fileExtension = file.name.split(".").pop().toLowerCase();
                                    
                                        if (!validExtensions.includes(fileExtension)) {
                                            alert("Invalid file type. Please upload an image file type (jpg, png, jpeg, gif).");
                                            return;
                                        }
                                    
                                        // Check if the uploadStep exceeds the number of allowed steps
                                        if (uploadStep >= steps.length) {
                                            Swal.fire({
                                                icon: "warning",
                                                title: "Upload Limit Reached",
                                                text: "You can only upload 4 pictures.",
                                                confirmButtonText: "OK",
                                            });
                                            return;
                                        }
                                    
                                        const formData = new FormData();
                                        formData.append("image", file);
                                        formData.append("step", steps[uploadStep]);
                                    
                                        // Proceed with the upload logic
                                        fetch("upload.php", {
                                            method: "POST",
                                            body: formData,
                                        })
                                            .then((response) => response.json())
                                            .then((data) => {
                                                if (data.success) {
                                                    // Handle success
                                                    images[steps[uploadStep]] = data.filename;
                                    
                                                    const previewContainer = document.getElementById("allPreviews");
                                                    const imgPreview = document.createElement("div");
                                                    imgPreview.innerHTML = `
                                                        <div class="text-center">
                                                            <small>${steps[uploadStep]}</small>
                                                            <img src="../uploads/tricyclePics/${data.filename}" alt="${steps[uploadStep]} Preview" 
                                                                 style="max-width: 100px; height: auto; margin: 5px; border: 1px solid #ddd; border-radius: 4px;">
                                                        </div>`;
                                                    previewContainer.appendChild(imgPreview);
                                    
                                                    // Move to the next step
                                                    uploadStep++;
                                                    if (uploadStep < steps.length) {
                                                        document.getElementById("imageLabel").textContent = `Upload ${steps[uploadStep]} Picture`;
                                                        fileInput.value = ""; // Clear input
                                                    } else {
                                                        // All images uploaded: close modal
                                                        document.getElementById("uploadModal").querySelector(".btn-close").click();
                                    
                                                        // Show success message with SweetAlert
                                                        Swal.fire({
                                                            icon: "success",
                                                            title: "Tricycle Pictures Uploaded",
                                                            text: "Tricycle Pictures have been uploaded successfully!",
                                                            confirmButtonText: "OK",
                                                        });
                                                    }
                                                } else {
                                                    // Show error message with SweetAlert
                                                    Swal.fire({
                                                        icon: "error",
                                                        title: "Upload Error",
                                                        text: `Error uploading image: ${data.error}`,
                                                        confirmButtonText: "OK",
                                                    });
                                                }
                                            })
                                            .catch((error) => {
                                                // Show connection error message with SweetAlert
                                                Swal.fire({
                                                    icon: "error",
                                                    title: "Connection Error",
                                                    text: "Error connecting to the server. Please try again later.",
                                                    confirmButtonText: "OK",
                                                });
                                                console.error(error);
                                            });
                                    });

                                    </script>

                              
                                
                                </div>


                            </div>
                        </div>
                        
                    <!-- Step 2 -->
                        <div class="tricycle-unit row g-2">
                            <div class="border p-3 border-gray rounded mb-2">
                                <p class="text-center fs-4 fw-semibold">Operator Requirements</p>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                    <label for="operatorsPic" class="form-label fw-semibold mb-0" style="margin-bottom:-10px;">Operator Picture</label>
                                    <small class="form-text text-muted mt-0">(1pc.size 2x2)</small>
                                    <input class="form-control mb-1" type="file" id="operatorsPic"
                                        name="operatorsPic" accept=".jpeg, .jpg, .png"
                                         onchange="validateImageSize(this)" required>
                                    <div id="preview4" class="image-preview"></div>
                                </div>
                                
                                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                <script>
                                function validateImageSize(input) {
                                    const file = input.files[0];
                                    if (file) {
                                        const img = new Image();
                                        const objectUrl = URL.createObjectURL(file);
                                
                                        img.onload = function () {
                                            const width = this.width;
                                            const height = this.height;
                                
                                            // Check if image dimensions correspond to 2x2 inches for both 96 DPI and 300 DPI
                                            const is96DPI = (width === 192 && height === 192); // 96 DPI
                                            const is300DPI = (width === 600 && height === 600); // 300 DPI
                                
                                            if (!is96DPI && !is300DPI) {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Invalid Image Dimensions',
                                                    text: `The uploaded image must be 2x2 inches.`,
                                                });
                                                input.value = ''; // Clear the input file
                                                document.getElementById('preview4').innerHTML = ''; // Clear the preview
                                            } else {
                                                // Show a preview if the image is valid
                                                const preview = document.getElementById('preview4');
                                                preview.innerHTML = `
                                                    <div style="position: relative; display: inline-block;">
                                                        <img src="${objectUrl}" alt="Image Preview" style="max-width:100%; height:auto;"/>
                                                        <button id="removeImage" style="position: absolute; top: 5px; right: 5px; background: red; color: white; border: none; font-size: 22px; width: 22px; height: 25px; padding: 0; cursor: pointer; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                            &times;
                                                        </button>
                                                    </div>
                                                `;
                                
                                                // Add event listener to the "X" button to remove the image and clear the input
                                                document.getElementById('removeImage').addEventListener('click', function () {
                                                    input.value = ''; // Clear the input file
                                                    document.getElementById('preview4').innerHTML = ''; // Clear the preview
                                                });
                                            }
                                
                                            // Revoke the object URL after preview creation
                                            URL.revokeObjectURL(objectUrl);
                                        };
                                
                                        img.onerror = function () {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Invalid File',
                                                text: 'The selected file could not be read. Please upload a valid image.',
                                            });
                                            input.value = ''; // Clear the input file
                                            document.getElementById('preview4').innerHTML = ''; // Clear the preview
                                            URL.revokeObjectURL(objectUrl);
                                        };
                                
                                        img.src = objectUrl;
                                    }
                                }


                                </script>

                                    
                                    
                                    <div class="col-md-6">
                                        <label for="valid_id" class="form-label fw-semibold mb-0">PSA / Voter's Cerification/ID</label>
                                        <input class="form-control mb-1" type="file" id="valid_id" name="valid_id"
                                            accept="image/*, .pdf" onchange="return fileValidation(this)" required>
                                        <div id="preview5" class="image-preview"></div>
                                    </div>
                                    
                                    <!--<div class="col-md-6">
                                        <label for="sedula" class="form-label fw-semibold mt-0 mb-0">Sedula</label>
                                        <small class="form-text text-muted mt-0">(Must be issue in the last 6
                                            months)</small>
                                        <input class="form-control mb-1" type="file" id="sedula" name="sedula"
                                            accept="image/*, .pdf" onchange="return fileValidation(this)" required>
                                        <div id="preview6" class="image-preview"></div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="toda_cert" class="form-label fw-semibold mt-0">TODA
                                            Certificate</label>
                                        <input class="form-control mb-1" type="file" id="toda_cert" name="toda_cert"
                                            accept="image/*, .pdf" onchange="return fileValidation(this)" >
                                        <div id="preview7" class="image-preview"></div>
                                    </div>-->
                                </div>
                            </div>
                        </div>
                        
                        <div class="tricycle-unit row g-2">
                            <div class="border p-3 border-gray rounded mb-2">
                                <p class="text-center fs-4 fw-semibold">Driver Requirements</p>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="license" class="form-label fw-semibold mt-0">Professional Driver’s
                                            License</label>
                                        <input class="form-control mb-1" type="file" id="license" name="license"
                                            accept=".jpeg, .png" onchange="return fileValidation(this)" required>
                                        <div id="preview6" class="image-preview"></div>
                                    </div>
                                     <div class="col-md-6">
                                        <label for="driversPic1" class="form-label fw-semibold mt-0">Driver Picture #1</label>
                                        <small class="form-text text-muted mt-0">(1pc 2x2)</small>
                                        <input class="form-control mb-1" type="file" id="driversPic1" name="driversPic1"
                                            accept=".jpeg, .jpg, .png" onchange="validateImageSize2(this)" required>
                                        <div id="preview7" class="image-preview"></div>
                                    </div>

                                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                <script>
                                function validateImageSize2(input) {
                                    const file = input.files[0];
                                    if (file) {
                                        const img = new Image();
                                        const objectUrl = URL.createObjectURL(file);
                                
                                        img.onload = function () {
                                            const width = this.width;
                                            const height = this.height;
                                
                                            // Check if image dimensions correspond to 2x2 inches for both 96 DPI and 300 DPI
                                            const is96DPI = (width === 192 && height === 192); // 96 DPI
                                            const is300DPI = (width === 600 && height === 600); // 300 DPI
                                
                                            if (!is96DPI && !is300DPI) {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Invalid Image Dimensions',
                                                    text: `The uploaded image must be 2x2 inches.`,
                                                });
                                                input.value = ''; // Clear the input file
                                                document.getElementById('preview7').innerHTML = ''; // Clear the preview
                                            } else {
                                                    // Show a preview if the image is valid
                                                    const preview = document.getElementById('preview7');
                                                    preview.innerHTML = `
                                                        <div style="position: relative; display: inline-block;">
                                                            <img src="${objectUrl}" alt="Image Preview" style="max-width:100%; height:auto;"/>
                                                            <button id="removeImage" style="position: absolute; top: 5px; right: -10px;background: red; color: white; border: none; font-size: 22px; width: 22px; height: 25px; padding: 0; cursor: pointer; border-radius: 50%; display: flex; align-items: center; justify-content: center;"> &times;
                                                            </button>
                                                        </div>
                                                    `;

                                                        // Add event listener to the "X" button to remove the image and clear the input
                                                        document.getElementById('removeImage').addEventListener('click', function () {
                                                            input.value = ''; // Clear the input file
                                                            document.getElementById('preview7').innerHTML = ''; // Clear the preview
                                                        });
                                                    }
                                        
                                                    // Revoke the object URL after preview creation
                                                    URL.revokeObjectURL(objectUrl);
                                                };
                                        
                                                img.onerror = function () {
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Invalid File',
                                                        text: 'The selected file could not be read. Please upload a valid image.',
                                                    });
                                                    input.value = ''; // Clear the input file
                                                    document.getElementById('preview7').innerHTML = ''; // Clear the preview
                                                    URL.revokeObjectURL(objectUrl);
                                                };
                                        
                                                img.src = objectUrl;
                                            }
                                        }


                                    </script>


                                    <!--<div class="col-md-6">
                                        <label for="driversPic2" class="form-label fw-semibold mt-0 mb-0">Driver Picture
                                            #2 </label>
                                        <small class="form-text text-muted mt-0">(Size 2x2)</small>
                                        <input class="form-control mb-1" type="file" id="driversPic2" name="driversPic2"
                                            accept=".jpeg, .png" onchange="return fileValidation(this)" required>
                                        <div id="preview10" class="image-preview"></div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="med_res" class="form-label fw-semibold mt-0">Medical Result / Health
                                            Card</label>
                                        <input class="form-control mb-1" type="file" id="med_res" name="med_res"
                                            accept="image/*, .pdf" onchange="return fileValidation(this)" >
                                        <div id="preview12" class="image-preview"></div>
                                    </div>-->
                                </div>
                            </div>
                        </div>
                        <p><i>Additional requirements that will be submitted upon request of MTFRB Staff: Deed of Sale, Tricycle Inspection, Sedula, Medical Certificate/Health Card </i></p>
                        
                         <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                   
                        <div class="button-container">
                            <button type="button" class="btn btn-secondary back-btn" id="step1BackBtn"
                                onclick="prevStep()" disabled> Back
                            </button>
                            <button type="submit" class="btn btn-primary" name="submit">Submit <i class="fa-solid fa-right-to-bracket" style="color: #fff"></i></button>
                        </div>

                    </div>

                    <!-- Step 3
                    <div class="step-content" id="step3" style="display:none;">
                        <div class="tricycle-unit row g-2">
                            <div class="border p-3 border-gray rounded mb-2">
                                <p class="text-center fs-4 fw-semibold">Driver Requirements</p>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="driversPic1" class="form-label fw-semibold mb-0">Driver Picture#1</label>
                                        <small class="form-text text-muted mt-0">(Size 2x2)</small>
                                        <input class="form-control mb-1" type="file" id="driversPic1" name="driversPic1"
                                            accept=".jpeg, .png" onchange="return fileValidation(this)" required>
                                        <div id="preview9" class="image-preview"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="driversPic2" class="form-label fw-semibold mt-0 mb-0">Driver Picture
                                            #2 </label>
                                        <small class="form-text text-muted mt-0">(Size 2x2)</small>
                                        <input class="form-control mb-1" type="file" id="driversPic2" name="driversPic2"
                                            accept=".jpeg, .png" onchange="return fileValidation(this)" required>
                                        <div id="preview10" class="image-preview"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="license" class="form-label fw-semibold mt-0">Professional Driver’s
                                            License</label>
                                        <input class="form-control mb-1" type="file" id="license" name="license"
                                            accept=".jpeg, .png" onchange="return fileValidation(this)" required>
                                        <div id="preview11" class="image-preview"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="med_res" class="form-label fw-semibold mt-0">Medical Result / Health
                                            Card</label>
                                        <input class="form-control mb-1" type="file" id="med_res" name="med_res"
                                            accept="image/*, .pdf" onchange="return fileValidation(this)" >
                                        <div id="preview12" class="image-preview"></div>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                  
                </div>
            </form>
        </div>
    </section>
    
    
    <style>
        .is-invalid {
            border-color: #dc3545;
            padding-right: calc(1.5em + .75rem);
        }
        .form-text.text-danger {
            color: #dc3545;
        }
    </style>
<style> 
    .btn.btn-white {
        height:40px;
    }
    </style>
    
  <script>
   // Function to save form data to localStorage on input
document.getElementById('application_form').addEventListener('input', function (e) {
   // console.log('Storing:', e.target.id, e.target.value); // Debugging
    localStorage.setItem(e.target.id, e.target.value);
});

// Function to load form data from localStorage on page load
window.onload = function () {
    const formElements = document.querySelectorAll('#application_form input, #application_form select');

    formElements.forEach(function (element) {
        // Skip file inputs
        if (element.type === "file") {
            return;
        }

        const storedValue = localStorage.getItem(element.id);
        if (storedValue) {
            element.value = storedValue; // Populate only if localStorage has data
        }
    });
};


// Clear localStorage and form fields after form submission
document.getElementById('application_form').addEventListener('submit', function (e) {
    // Prevent default form submission behavior (for testing purposes only)
    // e.preventDefault(); // Uncomment if needed to test submission logic

    // Delay the clearing process to ensure the form is submitted first
    setTimeout(() => {
        const formElements = document.querySelectorAll('#application_form input, #application_form select');

        formElements.forEach(function (element) {
            localStorage.removeItem(element.id); // Remove localStorage value
            element.value = ''; // Clear form field value
        });
    }, 500); // Delay to allow form submission to complete (adjust if necessary)
});
</script>



   <script src="assets/js/application-form.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
    <script src="assets/js/translate.js"> </script>
    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    <?php include "scripts.php";?>
   
</body> 


</html>