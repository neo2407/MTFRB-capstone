function updateAccountStatus(applicantId, newStatus) {
  Swal.fire({
    title: 'Are you sure?',
    text: 'Do you really want to update the status?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, update it!',
    cancelButtonText: 'Cancel'
  }).then((result) => {
    if (result.isConfirmed) {
      // User confirmed the action
      $.ajax({
        url: 'update_account_status.php',
        type: 'POST',
        data: { id: applicantId, status: newStatus },
        dataType: 'json',
        success: function(response) {
          console.log(response); // Log the response for debugging

          if (response.status === "success") {
            Swal.fire({
              title: 'Success',
              text: response.message,
              icon: 'success',
              confirmButtonText: 'OK'
            });
          } else if (response.status === "warning") {
            Swal.fire({
              title: 'Warning',
              text: response.message,
              icon: 'warning',
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
    // No action is needed for a cancelled confirmation
  });
}
