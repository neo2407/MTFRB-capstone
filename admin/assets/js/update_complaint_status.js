// To verify and update the complaint status
function updateComplaintStatus(complaintId, newStatus) {
  // Debugging line: Log the status
  console.log("Complaint Status:", newStatus);

  // Check if the new status is "Dismissed"
  if (newStatus === "Dismissed") {
    // Prompt the user for the dismissal of the complaint using SweetAlert
    Swal.fire({
      title: 'Enter Reason for Dismissal of Complaint',
      input: 'text',
      inputPlaceholder: 'Type Here...',
      showCancelButton: true,
      confirmButtonText: 'Submit',
      cancelButtonText: 'Cancel',
      preConfirm: (reason) => {
        console.log("Reason Entered:", reason);  // Debugging line

        // Validate if a reason is provided
        if (!reason) {
          Swal.showValidationMessage('Please enter a reason for dismissal of complaint');
          return false;
        }
        return reason;
      }
    }).then((result) => {
      if (result.isConfirmed) {
        const dismissalReason = result.value;
        console.log("Dismissal Reason:", dismissalReason);  // Debugging line
        // Send AJAX request to update the status and dismissal reason
        sendStatusUpdate(complaintId, newStatus, dismissalReason, true); // Indicate email needs to be sent
      }
    }).catch(error => {
      // Log any errors during SweetAlert flow
      console.error("Error with SweetAlert:", error);
    });
  } else {
    // If the status is not "Dismissed", update the complaint status without a reason
    sendStatusUpdate(complaintId, newStatus);
  }
}

// Helper function to send the AJAX request for status update
function sendStatusUpdate(complaintId, status, dismissalReason = null, sendEmail = false) {
  console.log("Sending status update for Complaint ID:", complaintId, "New Status:", status, "Dismissal Reason:", dismissalReason);

  $.ajax({
    url: 'update_complaint_status.php',
    type: 'POST',
    data: { 
      id: complaintId, 
      status: status, 
      dismissalReason: dismissalReason // Include dismissal reason here
    },
    dataType: 'json',
    success: function(response) {
      if (response.status === "success") {
        // Show success message for status update
        Swal.fire({
          title: 'Success',
          text: 'Complaint status updated successfully!',
          icon: 'success',
          confirmButtonText: 'OK'
        }).then(() => {
          // If the status is "Dismissed" and email needs to be sent
          if (sendEmail && status === "Dismissed") {
            sendDismissalEmail(complaintId, dismissalReason);
          }
        });
      } else {
        Swal.fire({
          title: 'Warning',
          text: response.message,
          icon: 'warning',
          confirmButtonText: 'OK'
        });
      }
    },
    error: function(xhr, status, error) {
      console.error("Error updating complaint status:", error);  // Debugging line
      Swal.fire({
        title: 'Error',
        text: 'An error occurred while updating the status.',
        icon: 'error',
        confirmButtonText: 'OK'
      });
    }
  });
}

// Function to send the dismissal email
function sendDismissalEmail(complaintId, dismissalReason) {
  console.log(`Attempting to send dismissal email for Complaint ID: ${complaintId} with reason: ${dismissalReason}`);  // Debugging line

  $.ajax({
    url: 'send_dismissal_email.php', // Ensure this path is correct
    type: 'POST',
    data: { id: complaintId, reason_dismissal: dismissalReason },
    dataType: 'json',
    success: function(response) {
      console.log("Email Response:", response);  // Debugging line
      if (response.status === "success") {
        Swal.fire({
          title: 'Success',
          text: response.message || 'Dismissal of Complaint email sent successfully!',
          icon: 'success',
          confirmButtonText: 'OK'
        });
      } else {
        Swal.fire({
          title: 'Error',
          text: response.message || 'Failed to send the email.',
          icon: 'error',
          confirmButtonText: 'OK'
        });
      }
    },
    error: function(xhr, status, error) {
      console.error("AJAX Error:", error);  // Debugging line
      console.error("Response text:", xhr.responseText);  // Debugging line
      Swal.fire({
        title: 'Error',
        text: 'An error occurred while sending the dismissal of complaint email.',
        icon: 'error',
        confirmButtonText: 'OK'
      });
    }
  });
}
