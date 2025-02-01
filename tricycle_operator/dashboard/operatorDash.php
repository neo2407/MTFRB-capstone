<?php 
    include "headerOperator.php";
    include "topbarOperator.php";
?>
<style>
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

input[readonly] {
    background-color: #e9ecef; 
}
</style>
<!-- Profile 1 - Bootstrap Brain Component -->
<section class="py-3 py-md-5 py-xl-8" style="margin-top:60px;">

  <div class="container ">
    <h3 style="color: #f5f5f5; margin-left:15px;">TRICYCLE OPERATOR PROFILE</h3>
    <div class="row gy-4 gy-lg-0 justify-content-center" >
      <div class="col-12 col-lg-6 col-xl-4"> 
        <div class="row gy-6">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
              <div class="d-flex flex-column align-items-center text-center">
                  <img src="../../uploads/operator/<?php echo htmlspecialchars($row['operatorsPic']); ?>" 
                      alt="Profile Picture" 
                      class="rounded-circle border border-dark" 
                      style="width: 170px; height: 170px; object-fit: cover; border-width: 3px;">
              </div>
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
                        <h6 class="mb-0">Franchise Expiration Date:</h6>
                        <span class="text-secondary" style="margin-left: 10px;"><?php echo htmlspecialchars($row['expDate']); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                      <h6 class="mb-0">Tricycle Color: </h6>
                      <span class="text-secondary">  <?php echo htmlspecialchars($row['tricColor']); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                      <h6 class="mb-0">Tricycle Type: </h6>
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
        </div>
      </div>

      <div class="col-12 col-lg-6 col-xl-8">
        <div class="card widget-card border-light shadow-sm">
          <div class="card-body p-4">
            <ul class="nav nav-tabs" id="profileTab" role="tablist">
                <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab" aria-controls="info" aria-selected="true">Franchise Information</button>
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

            <div class="tab-content pt-4" id="profileTabContent">
                <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                  <div class="card-header" style="background-color: #FFFFFF; padding: 2px; margin-left:30px; font-size: 14px;">
                      <h5>Franchise Information <i id="edit-icon"  style="cursor: pointer; color: orange;"></i></h5>
                  </div>
                <br>
                
                <form action="#" method="post" enctype="multipart/form-data" style="padding-left: 10px; padding-right: 10px;">
                    <div class="editable-fields">
                        <div class="form-group row justify-content-center" style="margin-bottom:20px;">
                            <div class="col-md-5">
                            <label class="form-label semi-bold">Tricycle Franchise #:</label>
                                <input type="text" class="form-control readonly-field " name="TFno" value="<?php echo htmlspecialchars($row['TFno']) ?>" readonly>
                            </div>
                            <div class="col-md-5">
                            <label class="form-label semi-bold">Franchise Granting Date:</label>
                                <input type="text" class="form-control" name="grant_date" value="<?php echo htmlspecialchars($row['grant_date']) ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row justify-content-center" style="margin-bottom:20px;">
                            <div class="col-md-4">
                            <label class="form-label semi-bold">Last Name:</label>
                                <input type="text" class="form-control" name="last_name" value="<?php echo htmlspecialchars($row['last_name']) ?>" readonly>
                            </div>
                            <div class="col-md-4">
                            <label class="form-label semi-bold">First Name:</label>
                                <input type="text" class="form-control" name="first_name" value="<?php echo htmlspecialchars($row['first_name']) ?>" readonly>
                            </div>
                            <div class="col-md-2">
                            <label class="form-label semi-bold">Middle Name:</label>
                                <input type="text" class="form-control" name="m_name" value="<?php echo htmlspecialchars($row['m_name']) ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row justify-content-center"  style="margin-bottom:20px;">
                            <div class="col-md-4">
                            <label class="form-label semi-bold">Contact Number:</label>
                                <input type="number" class="form-control" name="contact_num" value="<?php echo htmlspecialchars($row['contact_num']) ?>" readonly>
                            </div>
                            <div class="col-md-4">
                            <label class="form-label semi-bold">Email:</label>
                                <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($row['email']) ?>" readonly>
                            </div>
                            <div class="col-md-2">
                            <label class="form-label semi-bold">Age:</label>
                                <input type="number" class="form-control" name="age" value="<?php echo htmlspecialchars($row['age']) ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row justify-content-center" style="margin-bottom:20px;">
                             <div class="col-md-5">
                            <label class="form-label semi-bold">Birth Date:</label>
                                <input type="date" class="form-control" name="b_date" value="<?php echo htmlspecialchars($row['b_date']) ?>" readonly>
                            </div>
                            <div class="col-md-5">
                            <label class="form-label semi-bold">Address:</label>
                                <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($row['address']) ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row justify-content-center" style="margin-bottom:20px;">
                            <div class="col-md-5">
                            <label class="form-label semi-bold">Registered Driver #1:</label>
                                <input type="text" class="form-control" name="driver1_name" value="<?php echo htmlspecialchars($row['driver1_name']) ?>" readonly>
                            </div>
                            <div class="col-md-5">
                            <label class="form-label semi-bold">Registered Driver #2:</label>
                                <input type="text" class="form-control" name="driver2_name" value="<?php echo !empty($row['driver2_name']) ? htmlspecialchars($row['driver2_name']) : 'N/A'; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row justify-content-center" style="margin-bottom:20px;">
                            <div class="col-md-5">
                            <label class="form-label semi-bold">Day Banned:</label>
                                <input type="text" class="form-control readonly-field" name="dayBanned" value="<?php echo htmlspecialchars($row['dayBan']); ?>" readonly>
                            </div>
                            <div class="col-md-5">
                            <label class="form-label semi-bold">Date of Renewal:</label>
                                <input type="text" class="form-control" name="dtOfrenewal" value="<?php echo htmlspecialchars($row['dtOfrenewal']) ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row justify-content-center" style="margin-bottom:20px;">
                            <div class="col-md-5">
                                <label class="form-label semi-bold">Expiration Date:</label>
                                <input type="text" class="form-control" name="expirationDate" value="<?php echo htmlspecialchars($row['expDate']); ?>" readonly>
                            </div>
                            <div class="col-md-5">
                            <label class="form-label semi-bold">Tricycle Color:</label>
                                <input type="text" class="form-control" name="tricColor" value="<?php echo htmlspecialchars($row['tricColor']) ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row justify-content-center" style="margin-bottom:20px;">
                            <div class="col-md-5">
                            <label class="form-label semi-bold">Tricycle Made:</label>
                                <input type="text" class="form-control" name="tricType" value="<?php echo htmlspecialchars($row['tricType']); ?>" readonly>
                            </div>
                            <div class="col-md-5">
                            <label class="form-label semi-bold">TODA:</label>
                                <input type="text" class="form-control" name="toda" value="<?php echo htmlspecialchars($row['toda']) ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row justify-content-center" style="margin-bottom:20px;">
                            <div class="col-md-3">
                             <label class="form-label semi-bold">Driver's License No:</label>
                                <input type="text" class="form-control" name="license_no" value="<?php echo htmlspecialchars($row['license_no']); ?>" readonly>
                             </div>
                             <div class="col-md-3">
                            <label class="form-label semi-bold">License Classification:</label>
                               <input type="text" class="form-control" name="license_class" value="<?php echo htmlspecialchars($row['license_class']); ?>" readonly>
                            </div>
                         <div class="col-md-4">
                            <label class="form-label semi-bold">Driver's License Expiration:</label>
                                <input type="date" class="form-control" name="license_exp" value="<?php echo htmlspecialchars($row['license_exp']) ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']) ?>">
                    <br>
                    <!--<div class="text-end">
                        <button type="submit" class="btn btn-success" name="submit">Update</button>
                        <a href="franchiseHolders.php" class="btn btn-danger" style="margin-right:60px">Exit</a>
                    </div>-->
                </form>
          
            </div>

            <div class="tab-pane fade" id="requirements" role="tabpanel" aria-labelledby="requirements-tab">
              <div class="card-header" style="background-color: #FFFFFF; padding: 2px; margin-left:10px; font-size: 14px;">
                                            <h5>Requirements Submitted <i id="edit-icon" style="cursor: pointer; color: orange;"></i></h5>
                                        </div>

                                        <form action="#" method="post" enctype="multipart/form-data">
                                            
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>File Name</th>
                                                            <th>Requirements</th>
                                                          
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Operator Picture</td>
                                                            <td>
                                                                <?php if (!empty($row['operatorsPic'])): ?>
                                                                    <a href="../../uploads/operator/<?php echo htmlspecialchars($row['operatorsPic']); ?>" target="_blank" class=" btn btn-primary"><i class="fa fa-eye"></i>  View Attachment </a>
                                                                 <?php else: ?>
                                                                        <span>Pending for upload</span>
                                                                <?php endif; ?>
                                                            </td>
                                                        
                                                        </tr>
                                                        <tr>
                                                            <td>Driver's License</td>
                                                            <td>
                                                                <?php if (!empty($row['license'])): ?>
                                                                    <a href="../../uploads/license/<?php echo htmlspecialchars($row['license']); ?>" target="_blank" class=" btn btn-primary"><i class="fa fa-eye"></i>  View Attachment </a>
                                                                 <?php else: ?>
                                                                        <span>Pending for upload</span>
                                                                <?php endif; ?>
                                                            </td>
                                                          
                                                        </tr>
                                                        <tr>
                                                            <td>(CR) Certificate of Registration from LTO</td>
                                                            <td>
                                                                <?php if (!empty($row['cr'])): ?>
                                                                    <a href="../../uploads/cr/<?php echo htmlspecialchars($row['cr']); ?>" target="_blank" class=" btn btn-primary"><i class="fa fa-eye"></i>  View Attachment </a>
                                                                 <?php else: ?>
                                                                        <span>Pending for upload</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            
                                                        </tr>

                                                        <tr>
                                                            <td>Sales Invoice / (OR) Official Receipt from LTO</td>
                                                            <td>
                                                                <?php if (!empty($row['or'])): ?>
                                                                    <a href="../../uploads/or/<?php echo htmlspecialchars($row['or']); ?>" target="_blank" class=" btn btn-primary"><i class="fa fa-eye"></i>  View Attachment </a>
                                                                 <?php else: ?>
                                                                        <span>Pending for upload</span>
                                                                <?php endif; ?>
                                                            </td>
                                                          
                                                        </tr>
                                                        <tr>

                                                       <tr>
                                                            <td>Driver #1 Picture</td>
                                                            <td>
                                                                <?php if (!empty($row['driversPic1'])): ?>
                                                                    <a href="../../uploads/driver1/<?php echo htmlspecialchars($row['driversPic1']); ?>" target="_blank" class=" btn btn-primary"><i class="fa fa-eye"></i>  View Attachment </a>
                                                                 <?php else: ?>
                                                                        <span>Pending for upload</span>
                                                                <?php endif; ?>
                                                            </td>
                                                           
                                                        </tr>

                                                        <tr>
                                                            <td>PSA / Voter's ID/Certification</td>
                                                            <td>
                                                                <?php if (!empty($row['valid_id'])): ?>
                                                                    <a href="../../uploads/valid_id/<?php echo htmlspecialchars($row['valid_id']); ?>" target="_blank" class=" btn btn-primary"><i class="fa fa-eye"></i>  View Attachment </a>
                                                                 <?php else: ?>
                                                                        <span>Pending for upload</span>
                                                                <?php endif; ?>
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
                                                                            <a href="../../uploads/tricyclePics/<?php echo htmlspecialchars($pic); ?>" target="_blank" class=" btn btn-primary"><i class="fa fa-eye"></i>  View Attachment </a><br><br>  
                                                                        <?php endforeach; 
                                                                    } else {
                                                                        echo "No tricycle pictures found.";
                                                                    }
                                                                endif; ?>
                                                            </td>
                                                    
                                                        </tr>
                                                        
                                                         <tr>
                                                            <td>TODA Certificate</td>
                                                            <td>
                                                                <?php if (!empty($row['toda_cert'])): ?>
                                                                    <a href="../../uploads/toda_cert/<?php echo htmlspecialchars($row['toda_cert']); ?>" target="_blank" class=" btn btn-primary"><i class="fa fa-eye"></i>  View Attachment </a>
                                                                 <?php else: ?>
                                                                        <span>Pending for upload</span>
                                                                <?php endif; ?>
                                                            </td>
                                                           
                                                        </tr>


                                                        <tr>
                                                            <td>Sedula</td>
                                                            <td>
                                                                <?php if (!empty($row['sedula'])): ?>
                                                                    <a href="../../uploads/sedula/<?php echo htmlspecialchars($row['sedula']); ?>" target="_blank" class=" btn btn-primary"><i class="fa fa-eye"></i>  View Attachment </a>
                                                                 <?php else: ?>
                                                                        <span>Pending for upload</span>
                                                                <?php endif; ?>
                                                            </td>
                                                          
                                                        </tr>

                                                        
                                                        <tr>
                                                            <td>Driver #2 Picture</td>
                                                            <td>
                                                                <?php if (!empty($row['driversPic2'])): ?>
                                                                    <a href="../../uploads/driver2/<?php echo htmlspecialchars($row['driversPic2']); ?>" target="_blank" class=" btn btn-primary"><i class="fa fa-eye"></i>  View Attachment </a>
                                                                 <?php else: ?>
                                                                        <span>Pending for upload</span>
                                                                <?php endif; ?>
                                                            </td>
                                                           
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td>Medical Result</td>
                                                            <td>
                                                                <?php if (!empty($row['med_res'])): ?>
                                                                    <a href="../../uploads/med_res/<?php echo htmlspecialchars($row['med_res']); ?>" target="_blank" class=" btn btn-primary"><i class="fa fa-eye"></i>  View Attachment </a>
                                                                 <?php else: ?>
                                                                        <span>Pending for upload</span>
                                                                <?php endif; ?>
                                                            </td>
                                                          
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td>Deed of Sale</td>
                                                            <td>
                                                                <?php if (!empty($row['deedSale'])): ?>
                                                                    <a href="../../uploads/deedSale/<?php echo htmlspecialchars($row['deedSale']); ?>" target="_blank" class=" btn btn-primary"><i class="fa fa-eye"></i>  View Attachment </a>
                                                                 <?php else: ?>
                                                                        <span>Pending for upload</span>
                                                                <?php endif; ?>
                                                            </td>
                                                        
                                                        </tr>

                                                        <tr>
                                                            <td>Tricycle Inspection</td>
                                                            <td>
                                                                <?php 
                                                                    if (!empty($row['tric_insp'])): ?><?php $filePath = '../../uploads/tric_insp/' . htmlspecialchars($row['tric_insp']);
                                                                ?>
                                                                <a href="<?php echo $filePath; ?>" target="_blank"class=" btn btn-primary"><i class="fa fa-eye"></i>  View Attachment </a>
                                                             <?php else: ?>
                                                                        <span>Pending for upload</span>
                                                                <?php endif; ?>
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
                                                                        <a href="<?php echo $filePath; ?>" target="_blank" class=" btn btn-primary"><i class="fa fa-eye"></i>  View Attachment </a>
                                                                    <?php else: ?>
                                                                        <span>Pending for upload</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                            </td>
                                                           
                                                        </tr>

                                                    </tbody>
                                                </table>
                                                <br>
                                                <!--<input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                                <div  class="text-right">
                                                <button type="submit" class="btn btn-success" name="submit">Update</button>
                                                <a href="franchiseHolders.php" class="btn btn-danger" >Exit</a>
                                                </div>-->
                                            </form> 
                                        </div>
                                    
                                      <div class="tab-pane fade" id="violations" role="tabpanel" aria-labelledby="violations-tab">
                                      <div class="card-header" style="background-color: #FFFFFF; padding: 2px; margin-left:30px; font-size: 14px;">
                                        <h5>Violation History </h5>
                                        </div>
                                        <br>
                                        <div class="" style=" margin-left:30px;">
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
                                       <!-- <div class="text-right">
                                            <a href="franchiseHolders.php" class="btn btn-danger">Exit</a>
                                        </div>-->
                                    </form>
                                    </div>
                                 </div>

                                <div class="tab-pane fade" id="complaint" role="tabpanel" aria-labelledby="complaint-tab">
                                <div class="card-header" style="background-color: #FFFFFF; padding: 2px; margin-left:30px; font-size: 14px;">
                                    <h5 class="mb-0">Complaint History</h5>
                                   
                                </div>
                                    <br>
                                    <div class="" style=" margin-left:30px;">
                                    
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
                                        <br>
                                      
                                    </form>
                                    
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="qr" role="tabpanel" aria-labelledby="qr-tab">
                                <div class="card-header" style="background-color: #FFFFFF; padding: 2px; margin-left:30px; font-size: 14px;">
                                        <h5>QR Code</h5>
                                    </div>
                                    <br>
                                    <form action="#" method="post" enctype="multipart/form-data" style="width: 50vw; min-width: 300px;">
                                        <div class="d-flex justify-content-center">
                                            <img id="qrCodeImage" src="../../qrcodes/<?php echo htmlspecialchars($row['qr_code']); ?>" alt="QR Code" style="height: 170px; width: 160px; object-fit: cover; border: 1px solid #d3d3d3; overflow: hidden;">
                                        </div>
                                        <div class="profile-info mt-3">
                                            <input type="hidden" name="id" id="qrCodeId"  value="<?php echo htmlspecialchars($row['id']) ?>">
                                            <input type="hidden" name="TFno" id="TFno"  value="<?php echo htmlspecialchars($row['TFno']) ?>">
                                            <div class="text-end" style="margin-right:10px">
                                                <button type="button" class="btn btn-primary" onclick="printQRCode()">Print QR Code</button>
                                                <button type="button" class="btn btn-warning" onclick="downloadQRCode()">Download</button>
                                            </div>
                                        </div>
                                    </form>

                                    <script>
                                       function printQRCode() {
                                            // Open a new window
                                            var qrCodeWindow = window.open('', 'Print QR Code', 'height=800,width=800');
                                            
                                            // Add HTML content to the new window
                                            qrCodeWindow.document.write('<html><head><title>Print QR Code</title>');
                                            qrCodeWindow.document.write('<style>body { display: flex; justify-content: left; align-left: left; height: 100%; margin: 0; } img { width: 300px; height: 300px; }</style>'); // Optional styling
                                            qrCodeWindow.document.write('</head><body>');
                                            
                                            // Get the QR code source and embed it in the new window
                                            var qrCodeImageSrc = document.getElementById('qrCodeImage').src;
                                            qrCodeWindow.document.write('<img src="' + qrCodeImageSrc + '" alt="QR Code">');
                                            qrCodeWindow.document.write('</body></html>');
                                            
                                            // Finalize and print
                                            qrCodeWindow.document.close(); // Close the document for writing
                                            qrCodeWindow.focus();          // Focus on the new window
                                            qrCodeWindow.print();          // Trigger the print dialog
                                        }

                                        function downloadQRCode() {
                                            var qrCodeImage = document.getElementById('qrCodeImage');
                                            var TFno = document.getElementById('TFno').value;
                                            var link = document.createElement('a');
                                            link.download = 'qrcode_' + TFno + '.png'; // Filename with ID
                                            link.href = qrCodeImage.src;
                                            document.body.appendChild(link);
                                            link.click();
                                            document.body.removeChild(link);
                                        }
                                    </script>
                                </div>
                                
                                <div class="tab-pane fade" id="renewal" role="tabpanel" aria-labelledby="renewal-tab">
                                  <div class="card-header" style="background-color: #FFFFFF; padding: 2px; margin-left:30px; font-size: 14px;">
                                    <h5 class="mb-0">Franchise Renewal</h5>
                                </div>
                                <br>
                                <div class="card" style=" margin-left:30px;">
                                <form action="update_renewal.php" method="post" enctype="multipart/form-data" style="width:50vw; min-width:300px;">
                                            <div class="editable-fields">
                                                 <div class="form-group row justify-content-center" style="margin-bottom:20px; margin-left:10px;  margin-top:10px;">
                                                     <div class="col-md-6">
                                                        <label class="form-label semi-bold">Franchise Status:</label>
                                                         <input type="text" class="form-control" id="franchise_status" name="status" value="<?php echo htmlspecialchars($row['status']); ?>" readonly> 
                                                    </div>
                                                     <div class="col-md-6">
                                                        <label class="form-label form-label semi-bold">Expiration Date:</label>
                                                        <input type ="text" class="form-control" name="expDate" value="<?php echo htmlspecialchars($row['expDate']); ?>" readonly> 
                                                    </div>

                                                </div>
                                                  <div class="form-group row justify-content-center" style="margin-bottom:20px; margin-left:10px;">
                                                     <div class="col-md-6">
                                                        <label class="form-label semi-bold">Date of Renewal:</label>
                                                        <input type="date" class="form-control" name="dtOfrenewal" value="<?php echo htmlspecialchars($row['dtOfrenewal']) ?>" readonly>
                                                     </div>
                                                     <div class="col-md-6">
                                                        <label class="form-label semi-bold">Amount Paid:</label>
                                                        <input type="number" class="form-control" name="renewal_payment" value="<?php echo htmlspecialchars($row['renewal_payment']) ?>" readonly>
                                                     </div>
                                                </div>
                                                 <?php if ($row['status'] === 'Expired') : ?>
                                                 <div class="form-group row justify-content-center" style="margin-bottom:20px; margin-left:10px;">
                                                    <div class="col-md-6">
                                                        <label class="form-label semi-bold">Penalty:</label>
                                                        <input type="number" class="form-control" name="penalty" value="<?php echo htmlspecialchars($row['penalty']); ?>" readonly>
                                                    </div>
                                                </div>
                                                <?php endif; ?>
                                               
                                            </div>
                                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']) ?>">
                                           
                                              
                                      </form>
                                      </div>
                                      <?php if ($row['status'] === 'Renewed') : ?>
                                        <div class="text-end" style="margin-top: 10px;">
                                            <button id="generateReceipt" class="btn btn-primary">Receipt</button>
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
                                        <h2 style="text-align: center;">OFFICIAL RECEIPT</h2>
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
                                    </div>
                                </div>

                                    <script>
                                       document.getElementById('generateReceipt').addEventListener('click', function () {
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

                                    </script>
                                </div>


                    
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Bootstrap -->


<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<?php 
    include "footerOperator.php";
    include "scripts.php";
?>

<style>
.editable-fields input[readonly],
.editable-fields textarea[readonly] {
    background-color: #e9ecef;
}

</style>
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
    function triggerFileUpload(inputId) {
      document.getElementById(inputId).click();
    }

    function checkFileStatus(statusId, input) {
      var fileStatus = document.getElementById(statusId).value;

      if (fileStatus === 'Invalid' || fileStatus === 'For verification') {
        input.disabled = false;
      } else if (fileStatus === 'Valid') {
        input.disabled = true;
      }
    }
  </script>