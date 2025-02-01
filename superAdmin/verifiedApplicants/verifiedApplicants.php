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

/* Custom styling for SweetAlert2 popup */
.swal2-popup-custom {
    width: 500px; /* Adjust the width as needed */
}

/* Styling for the input field */
.swal2-input-custom {
    width: 100%;
    font-size:18px;
}

/* Ensure the error message wraps correctly */
.swal2-validation-message {
    font-size: 14px;
    white-space: normal; /* Allow text to wrap */
    text-align: center;    /* Align text to the left */
    width: 80%;
    margin-left:40px;
}


</style>

          <!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
    
    <?php  include "../include/topbarAdmin.php"; ?>
    <!-- Main Content -->
    <div class="col-md-12" style="margin-left:20px">
        <h3 class="h3 mb-0 text-gray-800">Verified Franchise Applicants</h3>
        <div class="page-wrapper" style="min-height: 548px; margin-left:-25px; ">
            <div class="content container-lg">
                <div class="page-header">
                    <div class="content-page-header">
                        <div class="list-btn">
                            <ul class="filter-list">
                            <li>
                                <a class="btn btn-filters w-auto popup-toggle" data-bs-toggle="tooltip"
                                data-bs-placement="bottom" data-bs-original-title="Filter">
                                <i class="fas fa-sliders-h" style="margin-right:10px;"></i>Filter Applicant
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

        
        <div class="container-fluid" style="margin-left:20px">
             <div class="row">
                <div class="col-sm-12"> <!-- Use full-width column -->
                    <div class="card-table">
                        <div class="card-body">
                            <div class="table-container">
                                <div class="table-responsive">
                                    <table class="table table-hover text-center">
                                        <thead id="table_header" class="thead-light ">
                                            <tr role="row">
                                            <th id="select-column-header" style="display: none;">Selected</th>
                                            <th scope="col">#</th>
                                              <th scope="col">ID</th>
                                              <th scope="col">First Name</th>
                                              <th scope="col">Last Name</th>
                                              <th scope="col">Application Date</th>
                                              <th scope="col">Interview Schedule</th>
                                              <th scope="col">Interview Status</th>
                                              <th scope="col">Payment Status</th>
                                              <th scope="col">Action</th>
                                          </tr></thead>
                                        <tbody id="table_body">
                                        <!-- pang load ng franchise holders >
                                            <script src = ../assets/js/load_verified_applicants.js></script>-->
                                            <script>
                                                
                                                var selectedApplicantIds = [];
                                                
                                                function formatDate(dateTimeStr) {
                                                  if (!dateTimeStr) return '';
                                                  const options = {
                                                    year: 'numeric',
                                                    month: 'numeric',
                                                    day: 'numeric',
                                                    hour: 'numeric',
                                                    minute: 'numeric',
                                                    hour12: true,
                                                  };
                                                  return new Date(dateTimeStr).toLocaleString('en-US', options);
                                                }
                                                
                                                function toggleRowSelection(id, row, event) {
                                                  // Ensure that the dropdown selection doesn't trigger row selection or check icon display
                                                  if ($(event.target).is('select') || $(event.target).closest('select').length > 0) {
                                                    return; // Ignore clicks on dropdowns
                                                  }
                                                
                                                  var isSelected = $(row).hasClass('selected-row');
                                                
                                                  // Deselect all rows and clear selection if not already selected
                                                  selectedApplicantIds = [];
                                                  $('#table_body tr').removeClass('selected-row');
                                                  $('.check-icon').hide();
                                                
                                                  if (!isSelected) {
                                                    // Select the clicked row
                                                    selectedApplicantIds.push(id);
                                                    $(row).addClass('selected-row');
                                                    $(row).find('.check-icon').show();
                                                  }
                                                
                                                  // Ensure the "Grant Franchise" button only shows when at least one row is selected
                                                  if (selectedApplicantIds.length > 0) {
                                                    $('#grantFranchiseBtn').fadeIn(); // Show the button
                                                  } else {
                                                    $('#grantFranchiseBtn').fadeOut(); // Hide the button
                                                  }
                                                
                                                  console.log('Selected Applicant ID:', selectedApplicantIds);
                                                }
                                                
                                                // Ensure initial visibility state on page load
                                                $(document).ready(function () {
                                                  $('#grantFranchiseBtn').hide(); // Hide the button initially
                                                  updateSelectColumnVisibility(); // Adjust select column visibility
                                                });
                                                
                                                // Function to show or hide the "Select" column based on selected rows
                                                function updateSelectColumnVisibility() {
                                                  if (selectedApplicantIds.length > 0) {
                                                    // Show the "Select" column
                                                    $('#select-column-header').show();
                                                    $('#table_body td.select-column').show();
                                                  } else {
                                                    // Hide the "Select" column
                                                    $('#select-column-header').hide();
                                                    $('#table_body td.select-column').hide();
                                                  }
                                                }
                                                
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
                                                    url: 'fetch_verified_applicant.php',
                                                    type: 'GET',
                                                    data: {...filters, page: page, pageSize: pageSize}, // Include page and pageSize in the request
                                                    success: function(data) {
                                                      var tableBody = $('#table_body');
                                                      tableBody.empty();
                                                    
                                                      if (data.rows.length === 0) {
                                                        tableBody.append('<tr><td colspan="7" class="text-center">No applicant/s found</td></tr>');
                                                        return;
                                                      }
                                                    
                                                      var rowCount = (page - 1) * pageSize + 1;
                                                      data.rows.forEach(function(row) {
                                                        var isSelected = selectedApplicantIds.includes(row.id); // Check if the row is selected
                                                        var tableRow = `
                                                          <tr onclick="toggleRowSelection(${row.id}, this, event)" class="${isSelected ? 'selected-row' : ''}">
                                                            <td class="select-column" style="display: ${selectedApplicantIds.length > 0 ? '' : 'none'};">
                                                              <i class="fa-solid fa-check check-icon" style="display: ${isSelected ? '' : 'none'};"></i>
                                                            </td>
                                                            <td>${rowCount}</td>
                                                            <td>${row.id}</td>
                                                            <td>${row.first_name}</td>
                                                            <td>${row.last_name}</td>
                                                            <td>${row.applicationDate}</td>
                                                            <td>${row.interview_sched}</td>
                                                            <td>
                                                              <select onchange="updateInterviewStatus(${row.id}, this.value)">
                                                                <option value="Pending" ${row.interviewStatus === 'Pending' ? 'selected' : ''}>Pending</option>
                                                                <option value="Done" ${row.interviewStatus === 'Done' ? 'selected' : ''}>Done</option>
                                                                <option value="Missed" ${row.interviewStatus === 'Missed' ? 'selected' : ''}>Missed</option>
                                                              </select>
                                                            </td>
                                                            <td>
                                                              <select onchange="updatePaymentStatus(${row.id}, this.value)">
                                                                <option value="Pending" ${row.paymentStatus === 'Pending' ? 'selected' : ''}>Pending</option>
                                                                <option value="Paid" ${row.paymentStatus === 'Paid' ? 'selected' : ''}>Paid</option>
                                                              </select>
                                                            </td>
                                                            <td>
                                                              <a href="edit.php?id=${row.id}" class="btn btn-greys me-2"><i class="fa fa-eye" aria-hidden="true"></i> View</a>
                                                              <a href="javascript:void(0);" onclick="confirmDelete(${row.id})" class="link-secondary">
                                                                <i class="fa-solid fa-trash btn btn-greys me-2"></i>
                                                              </a>
                                                            </td>
                                                          </tr>`;
                                                        tableBody.append(tableRow);
                                                        rowCount++;
                                                      });
                                                    
                                                      // Synchronize DOM with selectedApplicantIds
                                                      $('#table_body tr').each(function() {
                                                        var rowId = parseInt($(this).find('td:nth-child(3)').text(), 10); // Assuming ID is in the third column
                                                        if (selectedApplicantIds.includes(rowId)) {
                                                          $(this).addClass('selected-row');
                                                          $(this).find('.check-icon').show();
                                                        }
                                                      });
                                                    
                                                      updateSelectColumnVisibility();
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
                                                      pagination.append('<li class="paginate_button page-item previous" id="DataTables_Table_0_previous"><a href="#" class="page-link"><i class="fa fa-angle-double-left me-2"></i> Previous</a></li>');
                                                  } else {
                                                      pagination.append('<li class="paginate_button page-item previous disabled" id="DataTables_Table_0_previous"><a href="#" class="page-link"><i class="fa fa-angle-double-left me-2"></i> Previous</a></li>');
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
                                                      pagination.append('<li class="paginate_button page-item next" id="DataTables_Table_0_next"><a href="#" class="page-link">Next <i class="fa fa-angle-double-right ms-2"></i></a></li>');
                                                  } else {
                                                      pagination.append('<li class="paginate_button page-item next disabled" id="DataTables_Table_0_next"><a href="#" class="page-link">Next <i class="fa fa-angle-double-right ms-2"></i></a></li>');
                                                  }
                                                }
                                                
                                                // Handle the filter form submission
                                                $("button[name='search']").on("click", function(e) {
                                                  e.preventDefault();
                                                
                                                  // Update currentFilters with the new filter values
                                                  currentFilters = {
                                                      first_name: $("#firstName").val(),
                                                      last_name: $("#lastName").val(),
                                                      interviewStatus: $("#interviewStatus").val(),
                                                      paymentStatus: $("#paymentStatus").val(),
                                                      tricType: $("#tricType").val(),
                                                      tricColor: $("#tricColor").val()
                                                  };
                                                  
                                                  currentPage = 1; // Reset to page 1 on new search
                                                  // Fetch table data with the filters applied
                                                  fetchTableData(currentFilters, currentPage, pageSize);
                                                
                                                  // Close the sidebar
                                                  $(".toggle-sidebar").removeClass("open-filter");
                                                  $("body").removeClass("filter-opened");
                                                })
                                                
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
                                                    $("#first_name, #last_name, #interviewStatus, #paymentStatus, #tricType, #tricColor").val('');
                                                
                                                    // Fetch table data without filters
                                                    fetchTableData(currentFilters, currentPage, pageSize);
                                                });
                                                
                                                
                                                $(document).ready(function() {
                                                  document.getElementById('grantFranchiseBtn').addEventListener('click', () => {
                                                    if (selectedApplicantIds.length === 0) {
                                                      Swal.fire('Error', 'No applicants selected!', 'error');
                                                      return;
                                                    }
                                                  
                                                    Swal.fire({
                                                      title: 'Assign Tricycle Franchise Number',
                                                      input: 'text',
                                                      inputPlaceholder: 'Enter TF Number that will be assigned to the applicant',
                                                      showCancelButton: true,
                                                      confirmButtonText: 'Submit',
                                                      cancelButtonText: 'Cancel',
                                                      customClass: {
                                                        input: 'swal2-input-custom',
                                                        popup: 'swal2-popup-custom',
                                                      },
                                                      inputValidator: (value) => {
                                                        if (!value) {
                                                          return 'You need to enter a Tricycle Franchise Number!';
                                                        }
                                                      }
                                                    }).then((result) => {
                                                      if (result.isConfirmed) {
                                                        const TFno = result.value;
                                                        const lastDigit = TFno.slice(-1);
                                                        const targetTable = getTargetTable(lastDigit);
                                                  
                                                        if (targetTable) {
                                                          grantFranchise(TFno, targetTable);
                                                        } else {
                                                          Swal.fire('Error', 'Invalid TF Number!', 'error');
                                                        }
                                                      }
                                                    });
                                                  });
                                                
                                                   // Determine the target table based on the last digit of the TFno
                                                function getTargetTable(lastDigit) {
                                                    const tableMapping = {
                                                        '1': 'jan_operators',
                                                        '2': 'feb_operators',
                                                        '3': 'march_operators',
                                                        '4': 'apr_operators',
                                                        '5': 'may_operators',
                                                        '6': 'jun_operators',
                                                        '7': 'jul_operators',
                                                        '8': 'aug_operators',
                                                        '9': 'sep_operators',
                                                        '0': 'oct_operators',
                                                    };
                                                    return tableMapping[lastDigit] || null;
                                                }
                                            
                                                // Function to send the TFno and target table to the server
                                                function grantFranchise(TFno, targetTable) {
                                                    // Log data for debugging
                                                    console.log({ TFno, targetTable, selectedApplicantIds });
                                            
                                                    // Calculate expiration date and day banned on the client-side
                                                    const expDate = calculateExpirationDate(TFno);
                                                    const dayBan = calculateDayBanned(TFno);
                                            
                                                    fetch('grant_franchise.php', {
                                                        method: 'POST',
                                                        headers: { 'Content-Type': 'application/json' },
                                                        body: JSON.stringify({
                                                            TFno,
                                                            targetTable,
                                                            selectedApplicantIds,
                                                            expDate,
                                                            dayBan
                                                        }),
                                                    })
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        console.log('API Response:', data);
                                                        if (data.status === 'success') {
                                                            Swal.fire('Success', data.message, 'success');
                                                            selectedApplicantIds = [];  // Clear selected applicants
                                                            fetchTableData(currentFilters, currentPage, pageSize); // Refresh table
                                                        } else {
                                                            Swal.fire('Error', data.message, 'error');
                                                        }
                                                    })
                                                    .catch(error => {
                                                        console.error('Error:', error);
                                                        Swal.fire('Error', 'Something went wrong!', 'error');
                                                    });
                                                }
                                            
                                                function calculateExpirationDate(TFno) {
                                                    const TFnoStr = String(TFno);
                                                    const secondToLastDigit = parseInt(TFnoStr.charAt(TFnoStr.length - 2), 10);
                                                    const lastDigit = parseInt(TFnoStr.charAt(TFnoStr.length - 1), 10);
                                                
                                                    let expirationDay;
                                                    if ([1, 2, 3].includes(secondToLastDigit)) expirationDay = 7;
                                                    else if ([4, 5, 6].includes(secondToLastDigit)) expirationDay = 14;
                                                    else if ([7, 8].includes(secondToLastDigit)) expirationDay = 21;
                                                    else expirationDay = 28;
                                                
                                                    const months = {
                                                        1: '01', 2: '02', 3: '03', 4: '04',
                                                        5: '05', 6: '06', 7: '07', 8: '08',
                                                        9: '09', 0: '10'
                                                    };
                                                
                                                    const expirationMonth = months[lastDigit] || '01';
                                                    const currentYear = new Date().getFullYear();
                                                    const expirationYear = currentYear + 1;
                                                
                                                    const expDate = `${expirationDay}/${expirationMonth}/${expirationYear}`;
                                                    console.log('Calculated Expiration Date:', expDate);  // Debugging log
                                                
                                                    return expDate;
                                                }
                                            
                                                // Function to calculate day banned (moved from server-side)
                                                function calculateDayBanned(TFno) {
                                                    const TFnoStr = String(TFno);
                                                    const lastDigit = parseInt(TFnoStr.charAt(TFnoStr.length - 1), 10);
                                            
                                                    const daysBan = {
                                                        0: 'Monday',
                                                        1: 'Monday',
                                                        2: 'Tuesday',
                                                        3: 'Tuesday',
                                                        4: 'Wednesday',
                                                        5: 'Wednesday',
                                                        6: 'Thursday',
                                                        7: 'Thursday',
                                                        8: 'Friday',
                                                        9: 'Friday'
                                                    };
                                            
                                                    return daysBan[lastDigit];
                                                }
                                            
                                                
                                                  updateSelectColumnVisibility();
                                                
                                                  // Initial load
                                                  fetchTableData(currentFilters, currentPage, pageSize);
                                                
                                                  // fetch data every 3 seconds
                                                  setInterval(() => fetchTableData(currentFilters, currentPage, pageSize), 3000);
                                                  });
                                                });
                                                  
                                            </script>
                                        </tbody>
                                        </table>
                                        <button id="grantFranchiseBtn" class="btn btn-primary">Grant Franchise</button>
                                      
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

            <div class="toggle-sidebar ledge">
            <div class="sidebar-layout-filter">
            <div class="text-right" style="margin-top: 20px; margin-right: 10px;">
                    <a href="#" class="sidebar-close" style="font-size: 1.5em; padding: 10px;">
                        <i class="fa-regular fa-circle-xmark"></i>
                    </a>
                </div>
                <div class="sidebar-header ledge">
                    <h5>Search Applicant</h5>
                </div>
                
                <div class="sidebar-body">
                    <form id="filterForm" action="#" autocomplete="off">
                        <div class="accordion" id="accordionMain2">


                            <div class="col-lg-12 col-sm-12">
                                <div class="input-block mb-3">
                                    <label>Interview Status</label>
                                    <select class="form-control" id="interviewStatus">
                                        <option value="">Select Status</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Done">Done</option>
                                        <option value="Missed">Missed</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12 col-sm-12">
                                <div class="input-block mb-3">
                                    <label>Payment Status</label>
                                    <select class="form-control" id="paymentStatus">
                                        <option value="">Select Status</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Paid">Paid</option>
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
                                    <label>Tricycle Color</label>
                                    <input type="text" class="form-control" id="tricColor" placeholder="Tricycle Color">
                                </div>
                            </div>

                            <div class="col-lg-12 col-sm-12">
                                <div class="input-block mb-3">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" id="firstName" placeholder="First Name">
                                </div>
                            </div>

                            <div class="col-lg-12 col-sm-12">
                                <div class="input-block mb-3">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" id="lastName" placeholder="Last Name">
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
    printWindow.document.write('<h1>Verified Franchise Applicants</h1>');
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
 

    <!-- /.container-fluid -->
        <!--<script src = ../assets/js/load_verified_applicants.js></script>-->
        <script src=../assets/js/update_interviewStatus.js></script>
        <script src=../assets/js/update_paymentStatus.js></script>

          <?php include "../../include/scripts.php"; 
                include "../../include/modal_viewDetails.php";
                include "modal_viewDetailsHolders.php";
                include "../include/scriptsAdmin.php";
                include "../include/footerAdmin.php";
          ?>

          
          <!-- Bootstrap  dito yan sa baba bawal mabago-->
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"  integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
       </script>
