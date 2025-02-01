
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Include SweetAlert2 -->
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
                <h3 class="mb-3">Thank you for submitting your complaint!</h3>
                <p>We will be validate your complaint, And once validated we will send you an interview schedule via SMS or email</p>
                <p >Please come on time on your scheduled interview. Our office is located at 88 A. Racelis Ave, Lucban, 4328 Quezon, 3rd floor of Lucban Municipal Hall</p>
                <p class="text-muted">For any further inquiries, feel free to contact us at <a href="mailto:avenbince@gmail.com">avenbince@gmail.com</a> or (042) 540-2261</p>

            </div>

            <div class="text-center back-button">
                <a href="index.php" data-mdb-button-init data-mdb-ripple-init class="back-btn btn btn-lg"
                    type="submit">Back to Home</a>
            </div>
            <br>
    <p class="small pb-lg-2 text-center">
    <?php
        $TFno = isset($_GET['TFno']) ? htmlspecialchars($_GET['TFno']) : '';
    ?>
  <a class="driver_ratings" href="drivers_ratings.php?TFno=<?= urlencode($TFno) ?>" style="font-size: 18px; color: #2680C2;">
    Want to Rate the Driver?
</a>

</p>


        </form>
    </div>


</body>

<!--<?php include "scripts.php"?>-->


</html>