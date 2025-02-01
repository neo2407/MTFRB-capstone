// Function to update the dropdown status based on interview_dt
function updateInterviewStatusDropdown(row) {
    let currentDate = new Date();
    let interviewDateObj = new Date(row.interview_sched);

    // Determine the appropriate status
    if (interviewDateObj < currentDate && row.interviewStatus !== "Done") {
        row.interviewStatus = "Missed"; // Automatically set to 'Missed' if past the interview date
    }

    // Update the dropdown dynamically
    const selectElement = document.querySelector(`select[data-id='${row.id}']`);
    if (selectElement) {
        selectElement.value = row.interviewStatus; // Set the correct value for the dropdown
    }
}

// Function to send updated status to the server
function updateInterviewStatus(interviewId, newStatus, interviewDate) {
    let currentDate = new Date();
    let interviewDateObj = new Date(interviewDate);

    // Automatically adjust status for past interviews
    if (interviewDateObj < currentDate && newStatus !== "Done") {
        newStatus = "Missed";
    }

    // Send the status update to the server via AJAX
    $.ajax({
        url: 'interviewStatus.php',
        type: 'POST',
        data: { id: interviewId, status: newStatus },
        dataType: 'json',
        success: function(response) {
            if (response.status === "success") {
                Swal.fire({
                    title: 'Success',
                    text: response.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: response.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        },
        error: function() {
            Swal.fire({
                title: 'Error',
                text: 'Failed to update interview status.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
}

// Fetch interview data and update dropdowns
$.ajax({
    url: 'fetch_interview_data_applicant.php',
    type: 'GET',
    dataType: 'json',
    success: function(data) {
        data.forEach(row => {
            updateInterviewStatusDropdown(row); // Update dropdown based on interview date
        });
    },
    error: function() {
        console.error("Error fetching interview data.");
    }
});
