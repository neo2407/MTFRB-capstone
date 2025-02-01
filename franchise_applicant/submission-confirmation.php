
<?php
session_start(); 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Submission Complete!</title>
    <link rel="icon" href="../assets/img/MTFRB LOGO 2.png">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/css/submission.css">
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
        navbar.style.display = 'block'; 
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

    <div class="submission-content">
        <form action="" class="p-3">
            <img src="assets/img/check-mark.png" class="Logo">
            <div class="mb-md-1 mt-md-3 text-center">
                <h3 class="mb-3">Thank you for submitting your application!</h3>
                <p>We'll be in touch soon via text or email to schedule your interview. Please remember to bring all
                    required documents.</p>
                <p >To see all the Information and Files Submitted,
                Login to your account using your password and email provided in the account registration</p>
                <p class="text-muted">For any further inquiries, feel free to contact us at <a href="mailto:avenbince@gmail.com">avenbince@gmail.com</a> or (042) 540-2261</p>

            </div>

            <div class="text-center back-button">
                <a href="../index.php" data-mdb-button-init data-mdb-ripple-init class="back-btn btn btn-lg"
                    type="submit">Back to Home</a>
            </div>
        </form>
    </div>


</body>

<?php include "scripts.php"?>


</html>