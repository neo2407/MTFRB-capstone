function updateOperatorsComplaintStatus(id, newstatus, month) {
    //console.log('Updating complaint with:', { id, newstatus, month });

    $.ajax({
        url: 'operators_complaint_status.php',
        type: 'POST',
        data: { id: id, newstatus: newstatus, month: month },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                Swal.fire('Updated!', 'Complaint status updated successfully!', 'success');
                $(`#status-dropdown-${id}`).val(newstatus); // Update dropdown value
            } else {
                Swal.fire('Error!', response.message || 'There was a problem updating the status.', 'error');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('AJAX Error:', textStatus, errorThrown);
            Swal.fire('Error!', 'There was a problem with the request.', 'error');
        }
    });

    return false; // Prevent default form action
}
