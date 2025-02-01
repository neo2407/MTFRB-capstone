<?php 
    include "superAdminLog_functions.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Form</title>
   
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/superAdmin.css">
    <style>


    </style>
</head>
<body>
    <div class="container ">
        <div class="row">
            <div class="col-md-4 offset-md-4 form login-form light bg-primary">
                <form action="superAdmin_login.php" method="POST" autocomplete="">
                    <h2 class="text-center text-color secondary">Login Form</h2>
                    <p class="text-center">Login with your email and password.</p>
                    <?php if(count($errors) > 0): ?>
                        <div class="alert alert-danger text-center">
                            <?php foreach($errors as $error): ?>
                                <?php echo $error; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <input class="form-control" type="email" name="email" placeholder="Email Address" required value="<?php echo isset($email) ? $email : ''; ?>">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="link forget-pass text-center"><a href="forgot-password.php">Forgot password?</a></div>
                    <div class="form-group">
                        <input class="form-control button" type="submit" name="login" value="Login">
                    </div>
                    <!--<div class="link login-link text-center">Not yet a member? <a href="signup-user.php">Signup now</a></div>-->
                </form>
            </div>
        </div>
    </div>
</body>
</html>
