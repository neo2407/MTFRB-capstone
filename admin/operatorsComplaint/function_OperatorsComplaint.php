<script>
function confirmDelete(id, month) {
    console.log('Confirm delete called with ID:', id, 'and Month:', month); // Debugging line

    Swal.fire({
        title: 'Are you sure you want to delete this complaint?',
        text: "You won't be able to undo this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        console.log('SweetAlert result:', result); // Log result of SweetAlert
        if (result.isConfirmed) {
            deleteRecord(id, month);
        }
    });
}

function deleteRecord(id, month) {
    console.log('Sending delete request with ID:', id, 'and Month:', month); // Log ID and Month for debugging

    $.ajax({
        url: 'delete.php',
        type: 'POST',
        data: { id: id, month: month },
        dataType: 'json',
        success: function(response) {
            console.log('Delete response:', response); // Log response
            if (response.status === 'success') {
                Swal.fire('Updated!', 'Operators Complaint Deleted Successfully.', 'success');
                
            } else {
                Swal.fire('Error!', response.message || 'There was a problem updating the record.', 'error');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('AJAX Error:', textStatus, errorThrown); // Log AJAX errors
            console.log('Response Text:', jqXHR.responseText); // Log response text
            Swal.fire('Error!', 'There was a problem with the request.', 'error');
        }
    });
}
</script>
