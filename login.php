<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="assets/img/mtfrbLogo.png">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
 
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background: #3468C0 url('../../assets/img/bg-lucban.png') no-repeat center center fixed;
        background-size: cover;
        overflow: hidden;
    }

    .login {
        width: 100%;
        max-width: 500px;
        padding: 1rem;
        position: relative; /* Added for logo positioning */
    }

    form {
        background-color: #ffffff;
        color: #3468C0;
        border-radius: 1rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        position: relative; /* Added for proper layering */
        z-index: 1;
    }

    h2 {
        text-align: center;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .input-box {
        margin: 1rem 0;
        position: relative;
    }

    .input-box select {
        width: 100%;
        padding: 10px;
        border: 1px solid #2780c2;
        border-radius: 5px;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
    }

      .btn {
        display: block;
        width: 100%;
        padding: 10px;
        background-color: #2780c2; /* Primary button color */
        border: none;
        border-radius: 5px; /* Smooth rounded corners */
        color: white; /* White text color */
        font-size: 16px;
        font-weight: bold;
        text-align: center;
        cursor: pointer;
        margin: 20px 0; /* Top and bottom spacing */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Add a subtle shadow for contrast */
        transition: all 0.3s ease; /* Smooth hover transition */
        backdrop-filter: blur(3px); /* Slight blur effect for better readability */
        opacity: 0.95; /* Slightly transparent for a sleek look */
    }
    
    .btn:hover {
        background-color: #3468C0; /* Slightly darker blue on hover */
        opacity: 1; /* Fully opaque on hover */
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3); /* Elevated shadow on hover */
        color:#FFFFFF;
    }
    
    .btn:active {
        transform: translateY(2px); /* Pressed effect */
    }
    


    .login img.Logo {
        position: absolute;
        z-index: 0; /* Behind the form */
        opacity: 0.1; /* Lower opacity for subtle background */
        width: 100%; /* Dynamic size relative to the form */
        max-width: 330px; /* Prevent excessive scaling on large screens */
        height: auto;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        pointer-events: none; /* Ensure the image doesn’t interfere with user input */
    }

    @media (max-width: 480px) {
        .login {
            max-width: 90%;
            padding: 1rem;
        }

        h2 {
            font-size: 1.5rem;
        }

        .btn {
            font-size: 14px;
            padding: 8px;
        }

        .input-box select {
            font-size: 13px;
        }

        .login img.Logo {
            width: 100%; /* Adjust logo size for smaller screens */
            max-width: 300px; /* Limit the maximum size on very small screens */
        }
    }
</style>



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

</head>

<!--pre-loader-->
<div id="preloader">
    <img src="assets/img/output-onlinegiftools.gif" alt="Loading...">
    <p class="loading-text">Just a moment...</p>
</div>
<body>
    <div class="login">
        <form action="redirect-login.php" method="POST" autocomplete="off">
                <div class="form-content text-center">
                            <img src="assets/img/MTFRB LOGO 2.png" class="Logo">
                <h2>Login As</h2>
                <p class="text-center">Select UserType to Login</p>
                <div class="input-box">
                    <select name="user_type" id="user_type" required>
                        <option value="" disabled selected>Select</option>
                        <option value="applicant">Applicant</option>
                        <option value="tricycle_operator">Operator</option>
                    </select>
                </div>
                <button type="submit" name="check-email" class="btn">Login</button>
            </div>
        </form>
    </div>
</body>
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
</html> 

 <!--<script src="assets/js/translate.js"> </script>
    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>-->

