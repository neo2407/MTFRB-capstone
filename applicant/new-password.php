<?php  include "applicantLog_functions.php";?>
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
    <title>Create a New Password</title>
    <link rel="icon" href="../assets/img/mtfrbLogo.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
    <link rel="stylesheet"  href="assets/css/forgotpass.css">
</head>
<body>
<div class="box">
    <form action="new-password.php" method="POST" autocomplete="off">
        <h1 class="form-title">New Password</h1>
        <?php 
                    if(isset($_SESSION['info'])){
                        ?>
                        <div class="alert alert-success text-center">
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
        <div class="form-group">
            <input class="form-control" type="password" name="password" placeholder="Create new password" required>
        </div>
        <div class="form-group">
            <input class="form-control" type="password" name="cpassword" placeholder="Confirm your password" required>
        </div>
        <div class="form-group">
            <button type="submit"  type="submit" name="change-password" >Submit</button>
        </div>
    </form>
</div>
    
    <script src="assets/js/translate.js"> </script>
    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</body>
</html>