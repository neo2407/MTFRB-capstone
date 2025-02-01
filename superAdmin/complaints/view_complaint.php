<?php

include "../include/headerAdmin.php";
include "../include/navbarAdmin.php";

$id = $_GET['id'];
$sql = "SELECT * FROM complaints WHERE id = $id LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>

<style>
    
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
<div id="content-wrapper" class="d-flex flex-column ">   
    <?php include "../include/topbarAdmin.php";?>
    <div class="container mt-3 d-flex justify-content-center" style="width:70vw; min-width:100px;">
        <div class="card">
            <div class="card-header">
                <div class="text-left mb-1">
                    <h5>Complaint Information <i id="edit-icon" class="fas fa-edit" style="cursor: pointer; color: orange; margin-bottom:10px;"></i></h5>
                </div>
            </div>

            <div class="container d-flex justify-content-center">
                <div class="row justify-content-center align-items-center" style="min-height: 60vh;">
                    <div class="col-md-10">
                <form action="update_ComplaintsInfo.php" method="post" style="width:100%; min-width:100px;">
                    <div class="editable-fields">
                        <!-- Complainant Details -->
                        <div class="form-group row border p-3 border-gray rounded">
                            <p>Complainant Details</p>
                            <div class="col-md-4">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control readonly-field" name="last_name" value="<?php echo htmlspecialchars($row['last_name']); ?>" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="middle_name">First Name</label>
                                <input type="text" class="form-control readonly-field" name="first_name" value="<?php echo htmlspecialchars($row['first_name']); ?>" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="middle_name">Middle Name</label>
                                <input type="text" class="form-control readonly-field" name="m_name" value="<?php echo htmlspecialchars($row['m_name']); ?>" readonly>
                            </div>
                            <div class="col-md-6" style="margin-top:10px;">
                                <label for="contactNum">Contact No</label>
                                <input type="number" class="form-control readonly-field" name="contactNum" value="<?php echo htmlspecialchars($row['contactNum']); ?>" readonly>
                            </div>
                            <div class="col-md-6" style="margin-top:10px;">
                                <label for="email">Email</label>
                                <input type="email" class="form-control readonly-field" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" readonly>
                            </div>
                        </div>
                
                        <!-- Complaint Details -->
                        <div class="form-group row border p-3 border-gray rounded">
                            <p>Complaint Details</p>
                            <div class="col-md-6">
                                <label for="dateOfincident">Date and Time of Complaint</label>
                                <input type="text" class="form-control readonly-field" name="dateOfincident" value="<?php echo htmlspecialchars($row['dateOfincident']); ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="descOfincident">Description of Complaint</label>
                                <input type="text" class="form-control readonly-field" name="descOfincident" value="<?php echo htmlspecialchars($row['descOfincident']); ?>" readonly>
                            </div>
                        </div>
                
                        <!-- Tricycle Information -->
                        <div class="form-group row border p-3 border-gray rounded">
                            <p>Tricycle Information</p>
                            <div class="col-md-4">
                                <label for="TFno">Tricycle Franchise No.</label>
                                <input type="number" class="form-control readonly-field" name="TFno" value="<?php echo htmlspecialchars($row['TFno']); ?>" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="colorOftric">Tricycle Color</label>
                                <input type="text" class="form-control readonly-field" name="colorOftric" value="<?php echo htmlspecialchars($row['colorOftric']); ?>" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="madeOf">Body Built</label>
                                <input type="text" class="form-control readonly-field" name="madeOf" value="<?php echo htmlspecialchars($row['madeOf']); ?>" readonly>
                            </div>
                            <div class="col-md-12" style="margin-top:10px;">
                                <label for="descOfdriver">Driver Description</label>
                                <textarea class="form-control readonly-field" name="descOfdriver" rows="3" readonly><?php echo htmlspecialchars(stripslashes($row['descOfdriver'])); ?></textarea>
                            </div>
                        </div>
                
                        <!-- Supporting Evidence and Preferred Contact -->
                        <div class="form-group row border p-3 border-gray rounded">
                            <div class="col-md-6">
                                <label for="evidence">Supporting Evidence</label>
                                <a href="../../uploads/complaints/<?php echo htmlspecialchars($row['evidence']); ?>" target="_blank">View Attachment</a>
                            </div>
                            <div class="col-md-6">
                                <label for="dtOfcontact">Preferred Date and Time for Contact</label>
                                <input type="text" class="form-control readonly-field" name="dtOfcontact" value="<?php echo htmlspecialchars($row['dtOfcontact']); ?>" readonly>
                            </div>
                        </div>
                
                        <!-- Interview Schedule -->
                        <div class="form-group row border p-3 border-gray rounded">
                            <p>Interview Schedule</p>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="interview_sched_display" id="interview_sched_display" value="<?php echo htmlspecialchars($row['interview_dt']); ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <input type="datetime-local" class="form-control" id="interview_dt" name="interview_dt">
                            </div>
                        </div>
                    </div>
                
                    <!-- Hidden ID -->
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                
                    <!-- Buttons -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                        <!-- Send Mail Button (Outside Form) -->
                      <div class="d-flex align-items-center">
                            <?php if (!empty($row['interview_dt'])): ?>
                                <button type="button" class="btn btn-primary mt-2" onclick="sendMail()">Send Message</button>
                            <?php endif; ?>
                            <div id="loadingSpinner" class="ml-2" style="display: none;">
                                <div class="spinner-border" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </div>

                
                        <!-- Update and Exit Buttons -->
                        <div>
                            <button type="submit" class="btn btn-success" name="submit">Update</button>
                            <a href="complaintsList.php" class="btn btn-danger">Exit</a>
                        </div>
                    </div>
                </form>

                        </div>
                        <script>
                           document.getElementById('edit-icon').addEventListener('click', function() {
                                let fields = document.querySelectorAll('.editable-fields input, .editable-fields textarea');
                                fields.forEach(field => {
                                    if (field.hasAttribute('readonly')) {
                                        field.removeAttribute('readonly');
                                        field.style.backgroundColor = "#fff"; // Optional: change background color to indicate edit mode
                                    } else {
                                        field.setAttribute('readonly', 'readonly');
                                        field.style.backgroundColor = "#e9ecef"; // Reset background color to indicate read-only mode
                                    }
                                });
                            });
                        </script>
                    </div>  
                </div>  
            </div>
        </div>
    </div>
</div>

<script>
    
     function sendMail() {
    // Show loading spinner
    document.getElementById('loadingSpinner').style.display = 'block';

    // Get the hidden ID value
    const id = document.querySelector('input[name="id"]').value;

    fetch('sendMail.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            id: id,
        }),
    })
    .then(response => response.json())
    .then(data => {
        // Hide loading spinner
        document.getElementById('loadingSpinner').style.display = 'none';

        if (data.status === "success") {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: data.message,
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message,
            });
        }
    })
    .catch(error => {
        // Hide loading spinner
        document.getElementById('loadingSpinner').style.display = 'none';

        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to send message.',
        });
    });
}
</script>

<?php 
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