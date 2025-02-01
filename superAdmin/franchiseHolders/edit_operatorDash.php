<?php 
include "../include/db_conn.php";

    $id = $_GET['id'];
    $sql = "(SELECT * FROM jan_operators WHERE id = $id)
            UNION
            (SELECT * FROM feb_operators WHERE id = $id)
            UNION
            (SELECT * FROM march_operators WHERE id = $id)
            UNION
            (SELECT * FROM apr_operators WHERE id = $id)
            UNION
            (SELECT * FROM may_operators WHERE id = $id)
            UNION
            (SELECT * FROM jun_operators WHERE id = $id)
            UNION
            (SELECT * FROM jul_operators WHERE id = $id)
            UNION
            (SELECT * FROM aug_operators WHERE id = $id)
            UNION
            (SELECT * FROM sep_operators WHERE id = $id)
            UNION
            (SELECT * FROM oct_operators WHERE id = $id)
            LIMIT 1";
    
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
  // include "franchise_status.php";
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
       .profile-img {
        width: 160px; /* Specify the width */
        height: 170px; /* Specify the height */
        object-fit: cover; /* Ensures the image fits and crops within the container */
        border-radius: 50%; /* Makes it circular */
        overflow: hidden; /* Ensures no overflow outside the circle */
        border: 1px solid #d3d3d3; /* Adds a border */
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
            <h5>Tricycle Operator Profile </h5>

        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4" style="max-height:600px ">
                    <div class="profile-card">
                    <img src="../../uploads/operator/<?php echo htmlspecialchars($row['operatorsPic']); ?>" alt="Profile Picture" class="rounded-circle" style="height: 170px; width: 160px; object-fit: cover; border: 1px solid #d3d3d3; border-radius: 50%; overflow: hidden;">
                        <div class="profile-info mt-3 ">
                            
                    <ul class="list-group list-group-flush my-4">
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                      <h6 class="mb-0">Tricycle Franchise #: </h6>
                      <span class="text-secondary"><?php echo htmlspecialchars($row['TFno']); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                      <h6 class="mb-0">Name: </h6>
                      <span class="text-secondary"><?php echo htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                      <h6 class="mb-0">Day Banned: </h6>
                      <span class="text-secondary"><?php echo htmlspecialchars($row['dayBan']); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="mb-0">Expiration Date:</h6>
                        <span class="text-secondary" style="margin-left: 10px;"><?php echo htmlspecialchars($row['expDate']); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                      <h6 class="mb-0">Tricycle Color: </h6>
                      <span class="text-secondary">  <?php echo htmlspecialchars($row['tricColor']); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                      <h6 class="mb-0">Body Built: </h6>
                      <span class="text-secondary">  <?php echo htmlspecialchars($row['tricType']); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                      <h6 class="mb-0">TODA: </h6>
                      <span class="text-secondary">  <?php echo htmlspecialchars($row['toda']); ?></span>
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
                                    <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab" aria-controls="info" aria-selected="true">Franchise</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="renewal-tab" data-bs-toggle="tab" data-bs-target="#renewal" type="button" role="tab" aria-controls="renewal" aria-selected="false">Renewal</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="requirements-tab" data-bs-toggle="tab" data-bs-target="#requirements" type="button" role="tab" aria-controls="requirements" aria-selected="false">Requirements</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="violations-tab" data-bs-toggle="tab" data-bs-target="#violations" type="button" role="tab" aria-controls="violations" aria-selected="false">Violations</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="complaint-tab" data-bs-toggle="tab" data-bs-target="#complaint" type="button" role="tab" aria-controls="complaint" aria-selected="false">Complaints</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="qr-tab" data-bs-toggle="tab" data-bs-target="#qr" type="button" role="tab" aria-controls="qr" aria-selected="false">QR code</button>
                                </li>
                                
                                
                            </ul>
                        </div>
                        <div class="card-body tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                                <div class="card-header" style="background-color: #FFFFFF; padding: 2px; font-size: 14px;">
                                    <h5>Operator Information <i id="edit-icon" class="fas fa-edit" style="cursor: pointer; color: orange;"></i></h5>
                                </div>
                                <br>
                                <form action="update_basicInfo.php" method="post" enctype="multipart/form-data" style="width:50vw; min-width:300px;">
                                            <div class="editable-fields">
                                                <div class="form-group row">
                                                    <div class="col-md-5">
                                                        <label class="form-label">Tricycle Franchise #:</label>
                                                        <input type="text" class="form-control readonly-field" name="TFno" value="<?php echo htmlspecialchars($row['TFno']) ?>" readonly>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <label class="form-label">Franchise Granting Date:</label>
                                                        <input type="text" class="form-control" name="grant_date" value="<?php echo htmlspecialchars($row['grant_date']) ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-4">
                                                        <label class="form-label">Last Name:</label>
                                                        <input type="text" class="form-control " name="last_name" value="<?php echo htmlspecialchars($row['last_name']) ?>" readonly>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">First Name:</label>
                                                        <input type="text" class="form-control" name="first_name" value="<?php echo htmlspecialchars($row['first_name']) ?>" readonly>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">Middle Name:</label>
                                                        <input type="text" class="form-control " name="m_name" value="<?php echo htmlspecialchars($row['m_name']) ?>" readonly>
                                                    </div>
                                    
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-4">
                                                        <label class="form-label">Contact Number:</label>
                                                        <input type="number" class="form-control" name="contact_num" value="<?php echo htmlspecialchars($row['contact_num']) ?>" readonly> 
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Email:</label>
                                                        <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($row['email']) ?>" readonly>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">Age:</label>
                                                        <input type="number" class="form-control" name="age" value="<?php echo htmlspecialchars($row['age']) ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                     <div class="col-md-5">
                                                        <label class="form-label">Birth Date:</label>
                                                        <input type="date" class="form-control " name="b_date" value="<?php echo htmlspecialchars($row['b_date']) ?>" readonly>
                                                    </div>
                                                    <div class="col-md-5">
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
                                                        <div class="col-md-5">
                                                            <label class="form-label">Day Banned:</label>
                                                            <input type="text" class="form-control readonly-field" name="dayBan" value="<?php echo htmlspecialchars($row['dayBan']); ?>" readonly>
                                                        </div>
                                                         <div class="col-md-5">
                                                            <label class="form-label">Tricycle Color:</label>
                                                            <input type="text" class="form-control" name="tricColor" value="<?php echo htmlspecialchars($row['tricColor']) ?>" readonly>
                                                        </div>
                                                    </div>
                                                   
                                                    <div class="form-group row">
                                                        <div class="col-md-5">
                                                            <label class="form-label">Body Built:</label>
                                                            <input type="text" class="form-control" name="tricType" value="<?php echo htmlspecialchars($row['tricType']); ?>" readonly>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <label class="form-label">TODA:</label>
                                                            <input type="text" class="form-control" name="toda" value="<?php echo htmlspecialchars($row['toda']) ?>" readonly>
                                                        </div>
                                                
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-3">
                                                            <label class="form-label">Driver's License No:</label>
                                                            <input type="text" class="form-control" name="license_no" value="<?php echo htmlspecialchars($row['license_no']); ?>" readonly>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">License Classification:</label>
                                                            <input type="text" class="form-control" name="license_class" value="<?php echo htmlspecialchars($row['license_class']); ?>" readonly>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label">Driver's License Expiration:</label>
                                                            <input type="date" class="form-control" name="license_exp" value="<?php echo htmlspecialchars($row['license_exp']) ?>" readonly>
                                                        </div>
                                                
                                                    </div>
                                            </div>
                                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']) ?>">
                                            <div  class="text-right">
                                                <button type="submit" class="btn btn-success" name="submit">Update</button>
                                                <a href="franchiseHolders.php" class="btn btn-danger" style="margin-right:150px">Exit</a>
                                            </div>
                                            
                                      </form>  
                            </div>
                            
                        <div class="tab-pane fade" id="requirements" role="tabpanel" aria-labelledby="requirements-tab">
                            <div class="card-header" style="background-color: #FFFFFF; padding: 2px; font-size: 14px;">
                                            <h5>Requirements Submitted <i id="edit-icon" class="fas fa-edit" style="cursor: pointer; color: orange;"></i></h5>
                                        </div>

                                        <form action="update_requirements.php" id="uploadForm" method="post" enctype="multipart/form-data" style="width:40vw; min-width:300px;">
                                            <style>
                                                    table td {
                                                    text-align: center;
                                                    }
                                                    table th {
                                                    text-align: center;
                                                    }

                                                </style>
                                            
                                                <table class="table ">
                                                    <thead>
                                                        <tr>
                                                            <th>File Name</th>
                                                            <th>View Requirements</th>
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
                                                           
                                                            <label for="operatorsPic" class="btn btn-primary"><i class="fas fa-upload"></i> Upload</label>
                                                            <input type="file" id="operatorsPic" name="operatorsPic" style="display: none;">
                                                            </td>
                                                        </tr>
                                                        <tr>


                                                        <tr>
                                                            <td>PSA / Voter's ID/Certification</td>
                                                            <td>
                                                                <?php if (!empty($row['valid_id'])): ?>
                                                                    <a href="../../uploads/valid_id/<?php echo htmlspecialchars($row['valid_id']); ?>" target="_blank" class="btn btn-white">View </a>
                                                                    <?php else: ?>
                                                                        <span>Pending for upload</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                            <label for="valid_id" class="btn btn-primary"><i class="fas fa-upload"></i> Upload</label>
                                                            <input type="file" id="valid_id" name="valid_id" style="display: none;">
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
                                                            <label for="or" class="btn btn-primary"><i class="fas fa-upload"></i> Upload</label>
                                                            <input type="file" id="or" name="or" style="display: none;">
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
                                                            <label for="license" class="btn btn-primary"><i class="fas fa-upload"></i> Upload</label>
                                                            <input type="file" id="license" name="license" style="display: none;">
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
                                                                        echo "Pending for upload";
                                                                    }
                                                                endif; ?>
                                                            </td>

                                                            <td>
                                                                <label for="tricyclePicsUpload" class="btn btn-primary">
                                                                    <i class="fas fa-upload"></i> Upload
                                                                </label>
                                                                <input type="file" id="tricyclePicsUpload" class="form-control" name="tricyclePics[]" multiple style="display:none;">
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
                                                            <label for="toda_cert" class="btn btn-primary"><i class="fas fa-upload"></i> Upload</label>
                                                            <input type="file" id="toda_cert" name="toda_cert" style="display: none;">
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
                                                            <label for="med_res" class="btn btn-primary"><i class="fas fa-upload"></i> Upload</label>
                                                            <input type="file" id="med_res" name="med_res" style="display: none;">
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
                                                            <label for="deedSale" class="btn btn-primary"><i class="fas fa-upload"></i> Upload</label>
                                                            <input type="file" id="deedSale" name="deedSale" style="display: none;">
                                                            </td>
                                                        </tr>


                                                        <tr>
                                                            <td>Tricycle Inspection</td>
                                                            <td>
                                                                <?php 
                                                                    if (!empty($row['tric_insp'])): ?><?php $filePath = '../../uploads/tric_insp/' . htmlspecialchars($row['tric_insp']);
                                                                ?>
                                                                <a href="<?php echo $filePath; ?>" target="_blank"class="btn btn-white">View</a>
                                                                <?php else: ?>
                                                                    <span>Pending for upload</span>
                                                            <?php endif; ?>
                                                            </td>
                                                            <td>
                                                            <label for="tric_insp" class="btn btn-primary"><i class="fas fa-upload"></i> Upload</label>
                                                            <input type="file" id="tric_insp" name="tric_insp" style="display: none;">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                        <td>Barangay Clearance for Renewal</td>
                                                                <td>
                                                                    <?php 
                                                                        // Check if the 'brgy_clr' field is not empty
                                                                        if (!empty($row['brgy_clr'])): 
                                                                            // Define the file path
                                                                            $filePath = '../../uploads/brgy_clr/' . htmlspecialchars($row['brgy_clr']);
                                                                    ?>
                                                                        <a href="<?php echo $filePath; ?>" target="_blank" class="btn btn-white">View</a>
                                                                    <?php else: ?>
                                                                        <span>Pending for upload</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                            </td>
                                                            <td>
                                                            <label for="brgy_clr" class="btn btn-primary"><i class="fas fa-upload"></i> Upload</label>
                                                            <input type="file" id="brgy_clr" name="brgy_clr" style="display: none;">
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                                <br>
                                                 <input type="hidden" name="TFno" id="TFno" value="<?php echo htmlspecialchars($row['TFno']); ?>">
                                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                                <div  class="text-right">
                                                <button type="submit" class="btn btn-success" name="submit">Update</button>
                                                <a href="franchiseHolders.php" class="btn btn-danger" >Exit</a>
                                                </div>
                                            </form> 
                                        </div>

                                        <div class="tab-pane fade" id="violations" role="tabpanel" aria-labelledby="violations-tab">
                                        <div class="card-header" style="background-color: #FFFFFF; padding: 2px; font-size: 14px;">
                                        <h5>Violation History </h5>
                                        </div>
                                        <br>
                                        <form action="#" method="post">
                                        <?php 
                                        $violations = json_decode($row['violations'], true); 
                                        $displayedViolations = []; // Array to track unique violations
                                        
                                        if (!empty($violations) && is_array($violations)) { 
                                            foreach ($violations as $violation) { 
                                                // Create a unique identifier for the violation
                                                $violationKey = $violation['ticketNo'] . '|' . $violation['violationDate'] . '|' . $violation['violationType'];
                                        
                                                // Check if this violation has already been displayed
                                                if (!in_array($violationKey, $displayedViolations) && $violation['penaltyStatus'] === 'Paid') {
                                                    // Add the violation to the displayed list
                                                    $displayedViolations[] = $violationKey;
                                        
                                                    echo "<div class='form-group row' style='margin-bottom: 20px; margin-left: 10px; margin-right: 10px;' >";
                                                    echo "<div class='border p-3 rounded'>";
                                        
                                                    echo "<div class='form-group row'>";
                                                    echo "<div class='col-md-6'>";
                                                    echo "<label><strong>Ticket No:</strong></label>";
                                                    echo "<input type='text' class='form-control' value='" . htmlspecialchars($violation['ticketNo']) . "' readonly>";
                                                    echo "</div>";
                                                    echo "<div class='col-md-6'>";
                                                    echo "<label><strong>Violation Date:</strong></label>";
                                                    echo "<input type='text' class='form-control' value='" . htmlspecialchars($violation['violationDate']) . "' readonly>";
                                                    echo "</div>";
                                                    echo "</div>";
                                        
                                                    echo "<div class='form-group row'>";
                                                    echo "<div class='col-md-6'>";
                                                    echo "<label><strong>Violation Type:</strong></label>";
                                                    echo "<input type='text' class='form-control' value='" . htmlspecialchars($violation['violationType']) . "' readonly>";
                                                    echo "</div>";
                                                    echo "<div class='col-md-6'>";
                                                    echo "<label><strong>Penalty Charged:</strong></label>";
                                                    echo "<input type='text' class='form-control' value='" . htmlspecialchars($violation['penaltyCharged']) . "' readonly>";
                                                    echo "</div>";
                                                    echo "</div>";
                                        
                                                    echo "<div class='form-group row'>";
                                                    echo "<div class='col-md-6'>";
                                                    echo "<label><strong>Offense Type:</strong></label>";
                                                    echo "<input type='text' class='form-control' value='" . htmlspecialchars($violation['offenseType']) . "' readonly>";
                                                    echo "</div>";
                                                    echo "<div class='col-md-6'>";
                                                    echo "<label><strong>Enforcer:</strong></label>";
                                                    echo "<input type='text' class='form-control' value='" . htmlspecialchars($violation['enforcer']) . "' readonly>";
                                                    echo "</div>";
                                                    echo "</div>";
                                        
                                                    echo "</div>";
                                                    echo "</div>";
                                                }
                                            } 
                                        } else { 
                                            echo "No pending violations"; 
                                        }

                                        ?>

                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                        <div class="text-right">
                                            <a href="franchiseHolders.php" class="btn btn-danger">Exit</a>
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane fade" id="complaint" role="tabpanel" aria-labelledby="complaint-tab">
                                <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #FFFFFF; padding: 2px; font-size: 14px; margin-top: 20px;">
                                    <h5 class="mb-0">Complaint History</h5>
                                   
                                </div>
                                    <br>
                                    
                                    <form action="#" method="post">
                                     <?php 
                                        $complaints = json_decode($row['complaints'], true); 
                                        $displayedComplaints = []; // Array to track unique complaints
                                        
                                        if (!empty($complaints) && is_array($complaints)) { 
                                            foreach ($complaints as $complaint) { 
                                                // Ensure that each $complaint has the expected keys
                                                $complaintDate = isset($complaint['date']) ? htmlspecialchars($complaint['date']) : 'N/A';
                                                $complaintDescription = isset($complaint['description']) ? htmlspecialchars($complaint['description']) : 'N/A';
                                                $status = isset($complaint['status']) ? htmlspecialchars($complaint['status']) : 'N/A';
                                                
                                                // Only display complaints that are marked as 'Resolved'
                                                if ($status === 'Resolved') {
                                                    // Create a unique identifier for the complaint (e.g., date and description combination)
                                                    $complaintKey = $complaintDate . '|' . $complaintDescription;
                                            
                                                    // Check if this complaint has already been displayed
                                                    if (!in_array($complaintKey, $displayedComplaints)) {
                                                        // Add the complaint to the displayed list
                                                        $displayedComplaints[] = $complaintKey;
                                                        
                                                        echo "<div class='form-group row' style='margin-bottom: 20px; margin-left: 10px; margin-right: 10px;'>";
                                                        echo "<div class='border p-3 rounded'>";
                                                        
                                                        echo "<div class='form-group row'>";
                                                        echo "<div class='col-md-6'>";
                                                        echo "<label><strong>Date of Complaint:</strong></label>";
                                                        echo "<input type='text' class='form-control' value='" . $complaintDate . "' readonly>";
                                                        echo "</div>";
                                                        echo "<div class='col-md-6'>";
                                                        echo "<label><strong>Description of Complaint:</strong></label>";
                                                        echo "<input type='text' class='form-control' value='" . $complaintDescription . "' readonly>";
                                                        echo "</div>";
                                                        echo "</div>";
                                                        
                                                        echo "</div>";
                                                        echo "</div>";
                                                    }
                                                }
                                            } 
                                        } else { 
                                            echo "No pending complaints"; 
                                            echo "<br>"; 
                                        }
                                        ?>

                                        <input type="hidden" name="id" id="operatorId" value="<?php echo htmlspecialchars($row['id']); ?>">
                                        <input type="hidden" name="TFno" id="TFno" value="<?php echo htmlspecialchars($row['TFno']); ?>">
                                        <br>
                                      <div class="content d-flex justify-content-between align-items-center" style="margin-left:10px;">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sendMessageModal">
                                                Send Message
                                            </button>
                                            <a href="franchiseHolders.php" class="btn btn-danger">Exit</a>
                                        </div>
                                          <!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#complaintModal">
                                                Add Complaint
                                            </button>-->
                                    </form>
                                </div>

                                <!-- Modal Adding Complaint History-->
                                <div class="modal fade" id="complaintModal" tabindex="-1" role="dialog" aria-labelledby="complaintModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="complaintModalLabel">Add Complaint History</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="complaintForm">
                                                    <div class="form-group">
                                                        <label for="complaintDate">Date of Complaint</label>
                                                        <input type="date" class="form-control" id="complaintDate" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="complaintDescription">Description of Complaint</label>
                                                        <textarea class="form-control" id="complaintDescription" rows="3" required></textarea>
                                                    </div>
                                                    <input type="hidden" name="id" id="operatorId" value="<?php echo htmlspecialchars($row['id']); ?>">
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
                                                <button type="button" class="btn btn-primary" onclick="submitComplaint()">Add Complaint</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                               <!-- Modal Send Message -->
                                <div class="modal fade" id="sendMessageModal" tabindex="-1" role="dialog" aria-labelledby="sendMessageModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="sendMessageModalLabel">Add Interview Schedule and Complaint</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Form Start -->
                                                <form id="scheduleComplaintForm">
                                                    <div class="form-group">
                                                        <label for="interviewSchedule">Interview Schedule</label>
                                                        <input type="datetime-local" class="form-control" id="insterviewSchedule" name="interview_schedule" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="complaintDescription">Description of Complaint</label>
                                                        <textarea class="form-control" id="complaintDescription" name="complaint_description" rows="4" required></textarea>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="complaint_date">Date of Complaint</label>
                                                        <input type="date" class="form-control" id="complaint_date" name="complaint_date" required>
                                                    </div>
                                                    <input type="hidden" name="id" id="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                                </form>
                                                <!-- Form End -->
                                            </div>
                                            <div class="modal-footer">
                                                <div style="position: relative; display: inline-block;">
                                                    <button type="button" class="btn btn-primary" onclick="sendMessageComplaint()">
                                                        Send Message
                                                    </button>
                                                    <span id="spinnerContainer" style="display: none; position: absolute; left: -2rem; top: 50%; transform: translateY(-50%);">
                                                        <div style="width: 1.5rem; height: 1.5rem; border: 0.2em solid rgba(0, 0, 0, 0.1); border-top: 0.2em solid #007bff; border-radius: 50%; animation: spinner-border 0.75s linear infinite;" role="status"></div>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <div class="tab-pane fade" id="qr" role="tabpanel" aria-labelledby="qr-tab">
                                <div class="card-header" style="background-color: #FFFFFF; padding: 2px; font-size: 14px;">
                                    <h5>QR Code Generation</h5>
                                </div>
                                <br>
                               <form action="generate_qr.php" method="post" enctype="multipart/form-data" style="width:50vw; min-width:300px;">
                                    <?php
                                    // Check if QR code exists and display it
                                    $qrCodeFile = "../../qrcodes/" . htmlspecialchars($row['qr_code']);
                                    if (file_exists($qrCodeFile)) {
                                        echo '<img id="qrCodeImage" src="' . $qrCodeFile . '" alt="QR Code" style="height: 170px; width: 160px; object-fit: cover; border: 1px solid #d3d3d3; overflow: hidden;">';
                                    } else {
                                        echo 'QR Code not found.';
                                    }
                                    ?>
                                    <div class="profile-info mt-3">
                                        <input type="hidden" name="id" id="qrCodeId" value="<?php echo htmlspecialchars($row['id']) ?>">
                                        <div class="text-right">
                                            <?php if (empty($row['qr_code'])): ?>
                                                <button type="submit" class="btn btn-success" name="submit">Generate QR Code</button>
                                            <?php endif; ?>
                                            <button type="button" class="btn btn-warning" onclick="printQRCode()">Print QR Code</button>
                                            <!--<button type="button" class="btn btn-secondary" onclick="downloadQRCode()">Download</button>-->
                                            <a href="franchiseHolders.php" class="btn btn-danger" style="margin-right:150px">Exit</a>
                                        </div>
                                    </div>
                                </form>
                                                                
                                <script>
                                    function printQRCode() {
                                        var qrCodeWindow = window.open('', 'Print QR Code', 'height=600,width=600');
                                        qrCodeWindow.document.write('<html><head><title>Print QR Code</title>'); // title while printing
                                        qrCodeWindow.document.write('</head><body>');
                                        qrCodeWindow.document.write('<img src="' + document.getElementById('qrCodeImage').src + '" style="width: 300px; height: 300px;">'); // Adjust the size as needed
                                        qrCodeWindow.document.write('</body></html>');
                                        qrCodeWindow.document.close();
                                        qrCodeWindow.focus(); 
                                        qrCodeWindow.print();
                                    }

                                    /*function downloadQRCode() {
                                            var qrCodeImage = document.getElementById('qrCodeImage');
                                            var qrCodeId = document.getElementById('qrCodeId').value;
                                            var link = document.createElement('a');
                                            link.download = 'qrcode_' + qrCodeId + '.png'; // Filename with ID
                                            link.href = qrCodeImage.src;
                                            document.body.appendChild(link);
                                            link.click();
                                            document.body.removeChild(link);
                                        }*/
                                </script>
                            </div>
                             <div class="tab-pane fade" id="renewal" role="tabpanel" aria-labelledby="renewal-tab">
                                <div class="card-header" style="background-color: #FFFFFF; padding: 2px; font-size: 14px;">
                                    <h5>Franchise Renewal <i id="edit" class="fas fa-edit" style="cursor: pointer; color: orange;"></i></h5>
                                </div>
                                <br>
                                <form action="update_renewal.php" method="post" enctype="multipart/form-data" style="width:50vw; min-width:300px;">
                                            <div class="editable-fields">
                                                <div class="form-group row">
                                                     <div class="col-md-5">
                                                        <label class="form-label">Franchise Status:</label>
                                                         <input type="text" class="form-control" id="franchise_status" name="status" value="<?php echo htmlspecialchars($row['status']); ?>" readonly> 
                                                    </div>
                                                     <div class="col-md-5">
                                                        <label class="form-label">Expiration Date:</label>
                                                        <input type ="text" class="form-control" name="expDate" value="<?php echo htmlspecialchars($row['expDate']); ?>" readonly> 
                                                    </div>

                                                </div>
                                                 <div class="form-group row">
                                                     <div class="col-md-5">
                                                        <label class="form-label">Date of Renewal:</label>
                                                        <input type="date" class="form-control" name="dtOfrenewal" value="<?php echo htmlspecialchars($row['dtOfrenewal']) ?>" readonly>
                                                     </div>
                                                     <div class="col-md-5">
                                                        <label class="form-label">Amount Paid:</label>
                                                        <input type="number" class="form-control" name="renewal_payment" value="<?php echo htmlspecialchars($row['renewal_payment']) ?>" readonly>
                                                     </div>
                                                </div>
                                                 <?php if ($row['status'] === 'Expired') : ?>
                                                <div class="form-group row">
                                                    <div class="col-md-5">
                                                        <label class="form-label">Penalty:</label>
                                                        <input type="number" class="form-control" name="penalty" value="<?php echo htmlspecialchars($row['penalty']); ?>" readonly>
                                                    </div>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']) ?>">
                                            <input type="hidden" name="TFno" value="<?php echo htmlspecialchars($row['TFno']) ?>">
                                            <div  class="text-right">
                                                <button type="submit" class="btn btn-success" name="submit">Update</button>
                                                <a href="franchiseHolders.php" class="btn btn-danger" style="margin-right:150px">Exit</a>
                                            </div>
                                              
                                      </form>  
                                      <?php if ($row['status'] === 'Renewed') : ?>
                                        <div class="text-left" style="margin-top: -25px;">
                                            <button id="generateReceipt" class="btn btn-primary">Generate Order of Payment</button>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div id="receiptTemplate" style="display: none;">
                                    <div style="font-family: Arial, sans-serif; width: 100%; max-width: 600px; margin: 0 auto; border: 1px solid black; padding: 20px;">
                                        <div style="text-align: center;">
                                            <img src="../../assets/img/mtfrbLogo.jpg" alt="Logo1" style="width: 60px; vertical-align: middle;">
                                            <span style="font-size: 16px; font-weight: bold;">Municipal Tricycle Franchising Regulatory Board - Lucban</span>
                                            <img src="/../../assets/img/sbLogo.png" alt="Logo2" style="width: 60px; vertical-align: middle;">
                                            <p style="margin: 0;">88 A. Racelis Ave, Lucban, Quezon</p>
                                        </div>
                                        <h2 style="text-align: center;">ORDER OF PAYMENT</h2>
                                        <p><strong>Tricycle Franchise No:</strong> <span id="TFno"><?php echo htmlspecialchars($row['TFno']); ?></span></p>
                                        <p><strong>Name:</strong> <span id="name"><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></span></p>
                                        <p><strong>Date of Renewal:</strong> <span id="dtOfRenewal"><?php echo htmlspecialchars($row['dtOfrenewal']); ?></span></p>
                                        <p><strong>Amount Paid:</strong> <span id="renewalPayment"><?php echo htmlspecialchars($row['renewal_payment']); ?></span></p>
                                        
                                        <?php if (!empty($row['penalty'])) : ?>
                                        <p><strong>Penalty:</strong> <span id="penalty"><?php echo htmlspecialchars($row['penalty']); ?></span></p>
                                        <?php endif; ?>
                                
                                        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                                            <thead>
                                                <tr>
                                                    <th style="border: 1px solid black; padding: 5px;">Nature of Collection</th>
                                                    <th style="border: 1px solid black; padding: 5px;">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               <tr>
                                                    <td style="border: 1px solid black; padding: 5px;">Renewal Fee</td>
                                                    <td style="border: 1px solid black; padding: 5px;" id="penaltyCharged"><?php echo '₱' . number_format($row['renewal_payment'], 2); ?></td>
                                                </tr>
                                                
                                                <?php if (!empty($row['penalty'])) : ?>
                                                <tr>
                                                    <td style="border: 1px solid black; padding: 5px;">Penalty</td>
                                                    <td style="border: 1px solid black; padding: 5px;" id="penaltyCharged"><?php echo '₱' . number_format($row['penalty'], 2); ?></td>
                                                </tr>
                                                <?php endif; ?>

                                            </tbody>
                                        </table>
                                          <!-- Hidden numeric total amount -->
                                            <input type="hidden" id="totalAmount" value="<?php 
                                                $totalAmount = $row['renewal_payment'] + ($row['penalty'] ? $row['penalty'] : 0);
                                                echo htmlspecialchars($totalAmount);
                                            ?>">
                                            
                                            <!-- Display total amount in words -->
                                            <p><strong>Total Amount (in words):</strong> <span id="totalAmountWords"></span></p>
                                            <div style="display: flex; justify-content: right; text-align: center;">
                                                <div>
                                                    <p>_________________</p>
                                                    <p><strong>Signature</strong></p>
                                                </div>
                                                </div>
                                    </div>
                                </div>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            const generateReceiptButton = document.getElementById('generateReceipt');
                                            
                                            // Check if the button exists before adding the event listener
                                            if (generateReceiptButton) {
                                                generateReceiptButton.addEventListener('click', function () {
                                                    const renewalPayment = <?php echo $row['renewal_payment']; ?>;
                                                    const penalty = <?php echo $row['penalty'] ? $row['penalty'] : 0; ?>;
                                                    const totalAmount = renewalPayment + penalty;
                                                    
                                                    // Function to convert number to words
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
                                            
                                                    // Update the receipt's content with total amount in words and "Pesos Only"
                                                    document.getElementById('totalAmountWords').textContent = numberToWords(totalAmount) + " Pesos Only";
                                                
                                                    // Prepare the receipt content
                                                    const receiptContent = document.getElementById('receiptTemplate').innerHTML;
                                                    const receiptWindow = window.open('', '_blank');
                                                    receiptWindow.document.write(receiptContent);
                                                    receiptWindow.document.close();
                                                    receiptWindow.print();
                                                });
                                            }
                                        });
                                    </script>
                                </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
    
 
<?php 
 
        include "../include/scripts.php"; 
        include "modal_viewDetailsHolders.php";
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
        
        document.getElementById('edit').addEventListener('click', function() {
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
        

    function submitComplaint() {
    const operatorId = document.getElementById('operatorId').value;
    const complaintDate = document.getElementById('complaintDate').value;
    const complaintDescription = document.getElementById('complaintDescription').value;

    if (complaintDate && complaintDescription) {
        // Initialize an array for existing complaints
        let existingComplaints = [];

        // Add the new complaint to the array
        existingComplaints.push({
            date: complaintDate,
            description: complaintDescription
        });

        // Convert the array to a JSON string
        const complaintJSON = JSON.stringify(existingComplaints);

        // Send data to the backend via AJAX
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "save_complaints.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    // Show success message using SweetAlert
                    Swal.fire({
                        title: 'Success!',
                        text: 'Complaint saved successfully!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Close the modal
                            $('#complaintModal').modal('hide');
                            
                            // Redirect to the edit_operatorDash page
                            window.location.href = 'edit_operatorDash.php?id=<?php echo $id; ?>';
                        }
                    });

                    // Reset the form
                    document.getElementById('complaintForm').reset();
                } else {
                    // Show error message using SweetAlert
                    Swal.fire({
                        title: 'Error!',
                        text: 'Error saving complaint: ' + xhr.responseText,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            }
        };
        xhr.send("id=" + encodeURIComponent(operatorId) + "&complaints=" + encodeURIComponent(complaintJSON));
    } else {
        // Alert user to fill in all fields
        Swal.fire({
            title: 'Warning!',
            text: 'Please fill in all fields.',
            icon: 'warning',
            confirmButtonText: 'OK'
        });
    }
}

function sendMessageComplaint() {
    const form = document.getElementById('scheduleComplaintForm');
    const formData = new FormData(form);
    const spinner = document.getElementById('spinnerContainer');
    const button = document.querySelector('button[onclick="sendMessageComplaint()"]');
    
    // Show spinner and disable button
    spinner.style.display = 'inline-block';
    button.disabled = true;

    fetch('sendMessageComplaint.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text()) // Get response as text first
    .then(text => {
        console.log('Raw Response Text:', text); // Log the raw response

        try {
            const data = JSON.parse(text); // Parse the text to JSON
            console.log('Response Data:', data);

            if (data.success) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Message sent successfully!',
                    icon: 'success',
                    confirmButtonText: 'Ok'
                }).then(() => {
                    $('#sendMessageModal').modal('hide');
                    window.location.href = 'edit_operatorDash.php?id=<?php echo $id; ?>';
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: data.message || 'Failed to send the message.',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
            }
        } catch (e) {
            console.error('Error parsing JSON:', e);
            Swal.fire({
                title: 'Error!',
                text: 'Received invalid response. Check the console for details.',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: 'Error!',
            text: 'An error occurred. Check the console for details.',
            icon: 'error',
            confirmButtonText: 'Ok'
        });
    })
    .finally(() => {
        // Hide spinner and re-enable button
        spinner.style.display = 'none';
        button.disabled = false;
    });
}

</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var maxFileSize = 1 * 1024 * 1024; // 1 MB
    var validExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'gif'];
    
    // Array of file inputs to validate
    var fileInputs = [
        document.getElementById('operatorsPic'),
        document.getElementById('toda_cert'),
        document.getElementById('valid_id'),
        document.getElementById('sedula'),
        document.getElementById('brgy_clr'),
        document.getElementById('driversPic1'),
        document.getElementById('driversPic2'),
        document.getElementById('license'),
        document.getElementById('med_res'),
        document.getElementById('cr'),
        document.getElementById('or'),
        document.getElementById('tricyclePics'),
        document.getElementById('tric_insp'),
        document.getElementById('deedSale')
    ];

    // Filter out any null elements (in case any IDs are not present in the DOM)
    fileInputs = fileInputs.filter(function(fileInput) {
        return fileInput !== null;
    });

    // Function to validate file input
    function validateFileInput(fileInput) {
        var file = fileInput.files[0];

        if (file) {
            var fileSize = file.size;
            var fileExtension = file.name.split('.').pop().toLowerCase();

            if (fileSize > maxFileSize) {
                Swal.fire({
                    icon: 'error',
                    title: 'File too large!',
                    text: 'File size exceeds 1 MB for ' + fileInput.name + '.',
                });
                fileInput.value = ''; // Clear the input
            } else if (!validExtensions.includes(fileExtension)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid file type!',
                    text: 'Only PDF and image files are allowed for ' + fileInput.name + '.',
                });
                fileInput.value = ''; // Clear the input
            }
        }
    }

    // Attach change event listeners to each file input
    fileInputs.forEach(function(fileInput) {
        fileInput.addEventListener('change', function() {
            validateFileInput(fileInput);
        });
    });

    // Handle form submission if needed
    document.getElementById('uploadForm').addEventListener('submit', function(event) {
        var valid = true;
        fileInputs.forEach(function(fileInput) {
            var file = fileInput.files[0];
            if (file) {
                var fileSize = file.size;
                var fileExtension = file.name.split('.').pop().toLowerCase();
                if (fileSize > maxFileSize || !validExtensions.includes(fileExtension)) {
                    valid = false;
                }
            }
        });
        if (!valid) {
            event.preventDefault(); // Prevent form submission if any file is invalid
            Swal.fire({
                icon: 'error',
                title: 'Invalid files!',
                text: 'Please check the file sizes and types before submitting.'
            });
        }
    });
});
</script>


