<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Account Modal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .swal2-container {
            z-index: 1060 !important; /* Ensure SweetAlert2 is on top of Bootstrap modal */
        }
    </style>

</head>
<body>
    <div class="modal fade" id="add_complaint_Modal" tabindex="-1" role="dialog" aria-labelledby="add_complaint_ModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog custom-width" role="document" style="max-width: 700px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_complaint_ModalLabel">Add Complaint</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="complaintsAdmin.php" method="post" enctype="multipart/form-data" style='margin-bottom: 10px;'>
                        <div class="form-group row">
                            <div class="col-md-5">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" name="first_name" placeholder="Albert" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="last_name" placeholder="Einstein" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Middle Name</label>
                                <input type="text" class="form-control" name="m_name" placeholder="Santos" required>
                            </div>
                        </div>
                  
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-label">Contact Number</label>
                                <input type="text" class="form-control" id="contactNum" name="contactNum" placeholder="09xxxxxxxxx" required>
                    <span id="contactError" style="color: red; display: none;">Contact number must be exactly 11 digits and contain only numbers.</span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="name@example.com" required>
                            </div>
                        </div>
                   
                        <div class="form-group row">
                                <div class="col-md-6">
                                    <label class="form-label">Date of Complaint</label></label>
                                    <input type="datetime-local" class="form-control" id="dateOfincident" name="dateOfincident">
                                </div>

                                <div class="col-md-6">
                                <label class="form-label">Reason of Complaint</label>
                                <textarea class="form-control" id="	descOfincident" name="descOfincident" rows="4"
                                    placeholder="Type the reason of complaint here..." style="resize: none;"
                                    required></textarea>
                                </div>
                        </div>
                    
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-label">Tricycle Franchise No.</label>
                                <input type="number" class="form-control" id="TFno" name="TFno"
                                    placeholder="Type the TF no (if known)">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tricycle Color</label>
                                <input type="text" class="form-control" id="colorOftric" name="colorOftric" placeholder="Blue">
                            </div>
                        </div>
                       
                        <div class="form-group row">
                        <div class="col-md-6">
                            <label for="madeOf" class="form-label">Body Built</label>
                                <select id="madeOf" name="madeOf" class="form-control rounded" required>
                                    <option value="">Select</option>
                                    <option value="Tricycle">Tricycle</option>
                                    <option value="Tricycle(Back-to-Back)">Tricycle(Back-to-Back)</option>
                                    <option value="Tuktuk">Tuktuk</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                            <label class="form-label">Driver Description</label>
                            <textarea class="form-control" id="descOfdriver" name="descOfdriver" rows="4"
                                placeholder="Type the decription of the driver here..." style="resize: none;"
                                required></textarea>
                            </div>
                        </div>
                                               
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-label">Upload Supporting Evidence</label>
                                <input type="file" class="form-control-file form-control" name="evidence" accept="image/mkv*"required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Preffered Date of Contact</label>
                                <input type="datetime-local" class="form-control" id="dtOfcontact" name="dtOfcontact">
                            </div>
                        </div>
                       
                        <div class="form-group row">
                            <div class="col text-right">
                            <button type="submit" name="submit" class="btn btn-primary">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
document.getElementById('contactNum').addEventListener('input', function () {
    var contactInput = this.value;
    var errorMessage = document.getElementById('contactError');

    // Check if the input is exactly 11 digits and contains only numbers
    if (/^\d{11}$/.test(contactInput)) {
        errorMessage.style.display = 'none'; // Hide error if valid
        this.setCustomValidity(''); // Clear invalid state
    } else {
        errorMessage.style.display = 'block'; // Show error if invalid
        this.setCustomValidity('Invalid'); // Set invalid state for form validation
    }
});
</script>
</body>

</html>
