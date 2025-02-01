<!-- Function to delete data -->
<script type="text/javascript">
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure to delete this complaint?',
            text: "You won't be able to undo this action!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "delete_complaints.php?id=" + id;
            }
        })
    }
</script>

<style>
    .light-label {
    font-weight: 80; /* Light font weight */
    font-size:1rem; /* Optional: Adjust font size if needed */
    color: #000000; /* Optional: Adjust color to make it more subtle */
}
</style>
<!-- Functions sa modal ng Complaints -->
<script>
        let currentComplaintId = null; // to store the current complaint ID

        function showDetails(id) {
            currentComplaintId = id; // store the complaint ID
            fetch(`complaint_getDetails.php?id=${id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    let details = `
                       
                     <form>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="light-label">First Name:</label>
                                <input type="text" class="form-control" value="${data.first_name}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="light-label">Last Name:</label>
                                <input type="text" class="form-control" value="${data.last_name}" readonly>
                            </div>
                        </div>
                    
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="light-label">Email:</label>
                                <input type="email" class="form-control" value="${data.email}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="light-label">Contact Number:</label>
                                <input type="text" class="form-control" value="${data.contactNum}" readonly>
                            </div>
                        </div>
                    
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="light-label">Date of Complaint:</label>
                                <input type="text" class="form-control" value="${data.dateOfincident}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="light-label">Tricycle Franchise Number:</label>
                                <input type="text" class="form-control" value="${data.TFno}" readonly>
                            </div>
                        </div>
                    
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="light-label">Color of Tricycle:</label>
                                <input type="text" class="form-control" value="${data.colorOftric}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="light-label">Body Built:</label>
                                <input type="text" class="form-control" value="${data.madeOf}" readonly>
                            </div>
                        </div>
                    
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="light-label">Description of the Driver:</label>
                                <textarea class="form-control" readonly>${data.descOfdriver}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="light-label">Preferred Date and Time for Contact:</label>
                                <input type="text" class="form-control" value="${data.dtOfcontact}" readonly>
                            </div>
                        </div>
                    
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="light-label">Description of Complaint:</label>
                                <textarea class="form-control" readonly>${data.descOfincident}</textarea>
                            </div>
                        </div>
                    
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="light-label">Supporting Evidence:</label>
                                <a href="../../uploads/complaints/${data.evidence}" target="_blank">View Attachment</a>
                            </div>
                        </div>
                    </form>

                    `;
                    document.getElementById('detailsContent').innerHTML = details; // connected sa modal 
                    let detailsModal = new bootstrap.Modal(document.getElementById('detailsModal'));
                    detailsModal.show();
                })
                .catch(error => console.error('Error:', error));
        }

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

 