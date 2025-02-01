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
    
    <?php  include "../include/topbarAdmin.php"; ?>
    
    <!-- Main Content -->
    <div class="col-md-12" style="margin-left:20px">
        <h3 class="h3 mb-0 text-gray-800">Driver Ratings</h3>
        <div class="page-wrapper" style="min-height: 548px; margin-left:-25px; ">
            <div class="content container-lg">
                <div class="page-header">
                    <div class="content-page-header">
                        <div class="list-btn">
                            <ul class="filter-list">
                            <li>
                                <a class="btn btn-filters w-auto popup-toggle" data-bs-toggle="tooltip"
                                data-bs-placement="bottom" data-bs-original-title="Filter">
                                <i class="fas fa-sliders-h" style="margin-right:10px;"></i>Filter Driver Ratings
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
                                style="text-decoration: none;"> 
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
                                                    <thead id="table_header" class="thead-light ">
                                                        <tr role="row">
                                                        <th scope="col">#</th>
                                                        <th scope="col">Franchise Number</th>
                                                            <th scope="col">Stars</th>
                                                            <th scope="col">Comments</th>
                                                            <th scope="col">Date Rated</th>
                                                            <th scope="col">Action</th>
                                                            
                                                    </tr></thead>
                                                    <tbody id="table_body">
                                                    <!-- pang load ng table of operators with complaints >
                                                        <script src = ../assets/js/load_table_complaints.js></script>-->
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
                                                
                                                
                                                
                                                  $(document).ready(function() {
                                                
                                                    let currentFilters = {}; // Store the filters to persist across pagination
                                                    let currentPage = 1; // Store the current page number
                                                    let pageSize = parseInt($('select[name="DataTables_Table_0_length"]').val(), 10); // Store the selected page size
                                                
                                                    function fetchTableData(filters = {}, page = 1, pageSize = 10) {
                                                        $.ajax({
                                                            url: 'fetch_driverRatings.php',
                                                            type: 'GET',
                                                            data: { ...filters, page: page, pageSize: pageSize }, // Include page and pageSize in the request
                                                            dataType: 'json',
                                                            success: function(data) {
                                                                var tableBody = $('#table_body');
                                                                tableBody.empty();
                                                
                                                                if (data.rows.length === 0) {
                                                                    tableBody.append('<tr><td colspan="7" class="text-center">No ratings found</td></tr>');
                                                                    return; // Exit the function if no data is found
                                                                }
                                                
                                                                var rowCount = (page - 1) * pageSize + 1; // Calculate row numbering based on page
                                                                data.rows.forEach(function(row) {
                                                                    var tableRow = `
                                                                        <tr>
                                                                            <td>${rowCount}</td>
                                                                            <td>${row.TFno}</td>
                                                                            <td>${row.stars}</td>
                                                                            <td>${row.comments}</td>
                                                                            <td>${row.date_rated}</td>
                                                                            <td>
                                                                                <a href="javascript:void(0);" onclick="confirmDelete(${row.id})"  class="btn btn-greys me-2">
                                                                                    <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                                                                </a>
                                                                            </td>
                                                                        </tr>`;
                                                                    tableBody.append(tableRow);
                                                                    rowCount++; // Increment the row number
                                                                });
                                                
                                                                // Update pagination controls
                                                                updatePaginationControls(data.totalPages, page);
                                                            },
                                                            error: function(xhr, status, error) {
                                                                console.error("AJAX Error: " + status + " " + error);
                                                                console.error("Response: " + xhr.responseText);
                                                            }
                                                        });
                                                    }
                                                
                                                    function updatePaginationControls(totalPages, currentPage) {
                                                        var pagination = $('#DataTables_Table_0_paginate .pagination');
                                                        pagination.empty();
                                                
                                                        // Previous button
                                                        if (currentPage > 1) {
                                                            pagination.append('<li class="paginate_button page-item previous"><a href="#" class="page-link"><i class="fa fa-angle-double-left me-2"></i> Previous</a></li>');
                                                        } else {
                                                            pagination.append('<li class="paginate_button page-item previous disabled"><a href="#" class="page-link"><i class="fa fa-angle-double-left me-2"></i> Previous</a></li>');
                                                        }
                                                
                                                        // Page numbers
                                                        for (var i = 1; i <= totalPages; i++) {
                                                            if (i === currentPage) {
                                                                pagination.append(`<li class="paginate_button page-item active"><a href="#" class="page-link">${i}</a></li>`);
                                                            } else {
                                                                pagination.append(`<li class="paginate_button page-item"><a href="#" class="page-link">${i}</a></li>`);
                                                            }
                                                        }
                                                
                                                        // Next button
                                                        if (currentPage < totalPages) {
                                                            pagination.append('<li class="paginate_button page-item next"><a href="#" class="page-link">Next <i class="fa fa-angle-double-right ms-2"></i></a></li>');
                                                        } else {
                                                            pagination.append('<li class="paginate_button page-item next disabled"><a href="#" class="page-link">Next <i class="fa fa-angle-double-right ms-2"></i></a></li>');
                                                        }
                                                    }
                                                
                                                    // Handle the filter form submission
                                                    $("button[name='search']").on("click", function(e) {
                                                        e.preventDefault();
                                                
                                                        // Collect filter values
                                                        currentFilters = {
                                                            TFno: $("#TFno").val(),
                                                            stars: $("#stars").val(),
                                                           
                                                        };
                                                
                                                        currentPage = 1; // Reset to page 1 when applying new filters
                                                        fetchTableData(currentFilters, currentPage, pageSize); // Fetch table data with the filters 
                                                
                                                        // Close the sidebar
                                                        $(".toggle-sidebar").removeClass("open-filter");
                                                        $("body").removeClass("filter-opened");
                                                    });
                                                
                                                    // Handle the number of entries per page change
                                                    $(document).on('change', 'select[name="DataTables_Table_0_length"]', function() {
                                                        pageSize = parseInt($(this).val(), 10); // Update the global pageSize variable
                                                        currentPage = 1; // Reset to page 1 when changing the page size
                                                        fetchTableData(currentFilters, currentPage, pageSize);
                                                    });
                                                
                                                    // Handle pagination 
                                                    $(document).on('click', '#DataTables_Table_0_paginate .pagination li a', function(e) {
                                                        e.preventDefault();
                                                
                                                        var $this = $(this);
                                                        var page = parseInt($this.text(), 10);
                                                
                                                        if ($this.closest('li').hasClass('previous')) {
                                                            page = currentPage - 1;
                                                        } else if ($this.closest('li').hasClass('next')) {
                                                            page = currentPage + 1;
                                                        }
                                                
                                                        if (!isNaN(page) && page !== currentPage) {
                                                            currentPage = page; // Update the current page
                                                            fetchTableData(currentFilters, currentPage, pageSize);
                                                        }
                                                    });
                                                
                                                 // Handle the reset filter button click
                                                     $(".btn.btn-filters").on("click", function() {
                                                        currentFilters = {}; // Clear the filter object
                                                        currentPage = 1; // Reset to page 1
                                                        pageSize = parseInt($('select[name="DataTables_Table_0_length"]').val(), 10); // Retain the selected page size
                                                
                                                        // Clear the filter input fields
                                                        $(" #TFno, #stars").val('');
                                                
                                                        // Fetch table data without filters
                                                        fetchTableData(currentFilters, currentPage, pageSize);
                                                    });
                                                    
                                                    // Initial load of applicants
                                                    fetchTableData(currentFilters, currentPage, pageSize);
                                                
                                                    // Refresh the table data every 3 seconds
                                                    setInterval(() => fetchTableData(currentFilters, currentPage, pageSize), 3000);
                                                });
                                                
                                                 function confirmDelete(id) {
                                                    // Use SweetAlert for confirmation
                                                    Swal.fire({
                                                        title: 'Are you sure?',
                                                        text: 'Do you want to delete this rating?',
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#3085d6',
                                                        cancelButtonColor: '#d33',
                                                        confirmButtonText: 'Yes, delete it!',
                                                        cancelButtonText: 'Cancel'
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            $.ajax({
                                                                url: 'delete_ratings.php',
                                                                type: 'POST',
                                                                data: { id: id },
                                                                dataType: 'json',
                                                                success: function(response) {
                                                                    if (response.success) {
                                                                        Swal.fire({
                                                                            title: 'Deleted!',
                                                                            text: response.message,
                                                                            icon: 'success',
                                                                            confirmButtonText: 'OK'
                                                                        });
                                                                        fetchTableData(); // Refresh the table data
                                                                    } else {
                                                                        Swal.fire({
                                                                            title: 'Error!',
                                                                            text: 'Error deleting rating: ' + response.message,
                                                                            icon: 'error',
                                                                            confirmButtonText: 'OK'
                                                                        });
                                                                    }
                                                                },
                                                                error: function() {
                                                                    Swal.fire({
                                                                        title: 'Error!',
                                                                        text: 'Error processing request.',
                                                                        icon: 'error',
                                                                        confirmButtonText: 'OK'
                                                                    });
                                                                }
                                                            });
                                                        }
                                                    });
                                                }
                                                </script>
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
                    <h5>Seach Driver Ratings</h5>
                </div>
                
                <div class="sidebar-body">
                    <form id="filterForm" action="#" autocomplete="off">
                        <div class="accordion" id="accordionMain2">
                            
                            
                            <div class="col-lg-12 col-sm-12">
                                <div class="input-block mb-3">
                                    <label>Franchise No</label>
                                    <input type="text" class="form-control" name="TFno" id="TFno" placeholder="Franchise No">
                                </div>
                            </div>

                            <div class="col-lg-12 col-sm-12">
                                <div class="input-block mb-3">
                                    <label>Stars</label>
                                    <select class="form-control"  name="stars" id="stars">
                                        <option value="">Select Rating</option>
                                        <option value="1">⭐ 1 - Poor</option>
                                        <option value="2">⭐⭐ 2 - Fair</option>
                                        <option value="3">⭐⭐⭐ 3 - Good</option>
                                        <option value="4">⭐⭐⭐⭐ 4 - Very Good</option>
                                        <option value="5">⭐⭐⭐⭐⭐ 5 - Excellent</option>
                                    </select>
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
    printWindow.document.write('<h1>Driver Ratings</h1>');
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
<!--<script src = ../assets/js/load_operatorsComplaint.js></script>-->


<?php include "../../include/scripts.php"; 
      include "../../include/modal_viewDetails.php";
      include "../include/scriptsAdmin.php";
      include "../include/footerAdmin.php";
?>


<!-- Bootstrap  dito yan sa baba bawal mabago-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"  integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
</script>

