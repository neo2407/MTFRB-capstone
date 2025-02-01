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
            url: 'fetch_previous_operator.php',
            type: 'GET',
            data: {...filters, page: page, pageSize: pageSize}, // Include page and pageSize in the request
            dataType: 'json',
            success: function(data) {
                var tableBody = $('#table_body');
                tableBody.empty();

                if (data.rows.length === 0) {
                    tableBody.append('<tr><td colspan="7" class="text-center">No operator/s found</td></tr>');
                    return; // Exit the function if no data is found
                }

                var rowCount = (page - 1) * pageSize + 1; // Calculate row numbering based on page
                data.rows.forEach(function(row) {
                    var tableRow = `
                        <tr>
                            <td>${rowCount}</td>
                            <td>${row.TFno}</td>
                            <td>${row.first_name}</td>
                            <td>${row.last_name}</td>
                            <td>${row.tricType}</td>
                            
                            <td>
                                <a href="view_previous_operator.php?id=${row.id}" class="btn btn-greys me-2"><i class="fa fa-eye" aria-hidden="true"></i> View</a>
                                
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
            
            tricType: $("#tricType").val(),
            last_name: $("#last_name").val(), 
            TFno: $("#TFno").val(),
            first_name: $("#first_name").val()
        };

        currentPage = 1; // Reset to page 1 when applying new filters

        // Fetch table data with the filters applied
        fetchTableData(currentFilters, currentPage, pageSize);

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

    // Handle pagination clicks
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
        $(" #tricType,  #last_name, #TFno, #first_name").val('');

        // Fetch table data without filters
        fetchTableData(currentFilters, currentPage, pageSize);
    });


    // Initial load of applicants
    fetchTableData(currentFilters, currentPage, pageSize);

    // Refresh the table data every 3 seconds, keeping the current page and filters
    setInterval(() => fetchTableData(currentFilters, currentPage, pageSize), 3000);
});



