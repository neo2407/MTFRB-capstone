function updateOperatorsComplaint(id, status, month) {
    console.log('Updating complaint with:', { id, status, month }); // Log parameters

    $.ajax({
        url: 'operators_complaint_interview.php',
        type: 'POST',
        data: { id: id, status: status, month: month },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                Swal.fire('Updated!', 'The interview status has been updated.', 'success');
            } else {
                Swal.fire('Error!', response.message || 'There was a problem updating the status.', 'error');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('AJAX Error:', textStatus, errorThrown); // Log AJAX errors
            Swal.fire('Error!', 'There was a problem with the request.', 'error');
        }
    });
}
