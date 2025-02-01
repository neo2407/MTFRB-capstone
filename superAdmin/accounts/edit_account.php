<?php

   include "../include/headerAdmin.php";
   include "../include/navbarAdmin.php";
   include "function_accounts.php";
  

if (isset($_GET['id'])) {
    // Decode the ID
    $encoded_id = $_GET['id'];
    $id = base64_decode($encoded_id);

    // Validate decoded ID to ensure it's an integer
    if (filter_var($id, FILTER_VALIDATE_INT) === false) {
        die("Invalid ID.");
    }

    // Fetch the account data using the decoded ID
    $sql = "SELECT * FROM accounts WHERE id = $id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }
    $row = mysqli_fetch_assoc($result);

     //use $row to display or edit the account data
} else {
    echo "No ID provided.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACCOUNT PROFILE</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
     .profile-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        border: 1px solid #d3d3d3;
        padding: 20px;
        border-radius: 10px;
        background-color: #f8f9fa;
    }
    .profile-card img {
    border-radius: 50%; /* Makes the image circular */
    border: 1px solid #d3d3d3; /* Border around the image */
    object-fit: cover; /* Ensures the image covers the area without distortion */
    height: 170px; /* Set a fixed height */
    width: 160px; /* Set a fixed width */
    overflow: hidden; /* Ensures that any overflow is hidden */
    }
    .profile-card .btn {
        margin-top: 10px;
    }
    .profile-info {
        text-align: left;
        margin-top: 20px;
    }
    .profile-info label {
        font-weight: bold;
    }
        .editable-fields input[readonly],
        .editable-fields textarea[readonly] {
            background-color: #e9ecef;
        }

        .btn-space {
         margin-left: 10px; /* Adjust the value as needed */
       }

       .container {
        display: flex;
        justify-content: center;
      }
       .row {
        width: 100%;
        max-width: 1200px; /* Adjust as needed */
     }
</style>

    

<div id="content-wrapper" class="d-flex flex-column" >
    
    <?php  include "../include/topbarAdmin.php"; ?>
    <div class="container mt-4">
    <div class="card" style="max-width:1000px;">
        <div class="card-header ">
            <h3>Profile Information</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-card">
                        <img src="../../uploads/profile_pics/<?php echo htmlspecialchars($row['profile_picture']); ?>" alt="Profile Picture" height="170" width="160">
                       
                        <div class="profile-info mt-3 text-center">
                            <h5 id="account_type"><?php echo htmlspecialchars($row['account_type']); ?></h5>
                            <h6 id="username"><?php echo htmlspecialchars($row['username']); ?></h6>
                            <h6 id="email"><?php echo htmlspecialchars($row['email']); ?></h6> 
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body tab-content" id="myTabContent">
                            <div class="card-header" style="background-color: #FFFFFF;">
                                <h5>Account Information <i id="edit-icon" class="fas fa-edit" style="cursor: pointer; color: orange;"></i></h5>
                            </div>
                            <br>
                            <div class="editable-fields">
                                <form action="editInfo_account.php" method="post" enctype="multipart/form-data" style='margin-bottom: 10px;'>
                                    <div class="form-group row" style='margin-bottom: 10px;'>
                                        <div class="col-md-5">
                                            <label class="form-label">First Name:</label>
                                            <input type="text" class="form-control" name="f_name" value="<?php echo htmlspecialchars($row['f_name']) ?>" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Last Name:</label>
                                            <input type="text" class="form-control" name="l_name" value="<?php echo htmlspecialchars($row['l_name']) ?>" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Middle Name:</label>
                                            <input type="text" class="form-control" name="m_name" value="<?php echo htmlspecialchars($row['m_name']) ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row"style='margin-bottom: 10px;'>
                                        <div class="col-md-6">
                                            <label class="form-label">Username:</label>
                                            <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($row['username']) ?>" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Email:</label>
                                            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($row['email']) ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row"style='margin-bottom: 10px;'>
                                        <div class="col-md-6">
                                            <label class="form-label">Job Position:</label>
                                            <input type="text" class="form-control" name="job_position" value="<?php echo htmlspecialchars($row['job_position']) ?>" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="accountType" class="form-label">Account Type:</label>
                                            <select id="account_type" name="account_type" class="form-control custom-select" readonly>
                                                <option value="">Select Account Type</option>
                                                <option value="Admin" <?php echo ($row['account_type'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                                                <option value="Super Admin" <?php echo ($row['account_type'] == 'Super Admin') ? 'selected' : ''; ?>>Super Admin</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row"style='margin-bottom: 10px;'>
                                        <div class="col-md-6">
                                            <label class="form-label">Upload Picture:</label>
                                            <input type="file" class="form-control-file form-control" name="profile_picture" accept="image/*" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Contact Number:</label>
                                            <input type="text" class="form-control" name="contact_number" value="<?php echo htmlspecialchars($row['contact_number']) ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row"style='margin-bottom: 10px;'>
                                        <div class="col-md-6">
                                            <label for="accountType" class="form-label">Account Status:</label>
                                            <select id="account_status" name="account_status" class="form-control custom-select" readonly>
                                                <option value="">Select Account Status</option>
                                                <option value="Active" <?php echo ($row['account_status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
                                                <option value="Deactivate" <?php echo ($row['account_status'] == 'Deactivate') ? 'selected' : ''; ?>>Deactivate</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Address:</label>
                                            <textarea class="form-control" name="address" rows="2"><?php echo htmlspecialchars($row['address']); ?></textarea>
                                        </div>
                                    </div>
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($encoded_id); ?>">
                                    <div class="form-group row">
                                        <div class="col d-flex justify-content-end">
                                            <button type="submit" class="btn btn-success" name="submit">Update</button>
                                            <a href="accounts.php" class="btn btn-danger btn-space">Exit</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Additional tab contents can be added here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Bootstrap -->
    
    <?php 
    include "../../include/scripts.php";
    ?>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
   <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

   <script>
        document.getElementById('edit-icon').addEventListener('click', function() {
            let fields = document.querySelectorAll('.editable-fields input:not(.readonly-field)');
            fields.forEach(field => {
                if (field.hasAttribute('readonly')) {
                    field.removeAttribute('readonly');
                    field.style.backgroundColor = "#fff"; // Optional: change background color to indicate edit mode
                } else {
                    field.setAttribute('readonly', 'readonly');
                    field.style.backgroundColor = ""; // Reset background color
                }
            });
        });
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const passwordField = document.querySelector('input[name="password"]');
        const confirmPasswordField = document.querySelector('input[name="confirm_password"]');
        const form = document.querySelector('form');
        const submitButton = document.querySelector('button[type="submit"]');

        function checkPasswordMatch() {
            if (passwordField.value === confirmPasswordField.value) {
                confirmPasswordField.setCustomValidity('');
                confirmPasswordField.style.borderColor = 'green';
            } else {
                confirmPasswordField.setCustomValidity('Passwords do not match');
                confirmPasswordField.style.borderColor = 'red';
            }
        }

        passwordField.addEventListener('input', checkPasswordMatch);
        confirmPasswordField.addEventListener('input', checkPasswordMatch);

        form.addEventListener('submit', function (event) {
            checkPasswordMatch();
            if (confirmPasswordField.validity.valid === false) {
                event.preventDefault();
                alert('Please correct the errors before submitting.');
            }
        });
    });