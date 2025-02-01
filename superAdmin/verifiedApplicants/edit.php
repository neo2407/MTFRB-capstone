<?php
include "../include/db_conn.php";

$id = $_GET['id'];
$sql = "SELECT * FROM applicants WHERE id = $id LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);


    include "../include/headerAdmin.php";
    include "../include/navbarAdmin.php";
 
?>


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

     } /* Responsive Font and Padding */
@media (max-width: 768px) {
    .table thead th, .table tbody td {
        font-size: 12px; /* Smaller text for smaller screens */
        padding: 10px; /* Adjust padding for smaller screens */
    }

    .btn-block {
        max-width: 120px; /* Smaller buttons on smaller screens */
    }

    .text-right {
        text-align: center; /* Center the buttons on smaller screens */
    }

    .btn {
        margin-top: 10px; /* Add spacing between buttons on smaller screens */
    }
    .border-light-grey {
    border: 3px solid #d3d3d3; /* Light grey border */
  }
}

@media (max-width: 576px) {
    .table thead th, .table tbody td {
        font-size: 10px; /* Even smaller text for very small screens */
        padding: 5px; /* Adjust padding further */
    }

}

.btn.btn-primary {
    background-color: #2680C2;
    color: #fff;
    border: 1px solid #2680C2;
    box-shadow: inset 0 0 0 0 #fff;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.btn.btn-primary:hover {
    background-color: #fff;
    border-color: #2680C2;
    color: #2680C2;
    box-shadow: inset 0 50px 0 0 #fff;
}

</style>

<div id="content-wrapper" class="d-flex flex-column">   
<?php include "../include/topbarAdmin.php";?>

<div class="container mt-3" style="margin-left:50px; width: 1200px;">
    <div class="card">
        <div class="card-header" style="height:60px">
            <h5>Franchise Applicant Profile </h5>

        </div>
        <div class="card-body">
            <div class="row">
            <div class="col-md-4" style="max-height:600px ">
                    <div class="profile-card">
                    <img src="../../uploads/operator/<?php echo htmlspecialchars($row['operatorsPic']); ?>" alt="Profile Picture" class="rounded-circle" style="height: 170px; width: 160px; object-fit: cover; border: 1px solid #d3d3d3; border-radius: 50%; overflow: hidden;">
                        <div class="profile-info mt-3 ">
                   
                    <ul class="list-group list-group-flush my-6">
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                      <h6 class="mb-0">Applicant ID: </h6>
                      <span class="text-secondary"><?php echo htmlspecialchars($row['id']); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                      <h6 class="mb-0">Name: </h6>
                      <span class="text-secondary"><?php echo htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                      <h6 class="mb-0">Contact Number: </h6>
                      <span class="text-secondary"><?php echo htmlspecialchars($row['contact_num']); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                      <h6 class="mb-0">Email: </h6>
                      <span class="text-secondary"><?php echo htmlspecialchars($row['email']); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                      <h6 class="mb-0">Address: </h6>
                      <span class="text-secondary"> <?php echo htmlspecialchars($row['address']); ?></span>
                    </li>
                  </ul>
                 
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab" aria-controls="info" aria-selected="true">Applicant Information</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="requirements-tab" data-bs-toggle="tab" data-bs-target="#requirements" type="button" role="tab" aria-controls="requirements" aria-selected="false">Requirements</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="send-message-tab" data-bs-toggle="tab" data-bs-target="#send-message" type="button" role="tab" aria-controls="send-message" aria-selected="false">Send Notification</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="order-payment-tab" data-bs-toggle="tab" data-bs-target="#order-payment" type="button" role="tab" aria-controls="order-payment" aria-selected="false">Order of Payment</button>
                                </li>
                                
                            </ul>
                        </div>
                        <div class="card-body tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                            <div class="card-header" style="background-color: #FFFFFF; padding: 2px; font-size: 14px;">
                                    <h5>Applicant Information <i id="edit-icon" class="fas fa-edit" style="cursor: pointer; color: orange;"></i></h5>
                                </div>
                                <br>
                                <form action="updateInfo-Applicant.php" method="post" enctype="multipart/form-data" style="width:50vw; min-width:300px;">
                                            <div class="editable-fields">
                                                <div class="form-group row">
                                                    <div class="col-md-5">
                                                        <label class="form-label">Applicant ID:</label>
                                                        <input type="text" class="form-control readonly-field" name="id" value="<?php echo htmlspecialchars($row['id']) ?>" readonly>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <label class="form-label">Date Filed:</label>
                                                        <input type="text" class="form-control readonly-field" name="applicationDate" value="<?php echo htmlspecialchars($row['applicationDate']) ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-4">
                                                        <label class="form-label">Last Name:</label>
                                                        <input type="text" class="form-control " name="last_name" value="<?php echo htmlspecialchars($row['last_name']) ?>" readonly>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">First Name:</label>
                                                        <input type="text" class="form-control" name="first_name" value="<?php echo htmlspecialchars($row['first_name']) ?>" readonly>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">Middle Name:</label>
                                                        <input type="text" class="form-control " name="m_name" value="<?php echo htmlspecialchars($row['m_name']) ?>" readonly>
                                                    </div>
                                                    
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-4">
                                                        <label class="form-label">Sex:</label>
                                                        <input type="text" class="form-control" name="sex" value="<?php echo htmlspecialchars($row['sex']) ?>" readonly> 
                                                    </div>
                                                    
                                                    <div class="col-md-4">
                                                     <label class="form-label">Birth Date:</label>
                                                        <input type="date" class="form-control" name="b_date" value="<?php echo htmlspecialchars($row['b_date']) ?>" readonly>
                                                    </div>

                                                    <div class="col-md-2">
                                                     <label class="form-label">Age:</label>
                                                        <input type="number" class="form-control" name="age" value="<?php echo htmlspecialchars($row['age']) ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-5">
                                                        <label class="form-label">Contact Number:</label>
                                                        <input type="text" class="form-control" name="contact_num" value="<?php echo htmlspecialchars($row['contact_num']) ?>" readonly> 
                                                    </div>
                                                    <div class="col-md-5">
                                                        <label class="form-label">Email:</label>
                                                        <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($row['email']) ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-10">
                                                        <label class="form-label">Address:</label>
                                                        <input type="text" class="form-control " name="address" value="<?php echo htmlspecialchars($row['address']) ?>" readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                        <div class="col-md-5">
                                                            <label class="form-label">Registered Driver #1:</label>
                                                            <input type="text" class="form-control" name="driver1_name" value="<?php echo htmlspecialchars($row['driver1_name']) ?>" readonly> 
                                                        </div>
                                                        <div class="col-md-5">
                                                            <label class="form-label">Registered Driver #2:</label>
                                                             <input type="text" class="form-control" name="driver2_name" value="<?php echo !empty($row['driver2_name']) ? htmlspecialchars($row['driver2_name']) : 'N/A'; ?>" readonly>
                                                        </div>
                                                    </div>
                                                    
                                                <div class="form-group row">
                                                    
                                                   
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-3">
                                                            <label class="form-label">Tricycle Color:</label>
                                                            <input type="text" class="form-control" name="tricColor" value="<?php echo htmlspecialchars($row['tricColor']) ?>" readonly>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">Vehicle Type:</label>
                                                        <input type="text" class="form-control" name="tricType" value="<?php echo htmlspecialchars($row['tricType']) ?>" readonly>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">TODA:</label>
                                                        <input type="text" class="form-control" name="toda" value="<?php echo htmlspecialchars($row['toda']) ?>" readonly>
                                                    </div>
                                                
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3">
                                                            <label class="form-label">Driver's License No:</label>
                                                            <input type="text" class="form-control" name="license_no" value="<?php echo htmlspecialchars($row['license_no']) ?>" readonly>
                                                    </div>
                                                    <div class="col-md-3">
                                                            <label class="form-label"> License Classification:</label>
                                                            <input type="text" class="form-control" name="license_class" value="<?php echo htmlspecialchars($row['license_class']) ?>" readonly>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Driver's License Expiration Date:</label>
                                                        <input type="date" class="form-control" name="license_exp" value="<?php echo htmlspecialchars($row['license_exp']) ?>" readonly>
                                                    </div>
                                                
                                                </div>
                                            </div>
                                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']) ?>">
                                            <div  class="text-right">
                                                <button type="submit" class="btn btn-success" name="submit">Update</button>
                                                <a href="verifiedApplicants.php" class="btn btn-danger" style="margin-right:150px">Exit</a>
                                            </div>
                                            
                                        </form>  
                                      </div>
                                      <div class="tab-pane fade" id="requirements" role="tabpanel" aria-labelledby="requirements-tab">
                                      <div class="card-header" style="background-color: #FFFFFF; padding: 2px; font-size: 14px;">
                                            <h5>Requirements Submitted <i id="edit-icon" class="fas fa-edit" style="cursor: pointer; color: orange;"></i></h5>
                                        </div>

                                        <form action="update_requirements.php" method="post" enctype="multipart/form-data" style="width:40vw; min-width:300px;">
                                            <style>
                                                    table td {
                                                    text-align: center;
                                                    }
                                                    table th {
                                                    text-align: center;
                                                    }

                                                </style>
                                            <div class="table-responsive" style="80%;" >
                                                  <table class="table">
                                                      <thead>
                                                          <tr>
                                                              <th>File Name</th>
                                                              <th>View File</th>
                                                              <th>File Status</th>
                                                              <th>Upload</th>
                                                          </tr>
                                                      </thead>
                                                      <tbody>
                                                        <tr>
                                                            <td>Operators Picture</td>
                                                            <td>
                                                                <?php if (!empty($row['operatorsPic'])): ?>
                                                                    <a href="../../uploads/operator/<?php echo htmlspecialchars($row['operatorsPic']); ?>" target="_blank" class="btn btn-white">View </a>
                                                                <?php else: ?>
                                                                        <span>Pending for upload</span>
                                                                    <?php endif; ?> 
                                                            </td>
                                                            <td>
                                                            <!-- The dropdown to select file status -->
                                                            <select onchange="validateFile(<?php echo $row['id']; ?>, 'operatorsPic', this.value)" style="border-radius: 5px; background-color: white; color: blue; border: none; padding: 5px 10px;">
                                                                <option value="For Verification" <?php echo $row['operatorsPicStatus'] == 'For Verification' ? 'selected' : ''; ?>>For Verification</option>
                                                                <option value="Valid" <?php echo $row['operatorsPicStatus'] === 'Valid' ? 'selected' : ''; ?>>Valid</option>
                                                                <option value="Invalid" <?php echo $row['operatorsPicStatus'] === 'Invalid' ? 'selected' : ''; ?>>Invalid</option>
                                                            </select>

                                                            <!-- Hidden span to display the current status -->
                                                            <span id="operatorsPicStatus" style="display: none;"><?php echo $row['operatorsPicStatus']; ?></span>
                                                            
                                                            <td>
                                                           
                                                            <label for="operatorsPic" class="btn btn-primary"><i class="fas fa-upload"></i> Upload</label>
                                                            <input type="file" id="operatorsPic" name="operatorsPic" style="display: none;">
                                                            </td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td>License</td>
                                                            <td>
                                                                <?php if (!empty($row['license'])): ?>
                                                                    <a href="../../uploads/license/<?php echo htmlspecialchars($row['license']); ?>" target="_blank" class="btn btn-white">View </a>
                                                                 <?php else: ?>
                                                                        <span>Pending for upload</span>
                                                                    <?php endif; ?>
                                                            </td>
                                                            <td>
                                                            <!-- The dropdown to select file status -->
                                                            <select onchange="validateFile(<?php echo $row['id']; ?>, 'license', this.value)" style="border-radius: 5px; background-color: white; color: blue; border: none; padding: 5px 10px;">
                                                                <option value="For Verification" <?php echo $row['licenseStatus'] == 'For Verification' ? 'selected' : ''; ?>>For Verification</option>
                                                                <option value="Valid" <?php echo $row['licenseStatus'] === 'Valid' ? 'selected' : ''; ?>>Valid</option>
                                                                <option value="Invalid" <?php echo $row['licenseStatus'] === 'Invalid' ? 'selected' : ''; ?>>Invalid</option>
                                                            </select>

                                                            <!-- Hidden span to display the current status -->
                                                            <span id="licenseStatus" style="display: none;"><?php echo $row['licenseStatus']; ?></span>
                                                            
                                                            <td>
                                                           
                                                            <label for="license" class="btn btn-primary"><i class="fas fa-upload"></i> Upload</label>
                                                            <input type="file" id="license" name="license" style="display: none;">
                                                            </td>
                                                        </tr>
                                                        
                                                         <tr>
                                                            <td>(CR) from LTO</td>
                                                            <td>
                                                                <?php if (!empty($row['cr'])): ?>
                                                                    <a href="../../uploads/cr/<?php echo htmlspecialchars($row['cr']); ?>" target="_blank" class="btn btn-white">View </a>
                                                                 <?php else: ?>
                                                                        <span>Pending for upload</span>
                                                                    <?php endif; ?>
                                                            </td>
                                                            <td>
                                                            <!-- The dropdown to select file status -->
                                                            <select onchange="validateFile(<?php echo $row['id']; ?>, 'cr', this.value)" style="border-radius: 5px; background-color: white; color: blue; border: none; padding: 5px 10px;">
                                                                <option value="For Verification" <?php echo $row['crStatus'] == 'For Verification' ? 'selected' : ''; ?>>For Verification</option>
                                                                <option value="Valid" <?php echo $row['crStatus'] === 'Valid' ? 'selected' : ''; ?>>Valid</option>
                                                                <option value="Invalid" <?php echo $row['crStatus'] === 'Invalid' ? 'selected' : ''; ?>>Invalid</option>
                                                            </select>

                                                            <!-- Hidden span to display the current status -->
                                                            <span id="crStatus" style="display: none;"><?php echo $row['crStatus']; ?></span>
                                                            
                                                            <td>
                                                           
                                                            <label for="cr" class="btn btn-primary"><i class="fas fa-upload"></i> Upload</label>
                                                            <input type="file" id="cr" name="cr" style="display: none;">
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>(OR) from LTO</td>
                                                            <td>
                                                                <?php if (!empty($row['or'])): ?>
                                                                    <a href="../../uploads/or/<?php echo htmlspecialchars($row['or']); ?>" target="_blank" class="btn btn-white">View </a>
                                                                <?php else: ?>
                                                                        <span>Pending for upload</span>
                                                                    <?php endif; ?>
                                                            </td>
                                                            <td>
                                                            <!-- The dropdown to select file status -->
                                                            <select onchange="validateFile(<?php echo $row['id']; ?>, 'or', this.value)" style="border-radius: 5px; background-color: white; color: blue; border: none; padding: 5px 10px;">
                                                                <option value="For Verification" <?php echo $row['orStatus'] == 'For Verification' ? 'selected' : ''; ?>>For Verification</option>
                                                                <option value="Valid" <?php echo $row['orStatus'] === 'Valid' ? 'selected' : ''; ?>>Valid</option>
                                                                <option value="Invalid" <?php echo $row['orStatus'] === 'Invalid' ? 'selected' : ''; ?>>Invalid</option>
                                                            </select>

                                                            <!-- Hidden span to display the current status -->
                                                            <span id="orStatus" style="display: none;"><?php echo $row['orStatus']; ?></span>
                                                            
                                                            <td>
                                                           
                                                            <label for="or" class="btn btn-primary"><i class="fas fa-upload"></i> Upload</label>
                                                            <input type="file" id="or" name="or" style="display: none;">
                                                            </td>
                                                        </tr>


                                                        <tr>
                                                            <td>PSA / Voter's ID</td>
                                                            <td>
                                                                <?php if (!empty($row['valid_id'])): ?>
                                                                    <a href="../../uploads/valid_id/<?php echo htmlspecialchars($row['valid_id']); ?>" target="_blank" class="btn btn-white">View </a>
                                                                <?php else: ?>
                                                                        <span>Pending for upload</span>
                                                                    <?php endif; ?>
                                                            </td>
                                                            <td>
                                                            <!-- The dropdown to select file status -->
                                                            <select onchange="validateFile(<?php echo $row['id']; ?>, 'valid_id', this.value)" style="border-radius: 5px; background-color: white; color: blue; border: none; padding: 5px 10px;">
                                                                <option value="For Verification" <?php echo $row['valid_idStatus'] == 'For Verification' ? 'selected' : ''; ?>>For Verification</option>
                                                                <option value="Valid" <?php echo $row['valid_idStatus'] === 'Valid' ? 'selected' : ''; ?>>Valid</option>
                                                                <option value="Invalid" <?php echo $row['valid_idStatus'] === 'Invalid' ? 'selected' : ''; ?>>Invalid</option>
                                                            </select>

                                                            <!-- Hidden span to display the current status -->
                                                            <span id="valid_idStatus" style="display: none;"><?php echo $row['valid_idStatus']; ?></span>
                                                            
                                                            <td>
                                                           
                                                            <label for="valid_id" class="btn btn-primary"><i class="fas fa-upload"></i> Upload</label>
                                                            <input type="file" id="valid_id" name="valid_id" style="display: none;">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Driver #1</td>
                                                            <td>
                                                                <?php if (!empty($row['driversPic1'])): ?>
                                                                    <a href="../../uploads/driver1/<?php echo htmlspecialchars($row['driversPic1']); ?>" target="_blank" class="btn btn-white">View </a>
                                                               <?php else: ?>
                                                                        <span>Pending for upload</span>
                                                                    <?php endif; ?>
                                                            </td>
                                                            <td>
                                                            <!-- The dropdown to select file status -->
                                                            <select onchange="validateFile(<?php echo $row['id']; ?>, 'driversPic1', this.value)" style="border-radius: 5px; background-color: white; color: blue; border: none; padding: 5px 10px;">
                                                                <option value="For Verification" <?php echo $row['driversPic1Status'] == 'For Verification' ? 'selected' : ''; ?>>For Verification</option>
                                                                <option value="Valid" <?php echo $row['driversPic1Status'] === 'Valid' ? 'selected' : ''; ?>>Valid</option>
                                                                <option value="Invalid" <?php echo $row['driversPic1Status'] === 'Invalid' ? 'selected' : ''; ?>>Invalid</option>
                                                            </select>

                                                            <!-- Hidden span to display the current status -->
                                                            <span id="driversPic1Status" style="display: none;"><?php echo $row['driversPic1Status']; ?></span>
                                                            
                                                            <td>
                                                           
                                                            <label for="driversPic1" class="btn btn-primary"><i class="fas fa-upload"></i> Upload</label>
                                                            <input type="file" id="driversPic1" name="driversPic1" style="display: none;">
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
                                                                            <a href="../../uploads/tricyclePics/<?php echo htmlspecialchars($pic); ?>" target="_blank" class="btn btn-white">View</a><br><br>  
                                                                        <?php endforeach; 
                                                                    } else {
                                                                        echo "No tricycle pictures found.";
                                                                    }
                                                                endif; ?>
                                                            </td>

                                                            <td>
                                                                <select onchange="validateFile(<?php echo $row['id']; ?>, 'tricyclePics', this.value)" style="border-radius: 5px; background-color: white; color: blue; border: none; padding: 5px 10px;">
                                                                    <option value="For Verification" <?php echo $row['tricyclePicsStatus'] == 'For Verification' ? 'selected' : ''; ?>>For Verification</option>
                                                                    <option value="Valid" <?php echo $row['tricyclePicsStatus'] === 'Valid' ? 'selected' : ''; ?>>Valid</option>
                                                                    <option value="Invalid" <?php echo $row['tricyclePicsStatus'] === 'Invalid' ? 'selected' : ''; ?>>Invalid</option>
                                                                </select>
                                                                <!-- Hidden span to display the current status -->
                                                                <span id="tricyclePicsStatus" style="display: none;"><?php echo $row['tricyclePicsStatus']; ?></span>
                                                            </td>

                                                            <td>
                                                                <label for="tricyclePicsUpload" class="btn btn-primary">
                                                                    <i class="fas fa-upload"></i> Upload
                                                                </label>
                                                                <input type="file" id="tricyclePicsUpload" class="form-control" name="tricyclePics[]" multiple style="display:none;">
                                                            </td>
                                                        </tr>
                                                        
                                                         
                                                        <tr>
                                                            <td>Sedula</td>
                                                            <td>
                                                                <?php if (!empty($row['sedula'])): ?>
                                                                    <a href="../../uploads/sedula/<?php echo htmlspecialchars($row['sedula']); ?>" target="_blank" class="btn btn-white">View </a>
                                                                <?php else: ?>
                                                                        <span>Pending for upload</span>
                                                                    <?php endif; ?>
                                                            </td>
                                                            <td>
                                                            <!-- The dropdown to select file status -->
                                                            <select onchange="validateFile(<?php echo $row['id']; ?>, 'sedula', this.value)" style="border-radius: 5px; background-color: white; color: blue; border: none; padding: 5px 10px;">
                                                                <option value="For Verification" <?php echo $row['sedulaStatus'] == 'For Verification' ? 'selected' : ''; ?>>For Verification</option>
                                                                <option value="Valid" <?php echo $row['sedulaStatus'] === 'Valid' ? 'selected' : ''; ?>>Valid</option>
                                                                <option value="Invalid" <?php echo $row['sedulaStatus'] === 'Invalid' ? 'selected' : ''; ?>>Invalid</option>
                                                            </select>

                                                            <!-- Hidden span to display the current status -->
                                                            <span id="sedulaStatus" style="display: none;"><?php echo $row['sedulaStatus']; ?></span>
                                                            
                                                            <td>
                                                           
                                                            <label for="sedula" class="btn btn-primary"><i class="fas fa-upload"></i> Upload</label>
                                                            <input type="file" id="sedula" name="sedula" style="display: none;">
                                                            </td>
                                                        </tr>

                                                        
                                                        <tr>
                                                            <td>Driver #2</td>
                                                            <td>
                                                                <?php if (!empty($row['driversPic2'])): ?>
                                                                    <a href="../../uploads/driver2/<?php echo htmlspecialchars($row['driversPic2']); ?>" target="_blank" class="btn btn-white">View </a>
                                                                 <?php else: ?>
                                                                        <span>Pending for upload</span>
                                                                    <?php endif; ?>
                                                            </td>
                                                            <td>
                                                            <!-- The dropdown to select file status -->
                                                            <select onchange="validateFile(<?php echo $row['id']; ?>, 'driversPic2', this.value)" style="border-radius: 5px; background-color: white; color: blue; border: none; padding: 5px 10px;">
                                                                <option value="For Verification" <?php echo $row['driversPic2Status'] == 'For Verification' ? 'selected' : ''; ?>>For Verification</option>
                                                                <option value="Valid" <?php echo $row['driversPic2Status'] === 'Valid' ? 'selected' : ''; ?>>Valid</option>
                                                                <option value="Invalid" <?php echo $row['driversPic2Status'] === 'Invalid' ? 'selected' : ''; ?>>Invalid</option>
                                                            </select>

                                                            <!-- Hidden span to display the current status -->
                                                            <span id="driversPic2Status" style="display: none;"><?php echo $row['driversPic2Status']; ?></span>
                                                            
                                                            <td>
                                                           
                                                            <label for="driversPic2" class="btn btn-primary"><i class="fas fa-upload"></i> Upload</label>
                                                            <input type="file" id="driversPic2" name="driversPic2" style="display: none;">
                                                            </td>
                                                        </tr>
                                                        
                                                        
                                                        <tr>
                                                            <td>Medical Result</td>
                                                            <td>
                                                                <?php if (!empty($row['med_res'])): ?>
                                                                    <a href="../../uploads/med_res/<?php echo htmlspecialchars($row['med_res']); ?>" target="_blank" class="btn btn-white">View </a>
                                                                 <?php else: ?>
                                                                        <span>Pending for upload</span>
                                                                    <?php endif; ?>
                                                            </td>
                                                            <td>
                                                            <!-- The dropdown to select file status -->
                                                            <select onchange="validateFile(<?php echo $row['id']; ?>, 'med_res', this.value)" style="border-radius: 5px; background-color: white; color: blue; border: none; padding: 5px 10px;">
                                                                <option value="For Verification" <?php echo $row['med_resStatus'] == 'For Verification' ? 'selected' : ''; ?>>For Verification</option>
                                                                <option value="Valid" <?php echo $row['med_resStatus'] === 'Valid' ? 'selected' : ''; ?>>Valid</option>
                                                                <option value="Invalid" <?php echo $row['med_resStatus'] === 'Invalid' ? 'selected' : ''; ?>>Invalid</option>
                                                            </select>

                                                            <!-- Hidden span to display the current status -->
                                                            <span id="med_resStatus" style="display: none;"><?php echo $row['med_resStatus']; ?></span>
                                                            
                                                            <td>
                                                           
                                                            <label for="med_res" class="btn btn-primary"><i class="fas fa-upload"></i> Upload</label>
                                                            <input type="file" id="med_res" name="med_res" style="display: none;">
                                                            </td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td>TODA Certificate</td>
                                                            <td>
                                                                <?php if (!empty($row['toda_cert'])): ?>
                                                                    <a href="../../uploads/toda_cert/<?php echo htmlspecialchars($row['toda_cert']); ?>" target="_blank" class="btn btn-white">View </a>
                                                               <?php else: ?>
                                                                        <span>Pending for upload</span>
                                                                    <?php endif; ?>
                                                            </td>
                                                            <td>
                                                            <!-- The dropdown to select file status -->
                                                            <select onchange="validateFile(<?php echo $row['id']; ?>, 'toda_cert', this.value)" style="border-radius: 5px; background-color: white; color: blue; border: none; padding: 5px 10px;">
                                                                <option value="For Verification" <?php echo $row['toda_certStatus'] == 'For Verification' ? 'selected' : ''; ?>>For Verification</option>
                                                                <option value="Valid" <?php echo $row['toda_certStatus'] === 'Valid' ? 'selected' : ''; ?>>Valid</option>
                                                                <option value="Invalid" <?php echo $row['toda_certStatus'] === 'Invalid' ? 'selected' : ''; ?>>Invalid</option>
                                                            </select>

                                                            <!-- Hidden span to display the current status -->
                                                            <span id="toda_certStatus" style="display: none;"><?php echo $row['toda_certStatus']; ?></span>
                                                            
                                                            <td>
                                                           
                                                            <label for="toda_cert" class="btn btn-primary"><i class="fas fa-upload"></i> Upload</label>
                                                            <input type="file" id="toda_cert" name="toda_cert" style="display: none;">
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>Deed of Sale</td>
                                                            <td>
                                                                <?php if (!empty($row['deedSale'])): ?>
                                                                    <a href="../../uploads/deedSale/<?php echo htmlspecialchars($row['deedSale']); ?>" target="_blank" class="btn btn-white">View </a>
                                                                <?php else: ?>
                                                                        <span>Pending for upload</span>
                                                                    <?php endif; ?>
                                                            </td>
                                                            <td>
                                                            <!-- The dropdown to select file status -->
                                                            <select onchange="validateFile(<?php echo $row['id']; ?>, 'deedSale', this.value)" style="border-radius: 5px; background-color: white; color: blue; border: none; padding: 5px 10px;">
                                                                <option value="For Verification" <?php echo $row['deedSaleStatus'] == 'For Verification' ? 'selected' : ''; ?>>For Verification</option>
                                                                <option value="Valid" <?php echo $row['deedSaleStatus'] === 'Valid' ? 'selected' : ''; ?>>Valid</option>
                                                                <option value="Invalid" <?php echo $row['deedSaleStatus'] === 'Invalid' ? 'selected' : ''; ?>>Invalid</option>
                                                            </select>

                                                            <!-- Hidden span to display the current status -->
                                                            <span id="deedSaleStatus" style="display: none;"><?php echo $row['deedSaleStatus']; ?></span>
                                                            
                                                            <td>
                                                           
                                                            <label for="deedSale" class="btn btn-primary"><i class="fas fa-upload"></i> Upload</label>
                                                            <input type="file" id="deedSale" name="deedSale" style="display: none;">
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>Tricycle Inspection</td>
                                                            <td>
                                                                    <?php 
                                                                        
                                                                        if (!empty($row['tric_insp'])): 
                                                                           
                                                                            $filePath = '../../uploads/tric_insp/' . htmlspecialchars($row['tric_insp']);
                                                                    ?>
                                                                        <a href="<?php echo $filePath; ?>" target="_blank" class="btn btn-white">View</a>
                                                                    <?php else: ?>
                                                                        <span>Pending for upload</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                            <td>
                                                            <!-- The dropdown to select file status -->
                                                            <select onchange="validateFile(<?php echo $row['id']; ?>, 'tric_insp', this.value)" style="border-radius: 5px; background-color: white; color: blue; border: none; padding: 5px 10px;">
                                                                <option value="For Verification" <?php echo $row['tric_inspStatus'] == 'For Verification' ? 'selected' : ''; ?>>For Verification</option>
                                                                <option value="Valid" <?php echo $row['tric_inspStatus'] === 'Valid' ? 'selected' : ''; ?>>Valid</option>
                                                                <option value="Invalid" <?php echo $row['tric_inspStatus'] === 'Invalid' ? 'selected' : ''; ?>>Invalid</option>
                                                            </select>

                                                            <!-- Hidden span to display the current status -->
                                                            <span id="tric_inspStatus" style="display: none;"><?php echo $row['tric_inspStatus']; ?></span>
                                                            
                                                            <td>
                                                           
                                                            <label for="tric_insp" class="btn btn-primary"><i class="fas fa-upload"></i> Upload</label>
                                                            <input type="file" id="tric_insp" name="tric_insp" style="display: none;">
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                                <br>
                                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                                <div  class="text-right">
                                                <button type="submit" class="btn btn-success" name="submit">Update</button>
                                                <a href="verifiedApplicants.php" class="btn btn-danger" >Exit</a>
                                                </div>
                                            </form> 
                                        </div>
                                    </div>
                                    
                                    
                                      <div class="tab-pane fade" id="send-message" role="tabpanel" aria-labelledby="send-message-tab">
                                            <div class="card-header" style="background-color: #FFFFFF; padding: 2px; font-size: 14px;">
                                            <h5>Send Message</h5>
                                         </div>
                                        <br>
                                        <form id="interviewForm" action="addInterviewSchedule.php" method="post">
                                            <div class="form-group row">
                                                <label class="form control">Schedule of Interview</label>
                                                
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="interview_sched_display" id="interview_sched_display" value="<?php echo htmlspecialchars($row['interview_sched']); ?>" readonly>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <input type="datetime-local" class="form-control" id="interview_sched" name="interview_sched">
                                                </div>
                                                
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-primary" onclick="addInterview()">Add</button>
                                                </div>
                                            </div>
                                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                        </form>
                                        <div class="d-flex justify-content-start align-items-center mt-2">
                                            <!-- send email button -->
                                            <button type="button" class="btn btn-primary me-2" onclick="sendMail()">Send Mail Message</button>
                                            <div id="emailSpinner" style="display: none;">
                                                <div class="spinner-border" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </div>
                                        
                                            <!-- send sms button -->
                                            <button type="button" class="btn btn-primary" onclick="sendSMS()">Send SMS Message</button>
                                            <div id="smsSpinner" class="ms-2" style="display: none;">
                                                <div class="spinner-border" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Hidden input for ID -->
                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                        
                                        <!-- Exit Button -->
                                        <div class="text-right" style="margin-top:-30px;">
                                            <a href="verifiedApplicants.php" class="btn btn-danger">Exit</a>
                                        </div>

                                    </form>
                                    </div>
                                    <!-- ORDER OF PAYMENT -->
                                  <div class="tab-pane fade" id="order-payment" role="tabpanel" aria-labelledby="order-payment-tab">
                                    <div class="card-header" style="background-color: #FFFFFF; padding: 2px; font-size: 14px;">
                                        <h5>Order of Payment</h5>
                                    </div>
                                    <br>
                                
                                    <!-- Trigger Button 
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-primary" onclick="showOrderPaymentModal()">Generate</button>
                                    </div>-->
                                    <?php if (empty($row['order_payment_Image'])): ?>
                                        <button type="button" class="btn btn-primary" onclick="showOrderPaymentModal()">Generate</button>
                                    <?php else: ?>
                                 
                                        <img id="image" src="../../orderPayment/<?php echo htmlspecialchars($row['order_payment_Image']); ?>" alt="Order Payment Image" style="max-width: 700px; max-height: 900px; margin-left:-20px;">
                                    <div class="text-right mt-3">
                                        <!--<a href="../../orderPayment/<?php echo htmlspecialchars($row['order_payment_Image']); ?>" 
                                        target="_blank" class="btn btn-primary" style="margin-top: 10px;">View</a>-->
                                    </div>
                                    <?php endif; ?>
                                    <!-- Hidden Input for ID -->
                                    <input type="hidden" name="id" id="applicant-id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                
                                    <!-- Modal -->
                                   <div class="modal fade" id="orderPaymentModal" tabindex="-1" role="dialog" aria-labelledby="orderPaymentModalLabel" aria-hidden="true">
                                         <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form id="orderPaymentForm" action="save-order-payment.php" method="post">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="orderPaymentModalLabel">Order of Payment</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="orderId">Order of Payment ID</label>
                                                            <input type="text" class="form-control" id="orderId" name="orderId" required> <!-- change readonly to auto generate orderId-->
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="applicantName">Payor</label>
                                                            <input type="text" class="form-control" id="applicantName"  value="<?php echo htmlspecialchars($row['first_name']) . ' ' . htmlspecialchars($row['last_name']); ?>" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="paymentDate">Date</label>
                                                            <input type="text" class="form-control" id="paymentDate" name="paymentDate" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="nature">Nature of Collection</label>
                                                            <input type="text" class="form-control" id="nature" name="nature" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="amount">Amount</label>
                                                            <input type="number" class="form-control" id="amount" name="amount" required oninput="convertAmountToWords()">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="amount_words">Amount In Words</label>
                                                            <textarea rows="2" class="form-control" id="amount_words" name="amount_words"></textarea> 
                                                        </div>
                                                    </div>
                                
                                                    <div class="modal-footer">
                                                        <button type="submit"  name="submit" class="btn btn-success">Save</button>
                                                       <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Cancel">Cancel</button>

                                                    </div>
                                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                                    
                                                </form>
                                                  
                                            </div>
                                        </div>
                                    </div>
                                      <!-- Exit Button -->
                                     <div class="text-right mt-3">
                                         <a href="verifiedApplicants.php" class="btn btn-danger">Exit</a>
                                    </div>
                                    
                                   <div class="text-left" style="margin-top:-40px; margin-left:30px;">
                                    <?php if (!empty($row['orderId']) && $row['orderId'] !== 'NULL'): ?>
                                        <button type="button" class="btn btn-primary" style="margin-right:10px;" id="generateReceiptBtn" onclick="openPrintWindow(<?= htmlspecialchars($row['orderId']); ?>)">Print Order of Payment</button>
                                    <?php endif; ?>
                                  </div>

                                    <script>
                                        function openPrintWindow(orderId) {
                                                // Create a new window with the specified size
                                                var printWindow = window.open('printOrderOfPayment.php?orderId=' + orderId, '_blank', 'width=800,height=600');
                                            
                                                // Wait for the new window to load, then trigger the print dialog
                                                printWindow.onload = function () {
                                                    printWindow.print();
                                                };
                                            }
                                            
                                            
                                        </script>
                                </div>
                                
                              
                                
                                <!-- JavaScript -->
                                <script>
                                  /** function showOrderPaymentModal() {
                                        const applicantId = document.getElementById('applicant-id').value;
                                        const applicantName = document.getElementById('applicantName').value;
                                    
                                        // Auto-generate Order of Payment ID (6-digit random number)
                                        const orderId = Math.floor(100000 + Math.random() * 900000);
                                    
                                        // Set current date in YYYY-MM-DD format
                                        const currentDate = new Date().toISOString().slice(0, 10);
                                    
                                        // Populate modal fields
                                        document.getElementById('orderId').value = orderId;
                                        document.getElementById('paymentDate').value = currentDate;
                                    
                                        // Show the modal
                                        $('#orderPaymentModal').modal('show');
                                    }**/
                                    function showOrderPaymentModal() {
                                        // Set current date in YYYY-MM-DD format
                                        const currentDate = new Date().toISOString().slice(0, 10);
                                        document.getElementById('paymentDate').value = currentDate;
                                    
                                        // Show the modal
                                        $('#orderPaymentModal').modal('show');
                                        
                                    }
                                    
                                    // Convert number to words and append "Pesos"
                                    function convertAmountToWords() {
                                        const amount = parseFloat(document.getElementById('amount').value);
                                        if (!isNaN(amount)) {
                                            const words = numberToWords(amount);
                                            document.getElementById('amount_words').value = words + " Pesos";
                                        } else {
                                            document.getElementById('amount_words').value = '';
                                        }
                                    }
                                    
                                    // Number to Words Function
                                    function numberToWords(num) {
                                        const belowTwenty = [
                                            'Zero', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten',
                                            'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'
                                        ];
                                        const tens = [
                                            '', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'
                                        ];
                                    
                                        function toWords(n) {
                                            if (n < 20) return belowTwenty[n];
                                            if (n < 100) return tens[Math.floor(n / 10)] + (n % 10 > 0 ? ' ' + belowTwenty[n % 10] : '');
                                            if (n < 1000) return belowTwenty[Math.floor(n / 100)] + ' Hundred' + (n % 100 > 0 ? ' ' + toWords(n % 100) : '');
                                            if (n < 1000000) return toWords(Math.floor(n / 1000)) + ' Thousand' + (n % 1000 > 0 ? ' ' + toWords(n % 1000) : '');
                                            return 'Number too large';
                                        }
                                    
                                        return toWords(num);
                                    }
                                    
                                   </script>

                            </div>
                            
                            <div class="tab-pane fade" id="qr" role="tabpanel" aria-labelledby="qr-tab">
                            <div class="card-header" style="background-color: #FFFFFF; padding: 2px; font-size: 14px;">
                                <!-- QR code content goes here -->
                            </div>
                            </div>
                        </div>
                        <!-- Additional tab contents can be added here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
    
    
<?php 

       include "../../include/modal_viewDetails.php";
 
        include "../include/scripts.php"; 

        include "../include/scriptsAdmin.php";
        include "../include/footerAdmin.php";
    ?>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
      <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
</div>

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