//<!-- updating payment status-->

function updatePaymentStatus(id, status) {
    $.ajax({
        url: 'paymentStatus.php',
        type: 'POST',
        data: { id: id, status: status },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                Swal.fire('Updated!', 'The payment status has been updated.', 'success');
            } else {
                Swal.fire('Error!', 'Generate Order of Payment First Before Updating payment status.', 'error');
            }
        },
        error: function() {
            Swal.fire('Error!', 'There was a problem with the request. Order of payment not generated', 'error');
        }
    });
}
