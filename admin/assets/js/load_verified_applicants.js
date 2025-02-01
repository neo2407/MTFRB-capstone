    
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
                                              });

                                                
                                                  updateSelectColumnVisibility();
                                                
                                                  // Initial load
                                                  fetchTableData(currentFilters, currentPage, pageSize);
                                                
                                                  // fetch data every 3 seconds
                                                  setInterval(() => fetchTableData(currentFilters, currentPage, pageSize), 3000);
                                                  });
                                                });
                                                  