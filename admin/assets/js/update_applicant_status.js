function updateApplicantStatus(applicantId, newStatus) {
  // Check if the new status is "Denied"
  if (newStatus === "Denied") {
    // Prompt the user for the denial reason using SweetAlert
    Swal.fire({
      title: 'Enter Reason for Denial of Application',
      input: 'text',
      inputPlaceholder: 'Type the Reason for Denial Application Here',
      showCancelButton: true,
      
      confirmButtonText: 'Submit',
      cancelButtonText: 'Cancel',
      preConfirm: (reason) => {
        if (!reason) {
          Swal.showValidationMessage('Please enter a reason for denial of Application');
          return false;
        }
        return reason;
      }
    }).then((result) => {
      if (result.isConfirmed) {
        const denialReason = result.value;
        // Send AJAX request to update the status and denial reason
        sendStatusUpdate(applicantId, newStatus, denialReason, true); // Indicate email needs to be sent
      }
    });
  } else {
    // If status is not "Denied," proceed without a reason
    sendStatusUpdate(applicantId, newStatus);
  }
}

// Helper function to send the AJAX request for status update
function sendStatusUpdate(applicantId, status, denialReason = null, sendEmail = false) {
  $.ajax({
    url: 'update_applicant_status.php',
    type: 'POST',
    data: { 
      id: applicantId, 
      status: status, 
      denialReason: denialReason // Include denial reason here
    },
    dataType: 'json',
    success: function(response) {
      if (response.status === "success") {
        // Show success message for status update
        Swal.fire({
          title: 'Success',
          text: 'Applicant status updated successfully!',
          icon: 'success',
          confirmButtonText: 'OK'
        }).then(() => {
          // If the status is "Denied" and email needs to be sent
          if (sendEmail && status === "Denied") {
            sendDenialEmail(applicantId, denialReason);
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
      Swal.fire({
        title: 'Error',
        text: 'An error occurred while updating the status.',
        icon: 'error',
        confirmButtonText: 'OK'
      });
    }
  });
}


// Function to send the denial email
function sendDenialEmail(applicantId, denialReason) {
  console.log(`Attempting to send denial email for Applicant ID: ${applicantId}`);

  $.ajax({
    url: 'send_denial_email.php', // Ensure this path is correct
    type: 'POST',
    data: { id: applicantId, reason_denial: denialReason },
    dataType: 'json',
    success: function(response) {
      console.log("Email Response:", response);
      if (response.status === "success") {
        Swal.fire({
          title: 'Success',
          text: response.message || 'Denial email sent successfully!',
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
      console.error("AJAX Error:", error);
      console.error("Response text:", xhr.responseText);
      Swal.fire({
        title: 'Error',
        text: 'An error occurred while sending the denial email.',
        icon: 'error',
        confirmButtonText: 'OK'
      });
    }
  });
}

