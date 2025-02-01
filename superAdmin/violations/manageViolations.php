<?php
    include "../include/headerAdmin.php";
    include "../include/navbarAdmin.php";
?>

<style>
    .btn.btn-primary {
        background-color: #2680C2;
        color: #fff;
        border: 1px solid #2680C2;
        box-shadow: inset 0 0 0 0 #fff;
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    .btn.btn-primary:hover {
        background-color: #fff;
        border-color: #2680C2;
        color: #2680C2;
        box-shadow: inset 0 50px 0 0 #fff;
    }
</style>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <?php include "../include/topbarAdmin.php"; ?>

    <!-- Main Content -->
    <div class="container-fluid" style="margin-left:20px;">
        <h3 class="h3 mb-0 text-gray-800">Violations List</h3>
        <div class="page-wrapper" style="min-height: 548px; margin-left: -75px;">
            <div class="content container-lg">
                <div class="page-header">
                    <div class="content-page-header">
                        <div class="list-btn">
                            <ul class="filter-list">
                             <li>
                                    <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#violationModal"
                                       
                                       onmouseover="this.style.backgroundColor='#fff'; this.style.borderColor='#2680C2'; this.style.color='#2680C2'; this.style.boxShadow='inset 0 50px 0 0 #fff';"
                                       onmouseout="this.style.backgroundColor='#2680C2'; this.style.borderColor='#2680C2'; this.style.color='#fff'; this.style.boxShadow='inset 0 0 0 0 #fff';">
                                       <i class="fa fa-plus-circle me-2" aria-hidden="true"></i> Add Violation
                                    </a>
                                </li>
                                <li>
                                    <a class="btn btn-filters w-auto popup-toggle" data-bs-toggle="tooltip"
                                       data-bs-placement="bottom" data-bs-original-title="Filter">
                                       <i class="fas fa-sliders-h" style="margin-right: 10px;"></i>Filter Violation
                                    </a>
                                </li>
                                  <li>
                                    <a class="btn btn-filters" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom" data-bs-original-title="Filter">
                                    <i class="fa-solid fa-rotate-right" style="margin-right:10px;"></i>Reset Filter
                                    </a>
                                </li>
                                <li>
                                    <a id="printTableBtn" class="btn-filters" href="javascript:void(0);"
                                       data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Filter"
                                       style="text-decoration: none;">
                                       <i class="fas fa-print" style="margin-right: 10px;"></i>Save and Print
                                    </a>
                                </li>
                               
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="container-fluid" style="margin-left: -20px;">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-table">
                                <div class="card-body">
                                    <div class="table-container">
                                        <div class="table-responsive">
                                            <table class="table table-hover text-center">
                                                <thead id="table_header" class="thead-light">
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Ticket No.</th>
                                                        <th scope="col">Violation Type</th>
                                                        <th scope="col">Tricyle Franchise No.</th>
                                                        <th scope="col">Offense</th>
                                                        <th scope="col">Penalty Status</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="table_body">
                                                    <!-- Content loaded via JavaScript -->
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="dataTables_length" id="DataTables_Table_0_length" style="display: flex; align-items: center;">
                                            <label style="margin-right: 5px;">Show</label>
                                            <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0"
                                                    class="custom-select custom-select-sm form-control form-control-sm"
                                                    style="width: auto; margin-right: 3px;">
                                                <option value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
                                            <label style="margin-left: 3px;">Entries</label>
                                        </div>
                                        <div class="dataTables_paginate paging_simple_numbers align-items-center"
                                             id="DataTables_Table_0_paginate">
                                            <ul class="pagination">
                                                <li class="paginate_button page-item previous disabled" id="DataTables_Table_0_previous">
                                                    <a href="#" aria-controls="DataTables_Table_0" data-dt-idx="0"
                                                       tabindex="0" class="page-link">
                                                       <i class="fa fa-angle-double-left me-2"></i> Previous
                                                    </a>
                                                </li>
                                                <li class="paginate_button page-item active">
                                                    <a href="#" aria-controls="DataTables_Table_0" data-dt-idx="1"
                                                       tabindex="0" class="page-link">1</a>
                                                </li>
                                                <li class="paginate_button page-item next disabled" id="DataTables_Table_0_next">
                                                    <a href="#" aria-controls="DataTables_Table_0" data-dt-idx="2"
                                                       tabindex="0" class="page-link">
                                                       Next <i class="fa fa-angle-double-right ms-2"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="toggle-sidebar ledge">
                    <div class="sidebar-layout-filter">
                    <div class="text-right" style="margin-top: 20px; margin-right: 10px;">
                            <a href="#" class="sidebar-close" style="font-size: 1.5em; padding: 10px;">
                                <i class="fa-regular fa-circle-xmark"></i>
                            </a>
                        </div>
                        <div class="sidebar-header ledge">
                            <h5>Search Violator</h5>
                        </div>
                        
                        <div class="sidebar-body">
                            <form id="filterForm" action="#" autocomplete="off">
                                <div class="accordion" id="accordionMain2">
                                    <div class="col-lg-12 col-sm-12">
                                        <div class="input-block mb-3">
                                            <label>Penalty Status</label>
                                            <select class="form-control" id="penaltyStatus">
                                                <option value="">Select Status</option>
                                                <option value="Pending">Pending</option>
                                                <option value="Paid">Paid</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-sm-12">
                                        <div class="input-block mb-3">
                                            <label>Offense</label>
                                            <select class="form-control" id="offenseType">
                                                <option value="">Select Offense Type</option>
                                                <option value="1st Offense">1st Offense</option>
                                                <option value="2nd Offense">2nd Offense</option>
                                                <option value="3rd Offense">3rd Offense</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-sm-12">
                                        <div class="input-block mb-3">
                                            <label>Ticket No</label>
                                            <input type="text" class="form-control" id="ticketNo" placeholder="Ticket No">
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-sm-12">
                                        <div class="input-block mb-3">
                                            <label>Franchise No</label>
                                            <input type="text" class="form-control" id="TFno" placeholder="Franchise No">
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-sm-12">
                                        <div class="input-block mb-3">
                                            <label>Violation Type</label>
                                            <input type="text" class="form-control" id="violationType" placeholder="Violation Type">
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="search" class="btn btn-primary" name="search">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        // Sidebar popup overlay
        if ($('.popup-toggle').length > 0) {
        $(".popup-toggle").click(function() {
            $(".toggle-sidebar").addClass("open-filter");
            $("body").addClass("filter-opened");
        });
        
        $(".sidebar-close").click(function() {
            $(".toggle-sidebar").removeClass("open-filter");
            $("body").removeClass("filter-opened");
        });
        }


         // Store original table HTML
        var originalTableHeader = $('#table_header').html();
        var originalTableBody = $('#table_body').html();

        // Print table functionality
        $('#printTableBtn').on('click', function() {
            // Get the HTML of the current table header and body
            var tableHeader = $('#table_header').html();
            var tableBody = $('#table_body').html();

            // Remove the action column from the table header
            var filteredTableHeader = $('#table_header').find('tr').map(function() {
                var $row = $(this);
                $row.find('th:last').remove(); // Remove the last cell in the header row (the action cell)
                return $row.html();
            }).get().join('</tr><tr>'); // Rejoin rows

            // Remove the action column from the table body
            var filteredTableBody = $('#table_body').find('tr').map(function() {
                var $row = $(this);
                $row.find('td:last').remove(); // Remove the last cell in each row (the action cell)
                return $row.html();
            }).get().join('</tr><tr>'); // Rejoin rows

            var printWindow = window.open('', '', 'height=600,width=800'); // Open a new window

            printWindow.document.write('<html><head><title>Print Table</title>');
            printWindow.document.write('<style>');
            printWindow.document.write('table { width: 100%; border-collapse: collapse; }');
            printWindow.document.write('th, td { border: 1px solid black; padding: 8px; text-align: left; }');
            printWindow.document.write('th { background-color: #f2f2f2; }');
            printWindow.document.write('</style>');
            printWindow.document.write('</head><body >');
            printWindow.document.write('<h1>Violators List</h1>');
            printWindow.document.write('<table>');
            printWindow.document.write('<thead>' + filteredTableHeader + '</thead>'); // Insert the filtered table header
            printWindow.document.write('<tbody>' + '<tr>' + filteredTableBody + '</tr>' + '</tbody>'); // Insert the filtered table body
            printWindow.document.write('</table>');
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();

            // Restore original table content after printing
            setTimeout(function() {
                $('#table_header').html(originalTableHeader);
                $('#table_body').html(originalTableBody);
            }, 1000); // Delay to ensure print operation completes
        });
    </script>
    <script src = ../assets/js/load_manageViolations.js></script>

    <?php 
        include "add_violatorsModal.php"; 
        include "../include/scripts.php"; 
        include "../include/scriptsAdmin.php";
        include "../include/footerAdmin.php";
    ?>
    
        
    <!-- modal summary paid -->


<script>
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
                        <div id="paymentSummary">
                            <strong>Receipt Number:</strong> ${summary.receiptNumber}<br>
                            <strong>Ticket No:</strong> ${summary.ticketNo}<br>
                            <strong>Violation Date:</strong> ${summary.violationDate}<br>
                            <strong>TF No:</strong> ${summary.TFno}<br>
                            <strong>Operator Name:</strong> ${summary.operator_name}<br>
                            <strong>Violation Type:</strong> ${summary.violationType}<br>
                            <strong>Penalty Charged:</strong> ${summary.penaltyCharged}<br>
                            <strong>Offense Type:</strong> ${summary.offenseType}<br>
                            <strong>Enforcer:</strong> ${summary.enforcer}<br>
                        </div>
                    `;

                    Swal.fire({
                        title: 'Payment Summary',
                        html: summaryText,
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonText: 'OK',
                        cancelButtonText: 'Print',
                        customClass: {
                            cancelButton: 'swal2-print-btn'
                        }
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.cancel) {
                            printReceipt(summary);
                        }
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

function printReceipt(summary) {
    // Declare and calculate the total amount early
    const totalAmount = parseFloat(summary.penaltyCharged);  // Move this line here
    const amount = totalAmount;  // You can now use 'amount' directly if you need

    // Populate the receipt template with data
    document.getElementById('receiptNum').textContent = summary.receiptNumber;
//console.log("Receipt Number (DOM):", document.getElementById('receiptNumb').textContent);
    document.getElementById('ticketNumber').textContent = summary.ticketNo;
    document.getElementById('tfNumber').textContent = summary.TFno;
    document.getElementById('name').textContent = summary.operator_name;
    document.getElementById('date').textContent = new Date(summary.violationDate).toLocaleDateString();
    document.getElementById('offenseType').textContent = summary.offenseType;
    document.getElementById('violationType').textContent = summary.violationType;

    // Use the totalAmount variable now that it's declared
    document.getElementById('penaltyDescription').textContent = `Violation: ${summary.violationType}`;
    document.getElementById('penaltyCharged').textContent = `₱ ${totalAmount.toFixed(2)}`;
    document.getElementById('totalAmount').textContent = `₱ ${totalAmount.toFixed(2)}`;
    
    // Convert the total amount to words
    document.getElementById('amountInWords').textContent = convertNumberToWords(totalAmount);

    // Log to debug
    console.log("Total Amount:", totalAmount);
    console.log("Amount in words:", convertNumberToWords(totalAmount));

    // Use a timeout to ensure the DOM updates are complete before printing
    setTimeout(() => {
        const receiptContent = document.getElementById('receiptTemplate').innerHTML;

        // Create a new window and write the updated content
        const printWindow = window.open("", "", "height=600,width=800");
        printWindow.document.open();
        printWindow.document.write(`
            <html>
                <head>
                    <title>Order of Payment</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                        }
                        th, td {
                            border: 1px solid black;
                            padding: 5px;
                            text-align: left;
                        }
                    </style>
                </head>
                <body>${receiptContent}</body>
            </html>
        `);
        printWindow.document.close();
        printWindow.focus();

        // Trigger the print dialog
        printWindow.print();
    },300);
}

// Function to convert numbers to words (simplified example)
function convertNumberToWords(amount) {
    const units = [
        '', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine',
        'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'
    ];
    const tens = [
        '', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'
    ];
    const thousands = [
        '', 'Thousand', 'Million', 'Billion'
    ];

    // Function to convert a number less than 1000 into words
    function convertToWords(num) {
        let word = '';
        if (num >= 100) {
            word += units[Math.floor(num / 100)] + ' Hundred ';
            num %= 100;
        }
        if (num > 10 && num < 20) {
            word += units[num] + ' ';
        } else {
            word += tens[Math.floor(num / 10)] + ' ';
            num %= 10;
            word += units[num] + ' ';
        }
        return word.trim();
    }

    // Split the amount into integer and decimal parts
    const [integerPart, decimalPart] = amount.toString().split('.');

    // Convert the integer part
    let integerWords = '';
    let num = parseInt(integerPart, 10);
    if (num === 0) {
        integerWords = 'Zero';
    } else {
        let i = 0;
        while (num > 0) {
            const part = num % 1000;
            if (part > 0) {
                integerWords = convertToWords(part) + ' ' + thousands[i] + ' ' + integerWords;
            }
            num = Math.floor(num / 1000);
            i++;
        }
    }

    // Convert the decimal part (if any)
    let decimalWords = '';
    if (decimalPart && parseInt(decimalPart, 10) > 0) {
        decimalWords = 'and ' + convertToWords(parseInt(decimalPart, 10)) + ' Cents';
    }

    // Combine the integer and decimal parts
    return `${integerWords.trim()} Pesos Only ${decimalWords}`.trim();
}
</script>

<div id="receiptTemplate" style="display: none;">
    <div style="font-family: Arial, sans-serif; width: 100%; max-width: 600px; margin: 0 auto; border: 1px solid black; padding: 20px;">
        <div style="text-align: center;">
            <img src="../../assets/img/mtfrbLogo.jpg" alt="Logo1" style="width: 60px; vertical-align: middle;">
            <span style="font-size: 16px; font-weight: bold;">Municipal Tricycle Franchising Regulatory Board - Lucban</span>
            <img src="/../../assets/img/sbLogo.png" alt="Logo2" style="width: 60px; vertical-align: middle;">
            <p style="margin: 0;">88 A. Racelis Ave, Lucban, Quezon</p>
        </div>
        <h2 style="text-align: center;">ORDER OF PAYMENT</h2>
        <p><strong>OR No:</strong> <span id="receiptNum"></span></p>
        <p><strong>Ticket No:</strong> <span id="ticketNumber"></span></p>
        <p><strong>Tricycle Franchise No:</strong> <span id="tfNumber"></span></p>
        <p><strong>Name:</strong> <span id="name"></span></p>
        <p><strong>Date:</strong> <span id="date"></span></p>
        <!--<p><strong>Violation Type:</strong> <span id="violationType"></span></p>-->

        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr>
                    <th style="border: 1px solid black; padding: 5px;">Nature of Collection</th>
                    <th style="border: 1px solid black; padding: 5px;">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border: 1px solid black; padding: 5px;" id="penaltyDescription"></td>
                    <td style="border: 1px solid black; padding: 5px;" id="penaltyCharged"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; text-align: left;" colspan="1"><strong>Total</strong></td>
                    <td style="border: 1px solid black; padding: 5px;" id="totalAmount"></td>
                </tr>
            </tbody>
        </table>
        <p><strong>Amount in Words:</strong> <span id="amountInWords"></span></p>
        <div style="display: flex; justify-content: right; text-align: center;">
         <div>
          <p>_________________</p>
        <p><strong>Signature</strong></p>
        </div>
         </div>
    </div>
</div>

   <!-- Bootstrap  dito yan sa baba bawal mabago-->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"  integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">

