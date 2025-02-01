<?php 
    include "headerApplicant.php";
    include "topbarApplicant.php";
?>

<!-- Profile 1 - Bootstrap Brain Component -->
<section class="py-3 py-md-5 py-xl-8" style="margin-top:60px;">

  <div class="container ">
    <h3 style="color: #f5f5f5; margin-left:60px;">TRICYCLE FRANCHISE APPLICANT PROFILE</h3>
    <div class="row gy-4 gy-lg-0 justify-content-center" >
      <div class="col-12 col-lg-5 col-xl-3">
        <div class="row gy-4">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="d-flex flex-column align-items-center text-center">
                <img src="../../uploads/operator/<?php echo htmlspecialchars($row['operatorsPic']); ?>" 
                  alt="Profile Picture" 
                  class="rounded-circle p-1 border-dark" 
                  style="width: 170px; height: 170px; object-fit: cover;" >
                </div>
                <ul class="list-group list-group-flush my-4">
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
                    <span class="text-secondary"><?php echo htmlspecialchars($row['address']); ?></span>
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
                <button class="nav-link active" id="overview-tab" data-bs-toggle="tab"
                  data-bs-target="#driver-tab-pane" type="button" role="tab" aria-controls="driver-tab-pane"
                  aria-selected="true">Applicant Information</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#documents-tab-pane"
                  type="button" role="tab" aria-controls="documents-tab-pane" aria-selected="false">Requirements</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="interview-tab" data-bs-toggle="tab" data-bs-target="#interview-tab-pane"
                  type="button" role="tab" aria-controls="interview-tab-pane" aria-selected="false">Interview Schedule</button>
              </li>
            </ul>

            <div class="tab-content pt-4" id="profileTabContent">
              <div class="tab-pane fade show active" id="driver-tab-pane" role="tabpanel"
                aria-labelledby="overview-tab" tabindex="0">
                <div class="container" style="padding-left: 10px; padding-right: 10px;">
                  <div class="card-header" style="background-color: #FFFFFF; padding: 2px; font-size: 14px;">
                    <h5>Applicant Information <i id="edit-icon" class="fas fa-edit" style="cursor: pointer; color: orange;"></i></h5>
                  </div>
                  <br>
                  <div class="row justify-content-center">
                    <div class="col-md-10">
                      <form action="updateInfo-Applicant.php" method="post" enctype="multipart/form-data">
                        <div class="editable-fields">
                          <div class="form-group row">
                            <div class="col-md-6">
                              <label class="form-label"><h6>Applicant ID</h6></label>
                              <input type="text" class="form-control readonly-field" name="id" value="<?php echo htmlspecialchars($row['id']) ?>" readonly>
                            </div>
                            <div class="col-md-6">
                              <label class="form-label"><h6>Date Filed</h6></label>
                              <input type="text" class="form-control readonly-field" name="applicationDate" value="<?php echo htmlspecialchars($row['applicationDate']) ?>" readonly>
                            </div>
                          </div>
                          <br>
                          <div class="form-group row">
                            <div class="col-md-5">
                              <label class="form-label"><h6>Last Name</h6></label>
                              <input type="text" class="form-control" name="last_name" value="<?php echo htmlspecialchars($row['last_name']) ?>" readonly>
                            </div>
                            <div class="col-md-4">
                              <label class="form-label"><h6>First Name</h6></label>
                              <input type="text" class="form-control" name="first_name" value="<?php echo htmlspecialchars($row['first_name']) ?>" readonly>
                            </div>
                            <div class="col-md-3">
                              <label class="form-label"><h6>Middle Name:</h6></label>
                              <input type="text" class="form-control" name="m_name" value="<?php echo htmlspecialchars($row['m_name']) ?>" readonly>
                            </div>
                          </div>
                          <br>
                          <div class="form-group row">
                            <div class="col-md-6">
                              <label class="form-label"><h6>Sex</h6></label>
                              <input type="text" class="form-control" name="sex" value="<?php echo htmlspecialchars($row['sex']) ?>" readonly>
                            </div>
                            <div class="col-md-6">
                              <label class="form-label"><h6>Birth date</h6></label>
                              <input type="text" class="form-control" name="b_date" value="<?php echo htmlspecialchars($row['b_date']) ?>" readonly>
                            </div>
                          </div>
                          <br>
                          <div class="form-group row">
                            <div class="col-md-6">
                              <label class="form-label"><h6>Contact Number</h6></label>
                              <input type="text" class="form-control" name="contact_num" value="<?php echo htmlspecialchars($row['contact_num']) ?>" readonly>
                            </div>
                            <div class="col-md-6">
                              <label class="form-label"><h6>Email</h6></label>
                              <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($row['email']) ?>" readonly>
                            </div>
                          </div>
                          <br>
                          <div class="form-group row">
                            <div class="col-md-12">
                              <label class="form-label"><h6>Address</h6></label>
                              <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($row['address']) ?>" readonly>
                            </div>
                          </div>
                          <br>
                          <div class="form-group row">
                            <div class="col-md-6">
                              <label class="form-label"><h6>Registered Driver #1</h6></label>
                              <input type="text" class="form-control" name="driver1_name" value="<?php echo htmlspecialchars($row['driver1_name']) ?>" readonly>
                            </div>
                            <div class="col-md-6">
                              <label class="form-label"><h6>Registered Driver #2</h6></label>
                              <input type="text" class="form-control" name="driver2_name" value="<?php echo htmlspecialchars($row['driver2_name']) ?>" readonly>
                            </div>
                          </div>
                          <br>
                          <div class="form-group row">
                            <div class="col-md-4">
                              <label class="form-label"><h6>Tricycle Color</h6></label>
                              <input type="text" class="form-control" name="tricColor" value="<?php echo htmlspecialchars($row['tricColor']) ?>" readonly>
                            </div>
                            <div class="col-md-4">
                              <label class="form-label"><h6>Vehicle Type</h6></label>
                              <input type="text" class="form-control" name="tricType" value="<?php echo htmlspecialchars($row['tricType']) ?>" readonly>
                            </div>
                            <div class="col-md-4">
                              <label class="form-label"><h6>TODA</h6></label>
                              <input type="text" class="form-control" name="toda" value="<?php echo htmlspecialchars($row['toda']) ?>" readonly>
                            </div>
                          </div>
                        </div>
                        <br>
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']) ?>">
                        <div class="text-end">
                          <!--<button type="submit" class="btn btn-success" name="#">Update</button>-->
                          <!--<a href="listApplicants.php" class="btn btn-danger" style="margin-left: 3px;">Exit</a>-->
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <div class="tab-pane fade" id="documents-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
              <div class="container-fluid">
                    <div class="card-header" style="background-color: #FFFFFF; padding: 2px; font-size: 14px;">
                                            <h5>Requirements Submitted <i id="edit-icon" class="fas fa-edit" style="cursor: pointer; color: orange;"></i></h5>
                                        </div>
                                      <div class="justify-content-center d-flex justify-content-center align-items-center">
                                      <div class="col-md-10">
                                        <form action="update_requirements.php" method="post" enctype="multipart/form-data" style="width:40vw; min-width:300px;">
                                        
                                            <div class="table-responsive">
                                              <table class="table mx-auto table-bordered">
                                                <br>
                                                      <thead>
                                                          <tr>
                                                              <th>File Name</th>
                                                              <th>View Attachment</th>
                                                              <th>Action</th>
                                                          </tr>
                                                      </thead>
                                                      <tbody>
                                                        <tr>
                                                            <td>Operators Picture
                                                            <br>
                                                            <span id="operatorsPicStatus" class="badge 
                                                                <?php 
                                                                  if ($row['operatorsPicStatus'] == 'Invalid') {
                                                                    echo 'bg-danger';
                                                                    $icon = '<i class="fas fa-times-circle"></i>'; // Red "x" icon for Invalid
                                                                  } elseif ($row['operatorsPicStatus'] == 'For verification') {
                                                                    echo 'bg-warning';
                                                                    $icon = '<i class="fas fa-exclamation-circle"></i>'; // Yellow "!" icon for For verification
                                                                  } else {
                                                                    echo 'bg-success';
                                                                    $icon = '<i class="fas fa-check-circle"></i>'; // Green check icon for Valid
                                                                  }
                                                                ?>">
                                                                <?php echo $icon . ' ' . htmlspecialchars($row['operatorsPicStatus']); ?>
                                                              </span>
                                                                <br>
                                                                <?php if ($row['operatorsPicStatus'] == 'Invalid'): ?>
                                                                  <i><small>Remarks:</small></i> 
                                                                  <i><small id="operatorsPicRemarks"><?php echo htmlspecialchars($row['operatorsPicRemarks']); ?></small></i>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <?php if (!empty($row['operatorsPic'])): ?>
                                                                    <a href="../../uploads/operator/<?php echo htmlspecialchars($row['operatorsPic']); ?>" target="_blank" class="btn btn-primary">View Attachment</a>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                            <input type="file" id="operatorsPic" class="form-control" name="operatorsPic" style="display:none;" 
                                                              onchange="checkFileStatus('operatorsPicStatus', this)" 
                                                              <?php if ($row['operatorsPicStatus'] == 'Valid') echo 'disabled'; ?>>
                                                            <button type="button" class="btn btn-primary" onclick="triggerFileUpload('operatorsPic')" 
                                                              <?php if ($row['operatorsPicStatus'] == 'Valid') echo 'disabled'; ?>><i class="fas fa-upload"> </i> Upload</button>
                                                            </td>
                                                        </tr>
                                                        <tr>

                                                        <tr>
                                                            <td>TODA Certificate
                                                            <br>
                                                            <span id="toda_certStatus" class="badge 
                                                                <?php 
                                                                  if ($row['toda_certStatus'] == 'Invalid') {
                                                                    echo 'bg-danger';
                                                                    $icon = '<i class="fas fa-times-circle"></i>'; // Red "x" icon for Invalid
                                                                  } elseif ($row['toda_certStatus'] == 'For verification') {
                                                                    echo 'bg-warning';
                                                                    $icon = '<i class="fas fa-exclamation-circle"></i>'; // Yellow "!" icon for For verification
                                                                  } else {
                                                                    echo 'bg-success';
                                                                    $icon = '<i class="fas fa-check-circle"></i>'; // Green check icon for Valid
                                                                  }
                                                                ?>">
                                                                <?php echo $icon . ' ' . htmlspecialchars($row['toda_certStatus']); ?>
                                                              </span>
                                                                <br>
                                                                <?php if ($row['toda_certStatus'] == 'Invalid'): ?>
                                                                  <i><small>Remarks:</small></i> 
                                                                  <i><small id="toda_certRemarks"><?php echo htmlspecialchars($row['toda_certRemarks']); ?></small></i>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <?php if (!empty($row['toda_cert'])): ?>
                                                                    <a href="../../uploads/toda_cert/<?php echo htmlspecialchars($row['toda_cert']); ?>" target="_blank" class="btn btn-primary">View Attachment</a>
                                                                <?php endif; ?>
                                                            </td>
                                                            
                                                            <td>
                                                           
                                                            <input type="file" id="toda_cert" class="form-control" name="toda_cert" style="display:none;" 
                                                              onchange="checkFileStatus('toda_certStatus', this)" 
                                                              <?php if ($row['toda_certStatus'] == 'Valid') echo 'disabled'; ?>>
                                                            <button type="button" class="btn btn-primary" onclick="triggerFileUpload('toda_cert')" 
                                                              <?php if ($row['toda_certStatus'] == 'Valid') echo 'disabled'; ?>><i class="fas fa-upload"> </i> Upload</button>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>PSA / Voter's ID
                                                            <br>
                                                            <span id="valid_idStatus" class="badge 
                                                                <?php 
                                                                  if ($row['valid_idStatus'] == 'Invalid') {
                                                                    echo 'bg-danger';
                                                                    $icon = '<i class="fas fa-times-circle"></i>'; // Red "x" icon for Invalid
                                                                  } elseif ($row['valid_idStatus'] == 'For verification') {
                                                                    echo 'bg-warning';
                                                                    $icon = '<i class="fas fa-exclamation-circle"></i>'; // Yellow "!" icon for For verification
                                                                  } else {
                                                                    echo 'bg-success';
                                                                    $icon = '<i class="fas fa-check-circle"></i>'; // Green check icon for Valid
                                                                  }
                                                                ?>">
                                                                <?php echo $icon . ' ' . htmlspecialchars($row['valid_idStatus']); ?>
                                                              </span>
                                                                <br>
                                                                <?php if ($row['valid_idStatus'] == 'Invalid'): ?>
                                                                  <i><small>Remarks:</small></i> 
                                                                  <i><small id="valid_idRemarks"><?php echo htmlspecialchars($row['valid_idRemarks']); ?></small></i>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <?php if (!empty($row['valid_id'])): ?>
                                                                    <a href="../../uploads/valid_id/<?php echo htmlspecialchars($row['valid_id']); ?>" target="_blank" class="btn btn-primary">View Attachment</a>
                                                                <?php endif; ?>
                                                            </td>
                                                           
                                                            <td>
                                                           
                                                            <input type="file" id="valid_id" class="form-control" name="valid_id" style="display:none;" 
                                                              onchange="checkFileStatus('valid_idStatus', this)" 
                                                              <?php if ($row['valid_idStatus'] == 'Valid') echo 'disabled'; ?>>
                                                            <button type="button" class="btn btn-primary" onclick="triggerFileUpload('valid_id')" 
                                                              <?php if ($row['valid_idStatus'] == 'Valid') echo 'disabled'; ?>><i class="fas fa-upload"> </i> Upload</button>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>Sedula
                                                            <br>
                                                            <span id="sedulaStatus" class="badge 
                                                                <?php 
                                                                  if ($row['sedulaStatus'] == 'Invalid') {
                                                                    echo 'bg-danger';
                                                                    $icon = '<i class="fas fa-times-circle"></i>'; // Red "x" icon for Invalid
                                                                  } elseif ($row['sedulaStatus'] == 'For verification') {
                                                                    echo 'bg-warning';
                                                                    $icon = '<i class="fas fa-exclamation-circle"></i>'; // Yellow "!" icon for For verification
                                                                  } else {
                                                                    echo 'bg-success';
                                                                    $icon = '<i class="fas fa-check-circle"></i>'; // Green check icon for Valid
                                                                  }
                                                                ?>">
                                                                <?php echo $icon . ' ' . htmlspecialchars($row['sedulaStatus']); ?>
                                                              </span>
                                                                <br>
                                                                <?php if ($row['sedulaStatus'] == 'Invalid'): ?>
                                                                  <i><small>Remarks:</small></i> 
                                                                  <i><small id="sedulaRemarks"><?php echo htmlspecialchars($row['sedulaRemarks']); ?></small></i>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <?php if (!empty($row['sedula'])): ?>
                                                                    <a href="../../uploads/sedula/<?php echo htmlspecialchars($row['sedula']); ?>" target="_blank" class="btn btn-primary">View Attachment</a>
                                                                <?php endif; ?>
                                                            </td>
                                                            
                                                            <td>
                                                           
                                                            <input type="file" id="sedula" class="form-control" name="sedula" style="display:none;" 
                                                              onchange="checkFileStatus('sedulaStatus', this)" 
                                                              <?php if ($row['sedulaStatus'] == 'Valid') echo 'disabled'; ?>>
                                                            <button type="button" class="btn btn-primary" onclick="triggerFileUpload('sedula')" 
                                                              <?php if ($row['sedulaStatus'] == 'Valid') echo 'disabled'; ?>><i class="fas fa-upload"> </i> Upload</button>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>Driver #1
                                                            <br>
                                                            <span id="driversPic1Status" class="badge 
                                                                <?php 
                                                                  if ($row['driversPic1Status'] == 'Invalid') {
                                                                    echo 'bg-danger';
                                                                    $icon = '<i class="fas fa-times-circle"></i>'; // Red "x" icon for Invalid
                                                                  } elseif ($row['driversPic1Status'] == 'For verification') {
                                                                    echo 'bg-warning';
                                                                    $icon = '<i class="fas fa-exclamation-circle"></i>'; // Yellow "!" icon for For verification
                                                                  } else {
                                                                    echo 'bg-success';
                                                                    $icon = '<i class="fas fa-check-circle"></i>'; // Green check icon for Valid
                                                                  }
                                                                ?>">
                                                                <?php echo $icon . ' ' . htmlspecialchars($row['driversPic1Status']); ?>
                                                              </span>
                                                                <br>
                                                                <?php if ($row['driversPic1Status'] == 'Invalid'): ?>
                                                                  <i><small>Remarks:</small></i> 
                                                                  <i><small id="driversPic1Remarks"><?php echo htmlspecialchars($row['driversPic1Remarks']); ?></small></i>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <?php if (!empty($row['driversPic1'])): ?>
                                                                    <a href="../../uploads/driver1/<?php echo htmlspecialchars($row['driversPic1']); ?>" target="_blank" class="btn btn-primary">View Attachment</a>
                                                                <?php endif; ?>
                                                              </td>
                                                            
                                                            <td>
                                                            <input type="file" id="driversPic1" class="form-control" name="driversPic1" style="display:none;" 
                                                              onchange="checkFileStatus('driversPic1Status', this)" 
                                                              <?php if ($row['driversPic1Status'] == 'Valid') echo 'disabled'; ?>>
                                                            <button type="button" class="btn btn-primary" onclick="triggerFileUpload('driversPic1')" 
                                                              <?php if ($row['driversPic1Status'] == 'Valid') echo 'disabled'; ?>><i class="fas fa-upload"> </i> Upload</button>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>Driver #2
                                                            <br>
                                                            <span id="driversPic2Status" class="badge 
                                                                <?php 
                                                                  if ($row['driversPic2Status'] == 'Invalid') {
                                                                    echo 'bg-danger';
                                                                    $icon = '<i class="fas fa-times-circle"></i>'; // Red "x" icon for Invalid
                                                                  } elseif ($row['driversPic2Status'] == 'For verification') {
                                                                    echo 'bg-warning';
                                                                    $icon = '<i class="fas fa-exclamation-circle"></i>'; // Yellow "!" icon for For verification
                                                                  } else {
                                                                    echo 'bg-success';
                                                                    $icon = '<i class="fas fa-check-circle"></i>'; // Green check icon for Valid
                                                                  }
                                                                ?>">
                                                                <?php echo $icon . ' ' . htmlspecialchars($row['driversPic2Status']); ?>
                                                              </span>
                                                                <br>
                                                                <?php if ($row['driversPic2Status'] == 'Invalid'): ?>
                                                                  <i><small>Remarks:</small></i> 
                                                                  <i><small id="driversPic2Remarks"><?php echo htmlspecialchars($row['driversPic2Remarks']); ?></small></i>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <?php if (!empty($row['driversPic2'])): ?>
                                                                    <a href="../../uploads/driver2/<?php echo htmlspecialchars($row['driversPic2']); ?>" target="_blank" class="btn btn-primary">View Attachment</a>
                                                                <?php endif; ?>
                                                            </td>
                                                            
                                                            <td>
                                                           
                                                            <input type="file" id="driversPic2" class="form-control" name="driversPic2" style="display:none;" 
                                                              onchange="checkFileStatus('driversPic2Status', this)" 
                                                              <?php if ($row['driversPic2Status'] == 'Valid') echo 'disabled'; ?>>
                                                            <button type="button" class="btn btn-primary" onclick="triggerFileUpload('driversPic2')" 
                                                              <?php if ($row['driversPic2Status'] == 'Valid') echo 'disabled'; ?>><i class="fas fa-upload"> </i> Upload</button>
                                                            </td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td>License
                                                                
                                                            <br>
                                                            <span id="licenseStatus" class="badge 
                                                                <?php 
                                                                  if ($row['licenseStatus'] == 'Invalid') {
                                                                    echo 'bg-danger';
                                                                    $icon = '<i class="fas fa-times-circle"></i>'; // Red "x" icon for Invalid
                                                                  } elseif ($row['licenseStatus'] == 'For verification') {
                                                                    echo 'bg-warning';
                                                                    $icon = '<i class="fas fa-exclamation-circle"></i>'; // Yellow "!" icon for For verification
                                                                  } else {
                                                                    echo 'bg-success';
                                                                    $icon = '<i class="fas fa-check-circle"></i>'; // Green check icon for Valid
                                                                  }
                                                                ?>">
                                                                <?php echo $icon . ' ' . htmlspecialchars($row['licenseStatus']); ?>
                                                              </span>
                                                                <br>
                                                                <?php if ($row['licenseStatus'] == 'Invalid'): ?>
                                                                  <i><small>Remarks:</small></i> 
                                                                  <i><small id="licenseRemarks"><?php echo htmlspecialchars($row['licenseRemarks']); ?></small></i>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <?php if (!empty($row['license'])): ?>
                                                                    <a href="../../uploads/license/<?php echo htmlspecialchars($row['license']); ?>" target="_blank" class="btn btn-primary">View Attachment</a>
                                                                <?php endif; ?>
                                                            </td>
                                                        
                                                            <td>
                                                           
                                                            <input type="file" id="license" class="form-control" name="license" style="display:none;" 
                                                              onchange="checkFileStatus('licenseStatus', this)" 
                                                              <?php if ($row['licenseStatus'] == 'Valid') echo 'disabled'; ?>>
                                                            <button type="button" class="btn btn-primary" onclick="triggerFileUpload('license')" 
                                                              <?php if ($row['licenseStatus'] == 'Valid') echo 'disabled'; ?>><i class="fas fa-upload"> </i> Upload</button>
                                                            </td>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>Medical Result
                                                                
                                                            <br>
                                                            <span id="med_resStatus" class="badge 
                                                                <?php 
                                                                  if ($row['med_resStatus'] == 'Invalid') {
                                                                    echo 'bg-danger';
                                                                    $icon = '<i class="fas fa-times-circle"></i>'; // Red "x" icon for Invalid
                                                                  } elseif ($row['med_resStatus'] == 'For verification') {
                                                                    echo 'bg-warning';
                                                                    $icon = '<i class="fas fa-exclamation-circle"></i>'; // Yellow "!" icon for For verification
                                                                  } else {
                                                                    echo 'bg-success';
                                                                    $icon = '<i class="fas fa-check-circle"></i>'; // Green check icon for Valid
                                                                  }
                                                                ?>">
                                                                <?php echo $icon . ' ' . htmlspecialchars($row['med_resStatus']); ?>
                                                              </span>
                                                                <br>
                                                                <?php if ($row['med_resStatus'] == 'Invalid'): ?>
                                                                  <i><small>Remarks:</small></i> 
                                                                  <i><small id="orRemarks"><?php echo htmlspecialchars($row['orRemarks']); ?></small></i>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <?php if (!empty($row['med_res'])): ?>
                                                                    <a href="../../uploads/med_res/<?php echo htmlspecialchars($row['med_res']); ?>" target="_blank" class="btn btn-primary">View Attachment</a>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                            <input type="file" id="med_res" class="form-control" name="med_res" style="display:none;" 
                                                              onchange="checkFileStatus('med_resStatus', this)" 
                                                              <?php if ($row['med_resStatus'] == 'Valid') echo 'disabled'; ?>>
                                                            <button type="button" class="btn btn-primary" onclick="triggerFileUpload('med_res')" 
                                                              <?php if ($row['med_resStatus'] == 'Valid') echo 'disabled'; ?>><i class="fas fa-upload"> </i> Upload  </button>
                                                            </td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td>(CR) from LTO
                                                              
                                                            <br>
                                                            <span id="crStatus" class="badge 
                                                                <?php 
                                                                  if ($row['crStatus'] == 'Invalid') {
                                                                    echo 'bg-danger';
                                                                    $icon = '<i class="fas fa-times-circle"></i>'; // Red "x" icon for Invalid
                                                                  } elseif ($row['crStatus'] == 'For verification') {
                                                                    echo 'bg-warning';
                                                                    $icon = '<i class="fas fa-exclamation-circle"></i>'; // Yellow "!" icon for For verification
                                                                  } else {
                                                                    echo 'bg-success';
                                                                    $icon = '<i class="fas fa-check-circle"></i>'; // Green check icon for Valid
                                                                  }
                                                                ?>">
                                                                <?php echo $icon . ' ' . htmlspecialchars($row['crStatus']); ?>
                                                              </span>
                                                                <br>
                                                                <?php if ($row['crStatus'] == 'Invalid'): ?>
                                                                  <i><small>Remarks:</small></i> 
                                                                  <i><small id="crRemarks"><?php echo htmlspecialchars($row['crRemarks']); ?></small></i>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <?php if (!empty($row['cr'])): ?>
                                                                    <a href="../../uploads/cr/<?php echo htmlspecialchars($row['cr']); ?>" target="_blank" class="btn btn-primary">View Attachment</a>
                                                                <?php endif; ?>
                                                            </td>
                                                            
                                                            <td>
                                                            <input type="file" id="cr" class="form-control" name="cr" style="display:none;" 
                                                              onchange="checkFileStatus('crStatus', this)" 
                                                              <?php if ($row['crStatus'] == 'Valid') echo 'disabled'; ?>>
                                                            <button type="button" class="btn btn-primary" onclick="triggerFileUpload('cr')" 
                                                              <?php if ($row['crStatus'] == 'Valid') echo 'disabled'; ?>><i class="fas fa-upload"> </i> Upload </button>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>(OR) from LTO
                                                            <br>
                                                            <span id="orStatus" class="badge 
                                                                <?php 
                                                                  if ($row['orStatus'] == 'Invalid') {
                                                                    echo 'bg-danger';
                                                                    $icon = '<i class="fas fa-times-circle"></i>'; // Red "x" icon for Invalid
                                                                  } elseif ($row['orStatus'] == 'For verification') {
                                                                    echo 'bg-warning';
                                                                    $icon = '<i class="fas fa-exclamation-circle"></i>'; // Yellow "!" icon for For verification
                                                                  } else {
                                                                    echo 'bg-success';
                                                                    $icon = '<i class="fas fa-check-circle"></i>'; // Green check icon for Valid
                                                                  }
                                                                ?>">
                                                                <?php echo $icon . ' ' . htmlspecialchars($row['orStatus']); ?>
                                                              </span>
                                                                <br>
                                                                <?php if ($row['orStatus'] == 'Invalid'): ?>
                                                                  <i><small>Remarks:</small></i> 
                                                                  <i><small id="orRemarks"><?php echo htmlspecialchars($row['orRemarks']); ?></small></i>
                                                                <?php endif; ?>
                                                            </td>
                                                            
                                                            
                                                            <td>
                                                                <?php if (!empty($row['or'])): ?>
                                                                    <a href="../../uploads/or/<?php echo htmlspecialchars($row['or']); ?>" target="_blank" class="btn btn-primary">View Attachment</a>
                                                                <?php endif; ?>
                                                            </td>
                                                            
                                                            
                                                            <td>
                                                           
                                                            <input type="file" id="or" class="form-control" name="or" style="display:none;" 
                                                              onchange="checkFileStatus('orStatus', this)" 
                                                              <?php if ($row['orStatus'] == 'Valid') echo 'disabled'; ?>>
                                                            <button type="button" class="btn btn-primary" onclick="triggerFileUpload('or')" 
                                                              <?php if ($row['orStatus'] == 'Valid') echo 'disabled'; ?>><i class="fas fa-upload"> </i> Upload</button>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>Deed of Sale

                                                            <br>
                                                            <span id="deedSaleStatus" class="badge 
                                                                <?php 
                                                                  if ($row['deedSaleStatus'] == 'Invalid') {
                                                                    echo 'bg-danger';
                                                                    $icon = '<i class="fas fa-times-circle"></i>'; // Red "x" icon for Invalid
                                                                  } elseif ($row['deedSaleStatus'] == 'For verification') {
                                                                    echo 'bg-warning';
                                                                    $icon = '<i class="fas fa-exclamation-circle"></i>'; // Yellow "!" icon for For verification
                                                                  } else {
                                                                    echo 'bg-success';
                                                                    $icon = '<i class="fas fa-check-circle"></i>'; // Green check icon for Valid
                                                                  }
                                                                ?>">
                                                                <?php echo $icon . ' ' . htmlspecialchars($row['deedSaleStatus']); ?>
                                                              </span>
                                                                <br>
                                                                <?php if ($row['deedSaleStatus'] == 'Invalid'): ?>
                                                                  <i><small>Remarks:</small></i> 
                                                                  <i><small id="deedSaleRemarks"><?php echo htmlspecialchars($row['deedSaleRemarks']); ?></small></i>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <?php if (!empty($row['deedSale'])): ?>
                                                                    <a href="../../uploads/deedSale/<?php echo htmlspecialchars($row['deedSale']); ?>" target="_blank" class="btn btn-primary">View Attachment</a>
                                                                <?php endif; ?>
                                                            </td>
                                                            
                                                            <td>
                                                            <input type="file" id="deedSale" class="form-control" name="deedSale" style="display:none;" 
                                                              onchange="checkFileStatus('deedSaleStatus', this)" 
                                                              <?php if ($row['deedSaleStatus'] == 'Valid') echo 'disabled'; ?>>
                                                            <button type="button" class="btn btn-primary" onclick="triggerFileUpload('deedSale')" 
                                                              <?php if ($row['deedSaleStatus'] == 'Valid') echo 'disabled'; ?>><i class="fas fa-upload"> </i> Upload</button>
                                                          </td>
                                                        </tr>


                                                        <tr>
                                                            <td>Tricycle Pictures
                                                            <br>
                                                            <span id="tricyclePicsStatus" class="badge 
                                                                <?php 
                                                                  if ($row['tricyclePicsStatus'] == 'Invalid') {
                                                                    echo 'bg-danger';
                                                                    $icon = '<i class="fas fa-times-circle"></i>'; // Red "x" icon for Invalid
                                                                  } elseif ($row['tricyclePicsStatus'] == 'For verification') {
                                                                    echo 'bg-warning';
                                                                    $icon = '<i class="fas fa-exclamation-circle"></i>'; // Yellow "!" icon for For verification
                                                                  } else {
                                                                    echo 'bg-success';
                                                                    $icon = '<i class="fas fa-check-circle"></i>'; // Green check icon for Valid
                                                                  }
                                                                ?>">
                                                                <?php echo $icon . ' ' . htmlspecialchars($row['tricyclePicsStatus']); ?>
                                                              </span>
                                                                <br>
                                                                <?php if ($row['tricyclePicsStatus'] == 'Invalid'): ?>
                                                                  <i><small>Remarks:</small></i> 
                                                                  <i><small id="tricyclePicsRemarks"><?php echo htmlspecialchars($row['tricyclePicsRemarks']); ?></small></i>
                                                                <?php endif; ?>
                                                               </td>
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
                                                                        echo "No tricycle pictures found.";
                                                                    }
                                                                endif; ?>
                                                            </td>
                                                            <td>
                                                            <input type="file" id="tricyclePics" class="form-control" name="tricyclePics[]" multiple style="display:none;" accept="image/*,application/pdf"
                                                                onchange="checkFileStatus('tricyclePicsStatus', this)" 
                                                                <?php if ($row['tricyclePicsStatus'] == 'Valid') echo 'disabled'; ?>>
                                                            <button type="button" class="btn btn-primary" onclick="triggerFileUpload('tricyclePics')" 
                                                              <?php if ($row['tricyclePicsStatus'] == 'Valid') echo 'disabled'; ?>><i class="fas fa-upload"> </i> Upload</button>
                                                          </td>
                                                        </tr>
                                                        
                                                        
                                                        <tr>
                                                          <td>Tricycle Inspection
                                                              <br>
                                                              <span id="tric_inspStatus"class="badge 
                                                                  <?php 
                                                                      if ($row['tric_inspStatus'] == 'Invalid') {
                                                                          echo'bg-danger';
                                                                          $icon = '<i class="fas fa-times-circle"></i>'; // Red "x" icon for Invalid
                                                                      } elseif ($row['tric_inspStatus'] == 'For verification') {
                                                                          echo'bg-warning';
                                                                          $icon = '<i class="fas fa-exclamation-circle"></i>'; // Yellow "!" icon for For verification
                                                                      } else {
                                                                          echo'bg-success';
                                                                          $icon = '<i class="fas fa-check-circle"></i>'; // Green check icon for Valid
                                                                      }
                                                                  ?>">
                                                                  <?php echo $icon . ' ' . htmlspecialchars($row['tric_inspStatus']); ?>
                                                              </span>
                                                              <br>
                                                              <?php if ($row['tric_inspStatus'] == 'Invalid'): ?>
                                                                  <i><small>Remarks:</small></i> 
                                                                  <i><small id="tric_inspRemarks"><?php echo htmlspecialchars($row['tric_inspRemarks']); ?></small></i>
                                                              <?php endif; ?>
                                                          </td>
                                                          <td>
                                                          <?php if (!empty($row['tric_insp'])): ?>
                                                                  <a href="<?php echo htmlspecialchars('../../uploads/tric_insp/' . $row['tric_insp']); ?>" target="_blank"class="btn btn-primary">View Attachment</a>
                                                              <?php else: ?>
                                                                  <span class="text-muted">Pending for Upload</span>
                                                              <?php endif; ?>
                                                          </td>
                                                          <td>
                                                              <input type="file" id="tric_insp" class="form-control" name="tric_insp" style="display:none;" 
                                                                  onchange="checkFileStatus('tric_inspStatus', this)" 
                                                                  <?php if ($row['tric_inspStatus'] == 'Valid') echo 'disabled'; ?>>
                                                              <button type="button" class="btn btn-primary" onclick="triggerFileUpload('tric_insp')" 
                                                                  <?php if ($row['tric_inspStatus'] == 'Valid') echo 'disabled'; ?>>
                                                                  <i class="fas fa-upload"></i> Upload
                                                              </button>
                                                          </td>
                                                      </tr>

                                                    </tbody>
                                                </table>
                                                <div class ="footer">
                                                  <i>Note: If the file is marked as Invalid read the remarks and upload a new file</i><br><br>
                                                </div>
                                              
                                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                                <input type="hidden" id="operatorsPicStatus" value="<?php echo $row['operatorsPicStatus']; ?>">
                                                <input type="hidden" id="toda_certStatus" value="<?php echo $row['toda_certStatus']; ?>">
                                                <input type="hidden" id="valid_idStatus" value="<?php echo $row['valid_idStatus']; ?>">
                                                <input type="hidden" id="sedulaStatus" value="<?php echo $row['sedulaStatus']; ?>">
                                                <input type="hidden" id="driversPic1Status" value="<?php echo $row['driversPic1Status']; ?>">
                                                <input type="hidden" id="driversPic2Status" value="<?php echo $row['driversPic2Status']; ?>">
                                                <input type="hidden" id="licenseStatus" value="<?php echo $row['licenseStatus']; ?>">
                                                <input type="hidden" id="med_resStatus" value="<?php echo $row['med_resStatus']; ?>">
                                                <input type="hidden" id="crStatus" value="<?php echo $row['crStatus']; ?>">
                                                <input type="hidden" id="orStatus" value="<?php echo $row['orStatus']; ?>">
                                                <input type="hidden" id="deedSaleStatus" value="<?php echo $row['deedSaleStatus']; ?>">
                                                <input type="hidden" id="tricyclePicsStatus" value="<?php echo $row['tricyclePicsStatus']; ?>">
                                                 <input type="hidden" id="tric_inspStatus" value="<?php echo $row['tric_inspStatus']; ?>">
                                                <input type="hidden" name="first_name" value="<?php echo htmlspecialchars($row['first_name']); ?>">
                                                <input type="hidden" name="last_name" value="<?php echo htmlspecialchars($row['last_name']); ?>">
                                                <div  class="text-end">
                                                <button type="submit" class="btn btn-success" name="submit">Update</button>
                                                 </div>
                                                </div>
                                            </form> 
                                        </div>
                                   </div>
                            </div>
                         </div>
                         <div class="tab-pane fade" id="interview-tab-pane" role="tabpanel" aria-labelledby="interview-tab" tabindex="0">
                        <div class="container-fluid">
                          <div class="card-header" style="background-color: #FFFFFF; padding: 2px; font-size: 14px;">
                            <h5>Interview Schedule</h5>
                          </div>
                        </div>
                        <div class="container">
                          <br>
                          <?php
                            if (!empty($row['interview_sched'])) {
                              // If there is an interview schedule
                              echo '<label>The interview schedule will be on ' . htmlspecialchars($row['interview_sched']) . 
                                  ' at the Lucban MTFRB Office, located on the 3rd floor of Lucban Municipal Hall.</label>';
                            } else {
                              // If there is no interview schedule
                              echo '<label>Interview schedule is pending.</label>';
                            }
                          ?>
                        </div>
</div>
                         
                                                                  
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
    include "footerApplicant.php";
    include "scripts.php";
?>

<style>
  .editable-fields input[readonly],
    .editable-fields textarea[readonly] {
        background-color: #e9ecef;
    }

   

/* Responsive Font and Padding */
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

    .btn-block {
        max-width: 100px; /* Smaller buttons on very small screens */
    }

  }
.btn-block {
    width: 100%;
    max-width: 150px; /* Ensure a consistent button size */
    white-space: nowrap;
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
  
  <script src="../assets/js/translate.js"> </script>
    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>