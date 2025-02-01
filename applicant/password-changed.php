<?php  include "applicantLog_functions.php"; ?>
<?php
if($_SESSION['info'] == false){
    header('Location:applicant_login.php');  
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Form</title>
    <link rel="icon" href="../assets/img/mtfrbLogo.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet"  href="assets/css/forgotpass.css">>
</head>
<body>
    
<div class="box">
    
         <form action="applicant_login.php" method="POST">
            <h1 class="form-title">Password Changed</h1>
            <?php 
            if(isset($_SESSION['info'])){
                ?>
                <div class="alert alert-success text-center">
                <?php echo $_SESSION['info']; ?>
                </div>
                <?php
            }
            ?>
            <div class="form-group">
            <button type="submit" type="submit" name="login-now" >Login Now</button>
        </div>
    </form>
</div>  

    <script src="assets/js/translate.js"> </script>
    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</body>
</html>