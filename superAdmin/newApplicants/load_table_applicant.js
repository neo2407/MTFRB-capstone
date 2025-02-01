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

// Fetch applicants table data with optional filters, pagination, and page size
$(document).ready(function() {
    let currentFilters = {}; // Store the filters to apply across pagination
    let currentPage = 1; // Store the current page number
    let pageSize = parseInt($('select[name="DataTables_Table_0_length"]').val(), 10); // Store the selected page size

    function fetchTableData(filters = {}, page = 1, pageSize = 10) {
        $.ajax({
      url: 'fetch_data_applicant.php',
      type: 'GET',
      data: {...filters, page: page, pageSize: pageSize}, 
            dataType: 'json',
            success: function(data) {
                var tableBody = $('#table_body');
                tableBody.empty();

                if (data.rows.length === 0) {
                    tableBody.append('<tr><td colspan="7" class="text-center">No applicant/s found</td></tr>');
                    return; // Exit the function if no data is found
                }
      
                var rowCount = (page - 1) * pageSize + 1; // Calculate row numbering based on page
                data.rows.forEach(function(row) {
                    var tableRow = `
                  <tr>
                      <td>${rowCount}</td>
                      <td>${row.id}</td>
                       <td>${row.first_name}</td>
                      <td>${row.last_name}</td>
                      <td>${row.applicationDate}</td>
                     
                      <td>
                           <select onchange="updateApplicantStatus(${row.id}, this.value)">
                             <option value="Pending" 
                                  ${row.applicantStatus === 'Pending' ? 'selected="selected"' : ''}>
                                  Pending
                              </option>
                              <option value="Verified" ${row.applicantStatus === 'Verified' ? 'selected' : ''}>Verified</option>
                              <option value="Denied" ${row.applicantStatus === 'Denied' ? 'selected' : ''}>Denied</option>
                          </select>
                      </td>
                      <td>  
                          <a href="edit.php?id=${row.id}" class="btn btn-greys me-2"><i class="fa fa-eye" aria-hidden="true"></i></i> View</a>
                          <a href="javascript:void(0);" onclick="confirmDelete(${row.id})" class="link-secondary">
                              <i class="fa-solid fa-trash btn btn-greys me-2 " ></i>
                          </a>

                      </td>
                  </tr>`;
                  tableBody.append(tableRow);
                  // Increment the row number
                     rowCount++;
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
  
    // Update currentFilters with the new filter values
    currentFilters = {
        first_name: $("#firstName").val(),
        last_name: $("#lastName").val(),
        applicantStatus: $("#applicantStatus").val(),
        tricType: $("#tricType").val()
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
    $("#first_name, #last_name, #applicantStatus, #tricType").val('');

    // Fetch table data without filters
    fetchTableData(currentFilters, currentPage, pageSize);
});

// Initial load
fetchTableData(currentFilters, currentPage, pageSize);

// fetch data every 5 seconds
setInterval(() => fetchTableData(currentFilters, currentPage, pageSize), 5000);

});
