<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Details Modal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .swal2-container {
            z-index: 1060 !important; /* Ensure SweetAlert2 is on top of Bootstrap modal */
        }
    </style>
</head>
<body>

<!-- Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel">Applicant Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Details will be loaded here dynamically -->
                <div id="detailsContent"></div>
            </div>
            <div class="modal-body">
            <div class="row mb-3">
                <div class="col">
                    <label class="form-label">Schedule of Interview</label>
                    <input type="datetime-local" class="form-control" id="interview_sched">
                </div>
                 <div class="col">
                    <br>
                    <button class="btn btn-primary mt-2" onclick="addInterview()">Add</button>
                </div>
            </div>
             <div class="modal-body">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary mt-2" onclick="sendMail()">Send Mail Message</button>
                    <div id="loadingSpinner" class="ml-2" style="display: none;">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
            
                <!--<a href="sendMailform.php?id=<?php echo $id;?>" class="btn btn-success"></i>Send Mail</a>-->
                <!--<a href="javascript:void(0);" onclick="confirmDelete(${row.id})" class="link-dark"><i class="fa-solid fa-trash fs-5"></i></a>-->
                <!--<a href="sendMailform.php?id=<?php echo $id; ?>" class="btn btn-success">Send Email Message</a>-->
               
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!--
<script>
function sendMail(id) {
    fetch(`sendMail.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id=${id}`
    })
    .then(response => response.json())
    .then(data => {
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
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to send message.',
        });
    });
}
</script>
    -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>