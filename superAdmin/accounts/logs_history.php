
<?php 
    include "../include/headerAdmin.php";
    include "../include/navbarAdmin.php";
    include "function_accounts.php";
   
?>
<style>
    th, td {
        white-space: nowrap; /* Prevent wrapping */
        overflow: hidden; /* Hide overflowing content */
        text-overflow: ellipsis; /* Add ellipsis for overflowing text */
        position: relative; /* Required for positioning the tooltip */
    }

    .tooltip {
        visibility: hidden;
        position: absolute;
        background-color:#808080;
        color: #fff;
        text-align: center;
        border-radius: 5px;
        padding: 5px;
        z-index: 1;
        bottom: 100%; /* Position the tooltip above the text */
        left: 50%;
        transform: translateX(-50%);
        opacity: 0;
        transition: opacity 0.3s;
        width: 80px; /* Set a fixed width for the tooltip */
        max-width: 150px; /* Limit the maximum width */
        white-space: normal; /* Allow wrapping of long text */
        word-wrap: break-word; /* Break long words to fit inside */
    }

    td:hover .tooltip {
        visibility: visible;
        opacity: 1;
    }
</style>
          <!-- Content Wrapper -->
 <div id="content-wrapper" class="d-flex flex-column">
    
    <?php  include "../include/topbarAdmin.php"; ?>
    <!-- Main Content -->
    <div class="col-md-12" style="margin-left:20px">
        <h3 class="h3 mb-0 text-gray-800">Logs History</h3>
        <div class="page-wrapper" style="min-height: 548px; margin-left:-55px; ">
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
                            <!--<a id="printTableBtn" class="btn-filters" href="javascript:void(0);" data-bs-toggle="tooltip"
                                data-bs-placement="bottom" data-bs-original-title="Filter"
                                style="text-decoration: none;"> 
                                <i class="fas fa-print" style="margin-right:10px;"></i>Save and Print
                            </a>-->
                            </li>

                            <li>
                            <!--<a type="button" class="btn btn-primary" 
                                style="background-color: #2680C2; color: #fff; border: 1px solid #2680C2; box-shadow: inset 0 0 0 0 #fff; border-radius: 4px; transition: all 0.3s ease;"
                                href="addNew-applicant.php"
                                onmouseover="this.style.backgroundColor='#fff'; this.style.borderColor='#2680C2'; this.style.color='#2680C2'; this.style.boxShadow='inset 0 50px 0 0 #fff';"
                                onmouseout="this.style.backgroundColor='#2680C2'; this.style.borderColor='#2680C2'; this.style.color='#fff'; this.style.boxShadow='inset 0 0 0 0 #fff';">
                                <i class="fa fa-plus-circle me-2" aria-hidden="true"></i> Add New Applicant
                                </a>-->
                                 </li>
                            </ul>
                        </div> 
                    </div>
                    
                </div>
        <div class="container-fluid" style="margin-left:-10px;">
             <div class="row">
                <div class="col-sm-12"> <!-- Use full-width column -->
                    <div class="card-table">
                        <div class="card-body">
                            <div class="table-container">
                               <div class="table-responsive">
                                    <table class="table table-hover text-center" style="table-layout: fixed; width: 100%;">
                                        <thead class="thead-primary ">
                                            <tr role="row">
                                               <th style="width: 10%;">#</th>
                                                <th style="width: 15%;">Admin ID</th>
                                                <th style="width: 15%;">Username</th>
                                                <th style="width: 15%;">Account Type</th>
                                                <th style="width: 30%;">Action</th>
                                                <th style="width: 30%;">Timestamp</th>
                                              
                                          </tr></thead>
                                        <tbody id="table_body">
                                        <!-- pang load ng accounts table >
                                       <script src = ../assets/js/load_logs_history.js></script>-->
                                       <script>
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

    function fetchTableData(filters = {}, page = 1, pageSize = pageSize) {
        $.ajax({
            url: 'fetch_logs_history.php',
            type: 'GET',
            data: {...filters, page: page, pageSize: pageSize}, // Include page and pageSize in the request
            dataType: 'json',
            success: function(data) {
                var tableBody = $('#table_body');
                tableBody.empty();
                if (data.rows.length === 0) {
                    tableBody.append('<tr><td colspan="8" class="text-center">No account/s found</td></tr>');
                    return; // Exit the function if no data is found
                }
      
                var rowCount = (page - 1) * pageSize + 1; // Calculate row numbering based on page
                data.rows.forEach(function(row) {
                    var tableRow = `
                        <tr>
                            <td>${rowCount}</td>
                            <td>${row.user_id}</td>
                            <td>${row.username}</td>
                            <td>${row.account_type}</td>
                            <td data-fulltext="${row.action}" title="${row.action}"> ${row.action.length > 50 ? row.action.substring(0, 47) + '...' : row.action}</td>
                            <td>${row.date_time}</td>
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
            user_id: $("#user_id").val(),
            username: $("#username").val(),
            type_account: $("#type_account").val(), 
            login_status: $("#login_status").val()
        };
  
        currentPage = 1; // Reset to page 1 on new search
        // Fetch table data with the filters applied
        fetchTableData(currentFilters, currentPage, pageSize);
  
        // Close the sidebar
        $(".toggle-sidebar").removeClass("open-filter");
        $("body").removeClass("filter-opened");
    });
  
    // Handle the number of entries per page change
    $(document).on('change', 'select[name="DataTables_Table_0_length"]', function() {
        pageSize = parseInt($(this).val(), 10); // Update the stored page size
        fetchTableData(currentFilters, 1, pageSize); // Reset to page 1 on page size change
    });
  
    // Handle pagination clicks
    $(document).on('click', '#DataTables_Table_0_paginate .pagination li a', function(e) {
        e.preventDefault();
  
        var $this = $(this);
        if ($this.closest('li').hasClass('previous')) {
            currentPage = parseInt($('#DataTables_Table_0_paginate .pagination .active').text(), 10) - 1;
        } else if ($this.closest('li').hasClass('next')) {
            currentPage = parseInt($('#DataTables_Table_0_paginate .pagination .active').text(), 10) + 1;
        } else {
            currentPage = parseInt($this.text(), 10);
        }
  
        if (!isNaN(currentPage)) {
            fetchTableData(currentFilters, currentPage, pageSize);
        }
    });
    
     
   // Handle the reset filter button click
     $(".btn.btn-filters").on("click", function() {
        currentFilters = {}; // Clear the filter object
        currentPage = 1; // Reset to page 1
        pageSize = parseInt($('select[name="DataTables_Table_0_length"]').val(), 10); // Retain the selected page size

        // Clear the filter input fields
        $("#user_id, #username,  #type_account, #login_status").val('');

        // Fetch table data without filters
        fetchTableData(currentFilters, currentPage, pageSize);
    });
  
    // Initial load
    fetchTableData(currentFilters, currentPage, pageSize);

    // fetch data every 3 seconds
    setInterval(() => fetchTableData(currentFilters, currentPage, pageSize), 3000);

});

                                       </script>
                                        </tbody>
                                    </table>
                                    <div class="dataTables_length" id="DataTables_Table_0_length" >
                                                        <label>Show</label><label><select
                                                                name="DataTables_Table_0_length"
                                                                aria-controls="DataTables_Table_0"
                                                                class="custom-select custom-select-sm form-control form-control-sm"
                                                                style="width: auto; ">
                                                                
                                                                <option value="50">50</option>
                                                                <option value="100">100</option>
                                                            </select></label><label
                                                            style="margin-left:40px;">Entries</label>
                                                    </div>
                                                    <div class="dataTables_paginate paging_simple_numbers align-items-center"
                                                        id="DataTables_Table_0_paginate" style="margin-left:-150px;">
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
                    <h5>Search Account</h5>
                </div>
                
                <div class="sidebar-body">
                    <form id="filterForm" action="#" autocomplete="off">
                        <div class="accordion" id="accordionMain2">
                             <div class="col-lg-12 col-sm-12">
                                <div class="input-block mb-3">
                                    <label>Admin ID</label>
                                    <input type="text" class="form-control" id="user_id" placeholder="Username">
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-12">
                                <div class="input-block mb-3">
                                    <label>Account Type</label>
                                    <select class="form-control" id="type_account">
                                        <option value="">Select Account Type</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Super Admin">Super Admin</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12 col-sm-12">
                                <div class="input-block mb-3">
                                    <label>Username</label>
                                    <input type="text" class="form-control" id="username" placeholder="Username">
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
    <!-- /.container-fluid -->

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

       </script>

          <?php 
                  
                include "../../include/scripts.php"; 
                include "../include/scriptsAdmin.php";
                include "../include/footerAdmin.php";
          ?>

          
          <!-- Bootstrap  dito yan sa baba bawal mabago-->
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"  integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
       </script>

