<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="violationModal" tabindex="-1" role="dialog" aria-labelledby="violationModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="violationModalLabel">Add Violator</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="add_violator.php" method="post">
                     <div class="form-group row">
                         <div class="col-md-6">
                            <label for="ticketNo">Ticket No</label>
                            <input type="number" class="form-control" name="ticketNo" id="ticketNo" required>
                        </div>
                        <div class="col-md-6">
                            <label for="receiptNumber">Receipt No</label>
                            <input type="number" class="form-control" id="receiptNumber" name="receiptNumber" required >
                        </div>
                                               
                    </div>
                     <div class="form-group row">
                         <div class="col-md-6">
                            <label for="TFno">Tricycle Franchise No</label>
                            <input type="text" class="form-control" name="TFno" id="TFno" required>
                            <small id="tfno-feedback" class="form-text text-muted"></small>
                        </div>
                        <div class="col-md-6">
                            <label for="operator_name">Name</label>
                            <input type="text" class="form-control" id="operator_name" name="operator_name" required readonly>
                        </div>
                                               
                    </div>
                    <div class="form-group row">
                       
                    </div>
                    <div class="form-group row">
                         <div class="col-md-6">
                            <label for="violationDate">Violation Date</label>
                            <input type="date" class="form-control" name="violationDate" required>
                        </div>
                         <div class="col-md-6">
                            <label for="violationType">Violation Type</label>
                            <input type="text" class="form-control" name="violationType" required>
                        </div>
                      
                    </div>
                    <div class="form-group row">
                         <div class="col-md-6">
                            <label for="penaltyCharged">Penalty Charged</label>
                            <input type="text" class="form-control" name="penaltyCharged" required>
                        </div>

                        <div class="col-md-6">
                            <label for="offenseType">Offense Type</label>
                            <div class="dropdown-arrow">
                                <select class="form-control" name="offenseType" required>
                                    <option value="">Select Type of Offense</option>
                                    <option value="1st Offense">1st Offense</option>
                                    <option value="2nd Offense">2nd Offense</option>
                                    <option value="3rd Offense">3rd Offense</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="enforcer">Enforcer In-charged</label>
                            <input type="text" class="form-control" name="enforcer" required>
                        </div>
                    </div>
                    <div class="text-right">
                    <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .dropdown-arrow {
        position: relative;
    }

    .dropdown-arrow select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    .dropdown-arrow::after {
        content: '\25BC'; /* Unicode for down arrow */
        font-size: 12px;
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        pointer-events: none;
    }
</style>


<style>
    .dropdown-arrow {
        position: relative;
    }

    .dropdown-arrow select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    .dropdown-arrow::after {
        content: '\25BC'; /* Unicode for down arrow */
        font-size: 12px;
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        pointer-events: none;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {
    console.log('Document ready');

    // Ensure script is applied after modal is displayed
    $('#violationModal').on('shown.bs.modal', function () {
        console.log('Modal shown');  // Debugging: Check if modal is shown

        // Trigger the event when modal is shown
        $(document).on('input', '#TFno', function () {
            console.log("Input detected: ", $(this).val());  // Log the input value
            
            const TFno = $(this).val();
            if (TFno.trim() === '') {
                $('#tfno-feedback').text(''); // Clear feedback if empty
                $('#operator_name').val(''); // Clear operator name field
                return;
            }

            // AJAX request to check TFno
            $.ajax({
                url: 'check_tfno.php',
                type: 'POST',
                data: { TFno: TFno },
                dataType: 'json',
                success: function (response) {
                    console.log("AJAX success:", response);  // Log the response
                    if (response.error) {
                        $('#tfno-feedback').text(response.error).css('color', 'red');
                        $('#operator_name').val(''); // Clear operator name field if TFno is invalid
                    } else if (response.exists) {
                        $('#tfno-feedback').text('Tricycle Franchise No. is valid and exists.').css('color', 'green');
                        $('#operator_name').val(response.operator_name); // Auto-fill operator name with full name
                    } else {
                        $('#tfno-feedback').text('Tricycle Franchise No. does not exist.').css('color', 'red');
                        $('#operator_name').val(''); // Clear operator name field if TFno does not exist
                    }
                },
                error: function () {
                    console.log("AJAX error");  // Log if there's an error with the request
                    $('#tfno-feedback').text('Error checking Tricycle Franchise No.').css('color', 'red');
                }
            });
        });

        // Check if form can be submitted
        $('form').on('submit', function (e) {
            const feedbackMessage = $('#tfno-feedback').text();

            // Check if the TFno feedback message includes 'does not exist'
            if (feedbackMessage.includes('does not exist') || feedbackMessage.trim() === '') {
                e.preventDefault();  // Prevent form submission
                
                // Show SweetAlert2 message
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid TFno',
                    text: 'Tricycle Franchise No. does not exist.',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
});
</script>

