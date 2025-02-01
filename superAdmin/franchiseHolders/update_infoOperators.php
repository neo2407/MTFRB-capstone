<?php
session_start();
include "../include/db_conn.php";
include "function_expDateBan.php";
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
  <link rel="shortcut icon" type="image/x-icon" href="../../assets/img/MTFRBLogo.png">
  <title>MTFRB LUCBAN</title>
</head>
<body>
<nav class="navbar navbar-light justify-content-center fs-3 mb-5" style="background-color: #1e73da;">
   <b>MTFRB LUCBAN</b> 
</nav>

<div class="container">
    <div class="text-center mb-4">
        <h3>Edit Franchise Holder Information</h3>
        <p class="text-muted">Click update after changing any information</p>
    </div>

    <div class="container d-flex justify-content-center">
        <form action="update_functionsHolders.php" method="post" enctype="multipart/form-data" style="width:50vw; min-width:300px;">
            <div class="row mb-3">
                <div class="col">
                    <label class="form-label">Tricycle Franchise No:</label>
                    <input type="text" class="form-control" name="id" value="<?php echo htmlspecialchars($row['id']) ?>" readonly>
                </div>
                <div class="col">
                    <label class="form-label">First Name:</label>
                    <input type="text" class="form-control" name="first_name" value="<?php echo htmlspecialchars($row['first_name']) ?>">
                </div>
            </div>

            <div class="row mb-3">
            <div class="col">
                <label class="form-label">Expiration Date:</label>
                <input type="text" class="form-control" name="expirationDate" value="<?php echo htmlspecialchars($expirationDate); ?>" readonly>
            </div>
            <div class="col">
                <label class="form-label">Day Banned:</label>
                <input type="text" class="form-control" name="dayBanned" value="<?php echo htmlspecialchars($dayBanned); ?>" readonly>
                </div>
            </div>

            <div class=" row mb-3">
                <label class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($row['email']) ?>">
            </div>

            <style>
                table td {
                text-align: center;
                }
                table th {
                text-align: center;
                }

            </style>
           
            <table class="table table-bordered ">
                <thead>
                    <tr>
                        <th>File Name</th>
                        <th>View Requirements</th>
                        <th>Upload</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Drivers Pic</td>
                        <td>
                            <?php if (!empty($row['driversPic'])): ?>
                                <a href="../../uploads/driversPic/<?php echo htmlspecialchars($row['driversPic']); ?>" target="_blank" class="btn btn-primary">View Attachment</a>
                            <?php endif; ?>
                        </td>
                        <td>
                        <label for="driversPic" class="btn btn-primary">Upload Drivers Pic</label>
                        <input type="file" id="driversPic" name="driversPic" style="display: none;">
                        </td>
                    </tr>
                    <tr>
                        <td>Tricycle Pictures</td>
                        <td>
                            <?php 
                            if (!empty($row['tricyclePics'])): 
                                $tricyclePicsJson = stripslashes($row['tricyclePics']);
                                $tricyclePicsArray = json_decode($tricyclePicsJson, true);
                                if (is_array($tricyclePicsArray)) {
                                    foreach ($tricyclePicsArray as $pic): ?>
                                        <a href="../../uploads/tricyclePics/<?php echo htmlspecialchars($pic); ?>" target="_blank" class="btn btn-primary">View Attachment</a><br><br>  
                                    <?php endforeach; 
                                } else {
                                    echo "No valid pictures found.";
                                }
                            endif; ?>
                        </td>
                        <td>
                           
                            <label for="tricyclePics" class="btn btn-primary">Upload Drivers Pic</label>
                            <input type="file" id="tricyclePics" name="tricyclePics[]" multiple style="display: none;">
                        </td>
                    </tr>
                </tbody>
            </table>
                        
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
            <div>
                <button type="submit" class="btn btn-success" name="submit">Update</button>
                <a href="franchiseHolders.php" class="btn btn-danger">Cancel</a>
            </div>
        </form>
    </div>
</div>


<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<?php 
include "../../include/scripts.php";
?>
</body>
</html>
