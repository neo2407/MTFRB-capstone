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


<div id="preloader">
            <img src="../../assets/img/output-onlinegiftools.gif" alt="Loading...">
            <p class="loading-text">Just a moment...</p>
</div>
<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
    
    <?php  include "../include/topbarAdmin.php"; ?>
    
    <!-- Main Content -->
    <div class="col-md-12" style="margin-left:20px">
        <h3 class="h3 mb-0 text-gray-800">Dropped Franchise List</h3>
        <div class="page-wrapper" style="min-height: 548px; margin-left:-25px; ">
            <div class="content container-lg">
                <div class="page-header">
                    <div class="content-page-header">
                        <div class="list-btn">
                            <ul class="filter-list">
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
                    </div>
                    
                </div>

                <div class="container-fluid" style="margin-left:12px">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-table">
                                <div class="card-body">
                                    <div class="table-container">
                                        <div class="table-responsive">
                                            <table class="table table-hover text-center">
                                                <thead id="table_header" class="thead-light">
                                                    <tr role="row">
                                                        <th scope="col">#</th>
                                                        <th scope="col">TFno</th>
                                                        <th scope="col">First Name</th>
                                                        <th scope="col">Last Name</th>
                                                        <th scope="col">Reason For Dropping</th>
                                                        <th scope="col">Dropping Date</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="table_body">
                                                    <!-- load franchise applicant table
                                                    <script src = ../assets/js/load_table_applicant.js></script>-->

                                                </tbody>
                                            </table>
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
        </div>

        <div class="toggle-sidebar ledge">
            <div class="sidebar-layout-filter">
            <div class="text-right" style="margin-top: 20px; margin-right: 10px;">
                    <a href="#" class="sidebar-close" style="font-size: 1.5em; padding: 10px;">
                        <i class="fa-regular fa-circle-xmark"></i>
                    </a>
                </div>
                <div class="sidebar-header ledge">
                    <h5>Search Dropped Franchise</h5>
                </div>
                
                <div class="sidebar-body">
                    <form id="filterForm" action="#" autocomplete="off">
                        <div class="accordion" id="accordionMain2">
                            <div class="col-lg-12 col-sm-12">
                                <div class="input-block mb-3">
                                    <label>Month</label>
                                    <select class="form-control" id="month">
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
                                </div>
                            </div>

                            <div class="col-lg-12 col-sm-12">
                                <div class="input-block mb-3">
                                    <label>Tricycle Franchise #</label>
                                    <input type="text" class="form-control" id="id" placeholder="TFno">
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

<script>
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
    printWindow.document.write('<h1>Dropped Franchise </h1>');
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

<script src = ../assets/js/load_dropped_franchise.js></script>
<!-- pre-loader -->
<style>
  /* Preloader */
#preloader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.9); 
    z-index: 9999; 
    display: flex;
    justify-content: center;
    align-items: center;
}

#preloader img {
    width: 75px; 
    height: auto;
}



.loading-text {
    font-family: 'Poppins';
    font-size: 20px; 
    color: #555;
    margin: 0;
    letter-spacing: 1px;
    text-transform: uppercase;
    animation: fadeIn 1.2s infinite alternate;
}

@keyframes fadeIn {
    0% {
        opacity: 0.3;
    }
    100% {
        opacity: 1;
    }
}



</style>

<script>
  
window.addEventListener('load', function() {
    const preloader = document.getElementById('preloader');
    const navbar = document.getElementById('navbar');

    setTimeout(() => {
        preloader.style.display = 'none';
        //navbar.style.display = 'block'; 
    }, 1000); 
});
</script>

<?php include "../../include/scripts.php"; 
      include "../../include/modal_viewDetails.php";
      include "../include/scriptsAdmin.php";
      include "../include/footerAdmin.php";
?>


<!-- Bootstrap  dito yan sa baba bawal mabago-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"  integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
</script>

