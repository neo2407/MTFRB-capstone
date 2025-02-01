<?php 

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Form</title>
 
    <link rel="icon" href="../../assets/img/mtfrbLogo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/845a1cacb6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link href="../../assets/css/form.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-light shadow-sm p-3 mb-0 bg-white">
        <div class="container-lg">
            <a class="navbar-brand" href="index.html">
                <img src="../../assets/img/MTFRB Lucban.jpg" class="logo-pic" alt="Logo of MTFRB Lucban">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="modal" data-bs-target="#navModal">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item ">
                        <a href="complaintsList.php" class="nav-link active" aria-current="page">Back</a>
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

    <section class="form d-flex justify-content-center">
        <div class="content">
            <form action="complaintsAdmin.php" method="post" enctype="multipart/form-data" class="complaint-form row g-3 w-75 mx-auto">
            <p class="text-center fs-3 fw-semibold">
                <i class="fas fa-exclamation-circle"></i> File a Complaint
            </p>
             <div class="card">
             
                <p class="fs-5 fw-semibold mt-3 mb-0">Complainant Information</p><br>
                    <div class="form-group row" style="margin-bottom:20px;">
                        <div class="col-md-4">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="last_name" placeholder="Dela Cruz" required>
                        </div>
                        <div class="col-md-4">
                            <label  class="form-label">First Name</label>
                            <input type="text" class="form-control" name="first_name" placeholder="Juan" required>
                        </div>
          
                    <div class="col-md-4">
                        <label for="inputPassword4" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" name="m_name" placeholder="Reyes" required>
                    </div>
                </div>
            <div class="form-group row" style="margin-bottom:20px;">
                <div class="col-md-6">
                    <label class="form-label" data-mdb-input-mask-init data-mdb-input-mask="+69">Contact
                        information</label>
                    <input type="number" class="form-control" id="contactNum" name="contactNum"  placeholder="09xxxx xxx xxxx" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label" data-mdb-input-mask-init data-mdb-input-mask="+69">Email
                        </label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="example@gmail.com" required>
                </div>
            </div>
         </div>
            <div class="card">
                <p class="fs-5 fw-semibold mt-4 mb-0">Complaint Details</p>
                <div class="form-group row" style="margin-bottom:20px;">
                    <div class="col-md-12">
                        <label class="form-label">Date and Time of Incident</label>
                        <input type="datetime-local" class="form-control" id="dateOfincident" name="dateOfincident">
                    </div>
            
                </div>
                <div class="form-group row" style="margin-bottom:20px;">
                <div class="col-md-12">
                    <label  class="form-label">Description of Incident</label>
                    <textarea class="form-control" id="	descOfincident"  name="descOfincident" rows="4"  placeholder="Type the reason of complaint here..." required></textarea >
                </div>

            </div>

            <div class="card">
                <p class="fs-5 fw-semibold mt-4 mb-0">Tricycle Information</p>
                <div class="form-group row" style="margin-bottom:20px;">
                    <div class="col-md-4">
                        <label  class="form-label">Tricycle Franchise No.</label>
                        <input type="number" class="form-control" id="TFno" name="TFno"  placeholder="Type the franchise no (if known)">
                    </div>
                    <div class="col-md-4">
                        <label  class="form-label">Tricycle Color</label>
                        <input type="text" class="form-control" id="colorOftric" name="colorOftric">
                    </div>
                    <div class="col-md-4" style="margin-bottom:20px">
                            <label for="madeOf" class="form-label fw-semibold">Tricycle Type</label>
                        
                            <select id="madeOf" name="madeOf" class="form-control rounded" required>
                                <option value="">Select</option>
                                <option value="Tricycle">Tricycle (Ordinary)</option>
                                <option value="Tuktuk">Tuktuk</option>
                        </select>
                    </div>
               
                    <div class="form-group row" style="margin-bottom:20px;">
                        <div class="col-md-12">
                            <label class="form-label">Driver Description</label>
                            <textarea class="form-control" id="descOfdriver" name="descOfdriver" rows="4"  placeholder="Type the decription of the driver here..." required></textarea >
                        </div>
                    </div>
             </div>

             <div class="card">
                    <div class="form-group row" style="margin-bottom:20px;">
                        <div class="col-md-6">
                            <p class="fs-5 fw-semibold mt-4 mb-0">Supporting Evidence</p>
                        
                            <label for="filePath"></label>
                            <input type="file" class="form-control-file" id="file" name="evidence" accept="image/*,video/*" onchange="return fileValidation()" required>
                            <div id="imagePreview" class="imagePreview"></div>
                        </div>

                        <div class="col-md-6">
                             <p class="fs-5 fw-semibold mt-4 mb-0">Follow-Up Preferences</p>
                             <label class="form-label">Preffere Date and Time for Contact</label>
                             <input type="datetime-local" class="form-control" id="dtOfcontact" name="dtOfcontact">
                        </div>
                    </div>
             </div>
             </div>
             <br><br>
               <div class="form-group row" style="margin-bottom:20px;">
                    <div class="col-md-12">
                        <p class="Note"><strong>Note:</strong> Please ensure that you are available for contact during your
                            selected date. MTFRB office hours are from
                            9:00 AM to 4:00 PM. We are unable to make calls in the evening.</p>
                    </div>
                </div>
                <button type="submit" name="submit" class="btn btn-warning">Submit</button>
            </form>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/complaint-form.js"></script>
    <?php include "../../include/scripts.php";?>
</body>

</html>