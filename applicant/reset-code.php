<?php include "applicantLog_functions.php"; ?>
<?php 
$email = $_SESSION['email'];
if($email == false){
  header('Location: applicant_login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Code Verification</title>
    <link rel="icon" href="../assets/img/mtfrbLogo.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet"  href="assets/css/forgotpass.css">>
</head>
<body>
    <div class="box">
    <form action="#" method="post">
        <h1 class="form-title">Code Verification</h1>
        <p class="form-description">Check your email and enter the verification code in the form field.</p>
                <?php 
                    if(isset($_SESSION['info'])){
                        ?>
                        <div class="alert alert-success text-center" style="padding: 0.4rem 0.4rem">
                            <?php echo $_SESSION['info']; ?>
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                    if(count($errors) > 0){
                        ?>
                        <div class="alert alert-danger text-center">
                            <?php
                            foreach($errors as $showerror){
                                echo $showerror;
                            }
                            ?>
                        </div>
                        <?php
                    }
                ?>
            <input  type="number" name="otp" placeholder="xxxxxx"><br>

            <button type="submit" type="submit" name="check-reset-otp">Continue</button>

    </form>
</div>
    <script src="assets/js/translate.js"> </script>
    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</body>
</html>