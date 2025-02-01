<?php 

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <!-- Bootstrap -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   <link rel="shortcut icon" type="image/x-icon" href="../assets/img/MTFRBLogo.png">
   <title> MTFRB LUCBAN</title>

<!-- nav css
 padding top right bottom left
-->
<style>
    .custom-nav {
      background-color: #1e73da;
      padding: 20px 50px 10px 50px;
      margin: -10px;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-light justify-content-flex margin-left=10px fs-3 mb-5 custom-nav">
     <b>MTFRB LUCBAN</b> 
     
  </nav>

   <div class="container">
      <div class="text-center mb-4">
         <h3>Complaints Form</h3>
         <p class="text-muted">Complete the form below to file a complaint</p>
      </div>

      <div class="container d-flex justify-content-center">
         <form action="complaintsAdmin.php" method="post" enctype="multipart/form-data" style="width:50vw; min-width:300px;">
            <div class="row mb-3">
            <h5>Complainant Information</h5>
               <div class="col">
                  <label class="form-label">First Name:</label>
                  <input type="text" class="form-control" name="first_name" placeholder="Juan" required>
               </div>

               <div class="col">
                  <label class="form-label">Last Name:</label>
                  <input type="text" class="form-control" name="last_name" placeholder="Dela Cruz"  required>
               </div>

            </div>
            <div class="row mb-3">
               <div class="col">
                  <label class="form-label">Email:</label>
                  <input type="text" class="form-control" name="email" placeholder="example@gmail.com"  required>
               </div>

               <div class="col">
                  <label class="form-label">Mobile Number</label>
                  <input type="text" class="form-control" id="contactNum" name="contactNum" placeholder="09xxxxxxxxx" required>
                    <span id="contactError" style="color: red; display: none;">Contact number must be exactly 11 digits and contain only numbers.</span>
               </div>

            </div>

            <br>
            <div class="row mb-3">
               <h5>Complaint Details</h5>
               <div class="col">
                  <label class="form-label">Date and Time of Complaint</label>
                  <input type="datetime-local" class="form-control" name="dateOfincident" placeholder="" required>
               </div>

               <div class="col">
               <label class="form-label">Reason for Complaint:</label>
               <input type="text" class="form-control" name="descOfincident" placeholder="Type your complaint here" required>
              </div>
            </div>
            <br>
            <div class="row mb-3">
               <h5>Tricycle Information</h5>
               <div class="col">
                  <label class="form-label">Tricycle Franchise #</label>
                  <input type="text" class="form-control" name="TFno" placeholder=" (if known)">
               </div>

               <div class="col">
               <label class="form-label">Color of Tricycle:</label>
               <input type="text" class="form-control" name="colorOftric" placeholder="Type the color of ther tricycle"required>
              </div>

              <div class="col">
              <label class="form-label">Made of:</label>
              <select id="madeOf" name="madeOf" style="width: 250px; padding: 8px; font-size:16px;" required>
                     <option value="">Select</option>
                     <option value="tricycle">Tricycle</option>
                     <option value="tuktuk">TukTuk</option>
                     
                   </select>
              </div>
           

            <div class="row mb-3">
               <div class="col">
                  <label class="form-label">Drivers Description</label>
                  <input type="text" class="form-control" name="descOfdriver" placeholder="Type the drivers description here"required>
               </div>

               <div class="col">
               <label class="form-label">Supporting Evidence:</label>
                  <input type="file" class="form-control" name="evidence" accept="image/*,video/*" required>
               </div>
              </div>
            </div>
            
            <br>
            <div class="row mb-3">
               <h5>Follow-up Preferences</h5>
               <div  style="width: 400px; padding: 8px; font-size: 14px;">
                  <label class="form-label">Preffered Date and Time for Contact</label>
                  <input type="datetime-local" class="form-control" name="dtOfcontact" placeholder="Type the drivers description here"required>
               </div>

            <div>
               <button type="submit" class="btn btn-success" name="submit">Submit</button>
               <a href="complaintsList.php" class="btn btn-danger">Cancel</a>
            </div>
         </form>
      </div>
   </div>

   <!-- Bootstrap -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
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
   <?php include "../../include/scripts.php";?>
</body>

</html>