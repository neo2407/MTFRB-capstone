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
  

   <div class="container">
      <div class="text-center mb-4">
         <h3>Application Form for Tricycle Franchise</h3>
         <p class="text-muted">Complete the form below to apply</p>
      </div>

      <div class="container d-flex justify-content-center">
         <form action="add_Applicant.php" method="post" enctype="multipart/form-data" style="width:50vw; min-width:300px;">
            <div class="row mb-3">
               <div class="col">
                  <label class="form-label">First Name:</label>
                  <input type="text" class="form-control" name="first_name" placeholder="">
               </div>

               <div class="col">
                  <label class="form-label">Last Name:</label>
                  <input type="text" class="form-control" name="last_name" placeholder="">
               </div>

               <div class="col">
                  <label class="form-label">Middle  Name:</label>
                  <input type="text" class="form-control" name="m_name" placeholder="">
               </div>

            </div>

            <div class="row mb-3">
               <div class="col">
                  <label class="form-label">Birth Date:</label>
                  <input type="date" class="form-control" name="b_date" placeholder="">
               </div>

               <div class="col">
                  <label class="form-label">Age:</label>
                  <input type="number" class="form-control" name="age" placeholder="">
               </div>

               <div class="col">
                  <label class="form-label">Address:</label>
                  <input type="text" class="form-control" name="address" placeholder="">
               </div>

            </div>

            <div class="row group mb-3">
               <div class="col">
               <label>Gender:</label>
               &nbsp;
               <input type="radio" class="form-check-input" name="sex" id="male" value="male">
               <label for="male" class="form-input-label">Male</label>
               &nbsp;
               <input type="radio" class="form-check-input" name="sex" id="female" value="female">
               <label for="female" class="form-input-label">Female</label>
               </div>
               

            </div>

            <div class="row mb-3">
               <div class="col">
                  <label class="form-label">Email:</label>
                  <input type="text" class="form-control" name="email" placeholder="">
               </div>

               <div class="col">
                  <label class="form-label">Contact Number:</label>
                  <input type="text" class="form-control" name="contact_num" placeholder="">
               </div>
               <div class="col">
                  <label class="form-label">Password</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="">
               </div>

               <div class="col">
                  <label class="form-label">Confirm Password</label>
                  <input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder="">
               </div>

            </div>

            
            <div class="row mb-3">
               <div class="col">
                  <label class="form-label">Register Driver 1:</label>
                  <input type="text" class="form-control" name="driver1_name" placeholder="">
               </div>

               <div class="col">
                  <label class="form-label">Registered Driver 2:</label>
                  <input type="text" class="form-control" name="driver2_name" placeholder="">
               </div>

            </div>
           
            <div class="row mb-3">
               <div class="col">
                  <label class="form-label">Tricyle Color:</label>
                  <input type="text" class="form-control" name="tricColor" placeholder="">
               </div>

               <div class="col">
               <label for="tricType">Vehicle Type</label>
               <br>
                    <select id="tricType" name="tricType"  required>
                        <option value="">Select </option>
                        <option value="Tricycle">Tricycle</option>
                        <option value="Tuktuk">Tuktuk</option>
                    </select>
               </div>

               <div class="col">
               <label for="toda">TODA</label>
               <br>
                    <select id="toda" name="toda"  required>
                        <option value="">Select TODA</option>
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
            
            <div class="row mb-3">
               <div class="col">
                  <label class="form-label">Operators Picture</label>
                  <input type="file" class="form-control-file form-control" name="operatorsPic" accept="image/*"required>
               </div>

               <div class="col">
                  <label class="form-label">Toda Cert</label>
                  <input type="file" class="form-control-file form-control" name="toda_cert" accept="image/*, .pdf" required>
               </div>
               
               <div class="col">
               <label class="form-label">PSA/Voter Cert/ID</label>
               <input type="file" class="form-control-file form-control" name="valid_id" accept="image/*, .pdf" required>
             </div>
               <div class="col">
                  <label class="form-label">Sedula</label>
                  <input type="file" class="form-control-file form-control" name="sedula" accept="image/*, .pdf" required>
               </div>
            </div>

            <div class="row mb-3">
             

               <div class="col">
                  <label class="form-label">CR</label>
                  <input type="file" class="form-control-file form-control" name="cr" accept="image/*, .pdf" required>
               </div>

               <div class="col">
                  <label class="form-label">OR</label>
                  <input type="file" class="form-control-file form-control" name="or" accept="image/*, .pdf" required>
               </div>
               
               <div class="col">
               <label class="form-label">Tricycle Pictures</label>
               <input type="file" class="form-control" name="tricyclePics[]" multiple accept="image/*" />
               </div>

               <div class="col">
                  <label class="form-label">Deed of Sale</label>
                  <input type="file" class="form-control-file form-control" name="deedSale" accept="image/*, .pdf" required>
               </div>

            </div>

            <div class="row mb-3">
             

            <div class="col">
                  <label class="form-label">Driver Picture 1</label>
                  <input type="file" class="form-control-file form-control" name="driversPic1" accept="image/*"required>
               </div>

               <div class="col">
                  <label class="form-label">Driver Picture 2</label>
                  <input type="file" class="form-control-file form-control" name="driversPic2" accept="image/*"required>
               </div>
               
            
               <div class="col">
                  
                  <label class="form-label">Med Cert</label>
                  <input type="file" class="form-control-file form-control" name="med_res" accept="image/*, .pdf" required>
               </div>

               <div class="col">
                     <label class="form-label">License</label>
                     <input type="file" class="form-control-file form-control" name="license" accept="image/*, .pdf" required>
                  </div>

            </div>

            <div>
               <button type="submit" class="btn btn-success" name="submit">Submit</button>
               <a href="listApplicants.php" class="btn btn-danger">Cancel</a>
            </div>
         </form>
      </div>
   </div>

   
   <script>
   document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirm-password');

        function checkPasswordMatch() {
            if (passwordInput.value === confirmPasswordInput.value && passwordInput.value !== '' && confirmPasswordInput.value !== '') {
                passwordInput.style.backgroundColor = '#d4edda';  // Light green background
                confirmPasswordInput.style.backgroundColor = '#d4edda';  // Light green background
                confirmPasswordInput.placeholder = 'Passwords match';  // Show message inside field
                confirmPasswordInput.style.color = 'green';  // Change text color to green
            } else {
                passwordInput.style.backgroundColor = '';  // Reset background
                confirmPasswordInput.style.backgroundColor = '';  // Reset background
                confirmPasswordInput.placeholder = 'Passwords must match';  // Show error message inside field
                confirmPasswordInput.style.color = 'black';  // Change text color to red
            }
        }

        passwordInput.addEventListener('input', checkPasswordMatch);
        confirmPasswordInput.addEventListener('input', checkPasswordMatch);
    });
</script> 
   <!-- Bootstrap -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
   <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>'
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
   <?php include "../include/scripts.php";?>
</body>

</html>