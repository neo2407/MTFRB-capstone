<?php
    include "../include/headerAdmin.php";
    include "../include/navbarAdmin.php";
    
?> 

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
    
    <?php  include "../include/topbarAdmin.php"; ?>
    
    <!-- Main Content -->
    <div class="col-md-12" style="margin-left:20px">
        <h1 class="h3 mb-0 text-gray-800" >Tricycle Operators</h1>
        <div class="page-wrapper" style="min-height: 548px; margin-left:-25px; ">
            <div class="content container-lg">
                <div class="page-header">
                    <div class="content-page-header">
                        <div class="list-btn">
                            <ul class="filter-list">
                            <li>
                             <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_operator_Modal"
                                style="background-color: #2680C2; color: #fff; border: 1px solid #2680C2; box-shadow: inset 0 0 0 0 #fff; border-radius: 4px; transition: all 0.3s ease;"
                                onmouseover="this.style.backgroundColor='#fff'; this.style.borderColor='#2680C2'; this.style.color='#2680C2'; this.style.boxShadow='inset 0 50px 0 0 #fff';"
                                onmouseout="this.style.backgroundColor='#2680C2'; this.style.borderColor='#2680C2'; this.style.color='#fff'; this.style.boxShadow='inset 0 0 0 0 #fff';">
                                <i class="fa fa-plus-circle me-2" aria-hidden="true"></i> Add Tricycle Operator
                                </a>
                            </li>
                            
                            <li>
                                <a class="btn btn-filters w-auto popup-toggle" data-bs-toggle="tooltip"
                                data-bs-placement="bottom" data-bs-original-title="Filter">
                                <i class="fas fa-sliders-h" style="margin-right:10px;"></i>Filter
                                </a>
                            </li>
                             <li>
                                <a class="btn btn-filters" data-bs-toggle="tooltip"
                                data-bs-placement="bottom" data-bs-original-title="Filter">
                                <i class="fa-solid fa-rotate-right" style="margin-right:10px;"></i>Reset Filter
                                </a>
                            </li>
                            <li>
                            <a id="printTableBtn" class="btn-filters" href="javascript:void(0);" data-bs-toggle="tooltip"
                                data-bs-placement="bottom" data-bs-original-title="Filter"
                                style="text-decoration: none;"> <!-- Inline CSS to remove underline -->
                                <i class="fas fa-print" style="margin-right:10px;"></i>Save and Print
                            </a>
                            </li>
    
                            </ul>
                          
                        </div> 
                        <div class="dropdown">
                           <!--Send Renewal Reminder Button-->
                            <button id="scanQr" type="button" class="btn btn-primary dropdown-toggle" onclick="toggleMonthDropdown()">
                                <i class="fas fa-paper-plane"></i> Send Renewal Reminder
                            </button>
                        
                           <!-- Dropdown for Month Selection -->
                            <div id="monthDropdown" class="dropdown-menu p-3" style="display: none;">
                                <select id="monthSelect" class="form-control mb-2">
                                    <option value="">Select Month</option>
                                    <option value="jan_operators">January</option>
                                    <option value="feb_operators">February</option>
                                    <option value="march_operators">March</option>
                                    <option value="apr_operators">April</option>
                                    <option value="may_operators">May</option>
                                    <option value="jun_operators">June</option>
                                    <option value="jul_operators">July</option>
                                    <option value="aug_operators">August</option>
                                    <option value="sep_operators">September</option>
                                    <option value="oct_operators">October</option>
                                </select>
                                <button id="sendSmsButton" class="btn btn-success" onclick="sendSms()">Send SMS</button>
                            </div>
                            
                            <script>
                            // Function to toggle the dropdown visibility
                            function toggleMonthDropdown() {
                                const dropdown = document.getElementById('monthDropdown');
                                dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
                            }
                            
                            // Function to send SMS based on the selected table
                            function sendSms() {
                                const tableName = document.getElementById('monthSelect').value;
                            
                                if (!tableName) {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'No Month Selected',
                                        text: 'Please select a valid month to send SMS.',
                                        confirmButtonText: 'OK'
                                    });
                                    return;
                                }
                            
                                // Show a loading message
                                Swal.fire({
                                    title: 'Sending SMS...',
                                    text: 'Please wait while SMS messages are being sent.',
                                    icon: 'info',
                                    allowOutsideClick: false,
                                    showConfirmButton: false,
                                    willOpen: () => {
                                        Swal.showLoading();
                                    }
                                });
                            
                                fetch('sendBulksms-semaphore.php', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({ table: tableName })
                                })
                                .then(response => response.text()) // Get raw response text
                                .then(text => {
                                    try {
                                        const data = JSON.parse(text); // Attempt to parse JSON
                                        if (data.success) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'SMS Sent!',
                                                text: data.message || 'SMS sent successfully to all operators.'
                                            });
                                        } else {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Failed to Send SMS',
                                                text: data.message || 'There was an issue sending SMS to operators.'
                                            });
                                        }
                                    } catch (error) {
                                        console.error('Invalid JSON:', text); // Log the raw response for debugging
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: 'Unexpected response from the server. Please check the server logs.'
                                        });
                                    }
                                })
                                .catch(error => {
                                    console.error('Fetch Error:', error);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: error.message || 'An error occurred while processing your request.'
                                    });
                                });
                            }
                            </script>

                    </div>
                    
                </div>

                <div class="container-fluid" style="margin-left:12px; margin-top:10px;" >
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-table">
                                <div class="card-body">
                                    <div class="table-container">
                                        <div class="table-responsive">
                                            <table class="table table-hover text-center">
                                            <thead id="table_header" class="thead">
                                                <tr role="row">
                                                    <th>#</th>
                                                    <th>Franchise Number</th>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Body Built</th>
                                                    <th>Banned</th>
                                                    <th>Status</th>
                                                    <th>Expiry Date</th>
                                                    <th class="no-sort">Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody id="table_body">
                                                    <!-- load franchise applicant table
                                                    <script src = ../assets/js/load_table_applicant.js></script>-->

                                                </tbody>
                                            </table>       
                                        </div>
                                        <div class="dataTables_length" id="DataTables_Table_0_length">
                                                        <label>Show</label><label><select
                                                                name="DataTables_Table_0_length"
                                                                aria-controls="DataTables_Table_0"
                                                                class="custom-select custom-select-sm form-control form-control-sm">
                                                                <option value="10">10</option>
                                                                <option value="25">25</option>
                                                                <option value="50">50</option>
                                                                <option value="100">100</option>
                                                            </select></label><label
                                                            style="margin-left: 10px;">Entries</label>
                                                    </div>
                                                    <div class="dataTables_paginate paging_simple_numbers align-items-center"
                                                        id="DataTables_Table_0_paginate">
                                                        <ul class="pagination">
                                                            <li class="paginate_button page-item previous disabled"
                                                                id="DataTables_Table_0_previous"><a href="#"
                                                                    aria-controls="DataTables_Table_0" data-dt-idx="0"
                                                                    tabindex="0" class="page-link"><i
                                                                        class="fa fa-angle-double-left me-2"></i>
                                                                    Previous</a></li>
                                                            <li class="paginate_button page-item active"><a href="#"
                                                                    aria-controls="DataTables_Table_0" data-dt-idx="1"
                                                                    tabindex="0" class="page-link">1</a></li>
                                                            <li class="paginate_button page-item next disabled"
                                                                id="DataTables_Table_0_next"><a href="#"
                                                                    aria-controls="DataTables_Table_0" data-dt-idx="2"
                                                                    tabindex="0" class="page-link">Next <i
                                                                        class=" fa fa-angle-double-right ms-2"></i></a>
                                                            </li>
                                                        </ul>
                                                  </div>
                                    </div>
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
                    <h5>Search Operator</h5>
                </div>
                
                <div class="sidebar-body">
                    <form id="filterForm" action="#" autocomplete="off">
                        <div class="accordion" id="accordionMain2">
                            <div class="col-lg-12 col-sm-12">
                                <div class="input-block mb-3">
                                    <label>Months</label>
                                    <select class="form-control" id="month">
                                            <option value="">All Months</option>
                                            <option value="jan_operators">January</option>
                                            <option value="feb_operators">February</option>
                                            <option value="march_operators">March</option>
                                            <option value="apr_operators">April</option>
                                            <option value="may_operators">May</option>
                                            <option value="jun_operators">June</option>
                                            <option value="jul_operators">July</option>
                                            <option value="aug_operators">August</option>
                                            <option value="sep_operators">September</option>
                                            <option value="oct_operators">October</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12 col-sm-12">
                                <div class="input-block mb-3">
                                    <label>Tricycle Franchise #</label>
                                    <input type="text" class="form-control" id="TFno" placeholder="TFno">
                                </div>
                            </div>

                            <div class="col-lg-12 col-sm-12">
                                <div class="input-block mb-3">
                                    <label>Franchise Status</label>
                                    <select class="form-control" id="status">
                                        <option value="">Select Franchise Status</option>
                                        <option value="Pending for Renewal">Pending for Renewal</option>
                                        <option value="Renewed">Renewed</option>
                                        <option value="Expired">Expired</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12 col-sm-12">
                                <div class="input-block mb-3">
                                    <label>Tricycle Type</label>
                                    <select class="form-control" id="tricType">
                                        <option value="">Select Type</option>
                                        <option value="Tricycle">Tricycle</option>
                                        <option value="Tricycle(Back-to-Back)">Tricycle(Back-to-Back)</option>
                                        <option value="Tuktuk">Tuktuk</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12 col-sm-12">
                                <div class="input-block mb-3">
                                    <label>Day Banned</label>
                                    <select class="form-control" id="dayBan">
                                        <option value="">Select Day</option>
                                        <option value="Monday">Monday</option>
                                        <option value="Tuesday">Tuesday</option>
                                        <option value="Wednesday">Wednesday</option>
                                        <option value="Thursday">Thursday</option>
                                        <option value="Friday">Friday</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12 col-sm-12">
                                <div class="input-block mb-3">
                                    <label>TODA</label>
                                    <select class="form-control" id="toda">
                                         <option value="">Select TODA</option>
                                        <option value="ASIT">ASIT</option>
                                        <option value="CALMAR">CALMAR</option>
                                        <option value="CSIDE">CSIDE</option>
                                        <option value="FABIE">FABIE</option>
                                        <option value="GSLV">GSLV</option>
                                        <option value="KILIB">KILIB</option>
                                        <option value="KULAPI">KULAPI</option>
                                        <option value="LRE 200">LRE 200</option>
                                        <option value="LUCBAN">LUCBAN</option>
                                        <option value="MAKATC">MAKATC</option>
                                        <option value="MARKET">MARKET</option>
                                        <option value="MMD">MMD</option>
                                        <option value="MMDT">MMDT</option>
                                        <option value="MMK">MMK</option>
                                        <option value="MMONTE">MMONTE</option>
                                        <option value="NAGSIMANO">NAGSIMANO</option>
                                        <option value="ONGVILLE">ONGVILLE</option>
                                        <option value="PALOLA">PALOLA</option>
                                        <option value="PECTO">PECTO</option>
                                        <option value="PEL">PEL</option>
                                        <option value="PEL SERVICE">PEL SERVICE</option>
                                        <option value="PIIS">PIIS</option>
                                        <option value="PSL">PSL</option>
                                        <option value="SAMBAT">SAMBAT</option>
                                        <option value="SLSU">SLSU</option>
                                        <option value="SLSU AYUTI">SLSU AYUTI</option>
                                        <option value="TBT">TBT</option>
                                        <option value="TMG">TMG</option>
                                        <option value="TUKTUK B.">TUKTUK B.</option>
                                        <option value="UNAVP">UNAVP</option>
                                    </select>
                                </div>
                            </div>
                          

                           
                            <div class="col-lg-12 col-sm-12">
                                <div class="input-block mb-3">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" id="first_name" placeholder="First Name">
                                </div>
                            </div>

                            <div class="col-lg-12 col-sm-12">
                                <div class="input-block mb-3">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" id="last_name" placeholder="Last Name">
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

<script src = ../assets/js/load_franchiseHolders.js></script>
<script>
    
function confirmDrop(id, TFno) {
    // First confirmation popup
    Swal.fire({ 
        title: 'Are you sure?',
        text: `Do you really want to drop the franchise with TFno: ${TFno}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, drop it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // AJAX call to drop the franchise
            $.ajax({
                url: 'drop_franchise.php',
                type: 'POST',
                data: { 
                    id: id, 
                    drop_franchise: 'Drop', 
                    TFno: TFno // Ensure TFno is passed
                },
                success: function(response) {
                    Swal.fire(
                        'Dropped!',
                        `The franchise with TFno: ${TFno} has been dropped successfully.`,
                        'success'
                    );
                },
                error: function() {
                    Swal.fire(
                        'Error!',
                        'An error occurred while dropping the franchise.',
                        'error'
                    );
                }
            });
        }
    });
}
</script>

<script>
    function confirmUnDropped(id, TFno) {
        console.log('id:', id); // Log the id value
        console.log('TFno:', TFno); // Log the TFno value

        Swal.fire({
            title: 'Are you sure?',
            text: `Do you really want to undrop this franchise? ${TFno}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, undrop it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'undropped_franchise.php',
                    type: 'POST',
                    data: { 
                        id: id, 
                        drop_franchise: 'NULL', // Change from 'Drop' to 'NULL'
                        TFno: TFno
                    },
                    success: function(response) {
                        Swal.fire(
                            'Undropped!',
                            `The franchise with TFno: ${TFno} has been undropped successfully.`,
                            'success'
                        ).then(() => {
                            // Reload the page or update the table
                            location.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire(
                            'Error!',
                            'There was an error undropping the franchise.',
                            'error'
                        );
                    }
                });
            }
        });
    }
</script>


<script>
   // Store original table HTML
var originalTableHeader = $('#table_header').html();                                                                                                        
var originalTableBody = $('#table_body').html();
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
    printWindow.document.write('body { font-family: Arial, sans-serif; margin: 10px; }');
    printWindow.document.write('.header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }');
    printWindow.document.write('.header img { height: 70px;  }'); // Shift logos upward
    printWindow.document.write('.header .text { text-align: center; flex: 1; }'); // Center the text
    printWindow.document.write('.title { text-align: center; font-size: 16px; font-weight: bold; margin-bottom: 20px; }'); // Style for the report title
    printWindow.document.write('table { width: 100%; border-collapse: collapse; }');
    printWindow.document.write('th, td { border: 1px solid black; padding: 8px; text-align: left; }');
    printWindow.document.write('th { background-color: #f2f2f2; }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');

    // Add the header with the logos and title
    printWindow.document.write('<div class="header">');
    printWindow.document.write('<img src="/../../assets/img/mtfrbLogo.png" alt="Left Logo">'); 
    printWindow.document.write('<div class="text">');
    printWindow.document.write('<h3>Municipal Tricycle Franchising Regulatory Board - Lucban</h3>');
    printWindow.document.write('<p>88 A. Racelis Ave, Lucban, 4328 Quezon</p>');
    printWindow.document.write('</div>');
    printWindow.document.write('<img src="../../assets/img/sbLogo.jpg" alt="Right Logo">'); 
    printWindow.document.write('</div>');

    // Add the report title
    printWindow.document.write('<div class="title">Master List of Tricycle Franchise</div>');

    // Add the table
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

    <?php 
        include "add_operator.php";  
        include "../include/scripts.php"; 
        include "modal_viewDetailsHolders.php";
        include "../include/scriptsAdmin.php";
        include "../include/footerAdmin.php";
    ?>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
      <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>'
   
</div>