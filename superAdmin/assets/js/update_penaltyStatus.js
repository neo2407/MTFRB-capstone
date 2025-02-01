function penaltyStatus(penaltyId, newStatus) {
    console.log("Starting AJAX request to update penalty status...");

    $.ajax({
        url: 'update_penalty_status.php',
        type: 'POST',
        data: { ticketNo: penaltyId, status: newStatus },
        dataType: 'json',
        success: function(response) {
            console.log("AJAX request completed. Response: ", response);
            if (response.status === "success") {
                if (newStatus === "Paid" && response.summary) {
                    let summary = response.summary;
                    let summaryText = `
                        <strong>Name:</strong> ${summary.name}<br>
                        <strong>Receipt Number:</strong> ${summary.receiptNumber}<br>
                        <strong>Ticket No:</strong> ${summary.ticketNo}<br>
                        <strong>Violation Date:</strong> ${summary.violationDate}<br>
                        <strong>Operator Name:</strong> ${summary.operator_name}<br>
                        <strong>Violation Type:</strong> ${summary.violationType}<br>
                        <strong>TF No:</strong> ${summary.TFno}<br>
                        <strong>Penalty Charged:</strong> ${summary.penaltyCharged}<br>
                        <strong>Offense Type:</strong> ${summary.offenseType}<br>
                        <strong>Enforcer:</strong> ${summary.enforcer}<br>
                        
                    `;
                    Swal.fire({
                        title: 'Success',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        Swal.fire({
                            title: 'Payment Summary',
                            html: summaryText,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    });
                } else {
                    Swal.fire({
                        title: 'Success',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                }
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
            console.error("AJAX request failed. Status: ", status, " Error: ", error);
            Swal.fire({
                title: 'Error',
                text: 'An error occurred while updating the status.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
}
