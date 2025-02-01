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
    let currentFilters = {}; // Store the filters to retain across pagination
    let currentPage = 1; // Store the current page number
    let pageSize = parseInt($('select[name="DataTables_Table_0_length"]').val(), 10); // Store the selected page size

    function fetchTableData(filters = {}, page = 1, pageSize = 10) {
        $.ajax({
            url: 'fetch_dropped_franchise.php',
            type: 'POST', 
            data: {...filters, page: page, pageSize: pageSize}, // Include page and pageSize in the request
            dataType: 'json',
            success: function(data) {
                console.log("AJAX Response:", data); // Inspect the data structure
                var tableBody = $('#table_body');
                tableBody.empty();

                // Ensure rows exist and are an array
                if (!data.rows || !Array.isArray(data.rows) || data.rows.length === 0) {
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
                            <td>${row.dropping_date}</td>
                            <td>
                               <a href="javascript:void(0);" onclick="confirmUnDropped(${row.id}, '${row.TFno}')" class="btn btn-greys me-2">
                                    <i class="fa fa-edit" aria-hidden="true"></i> Undropped
                                </a>
                              <a href="javascript:void(0);" onclick="deleteOperator(${row.TFno})" class="btn btn-greys me-2">
                                <i class="fa fa-trash" aria-hidden="true"></i> Delete
                            </a>
                            </td>
                        </tr>`;
                    tableBody.append(tableRow);
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
            first_name: $("#first_name").val(),
            last_name: $("#last_name").val(),
            month: $("#month").val(),
            id: $("#id").val()
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
  ;
  
    // Handle pagination clicks
    $(document).on('click', '#DataTables_Table_0_paginate .pagination li a', function(e) {
        e.preventDefault();
  
        var $this = $(this);
        var page = parseInt($this.text(), 10);
      
        if ($this.closest('li').hasClass('previous')) {
            page = parseInt($('#DataTables_Table_0_paginate .pagination .active').text(), 10) - 1;
        } else if ($this.closest('li').hasClass('next')) {
            page = parseInt($('#DataTables_Table_0_paginate .pagination .active').text(), 10) + 1;
        }
  
        if (!isNaN(page)) {
            var pageSize = parseInt($('select[name="DataTables_Table_0_length"]').val(), 10);
            fetchTableData(currentFilters, page, pageSize);
        }
    });
    
    // Handle the reset filter button click
     $(".btn.btn-filters").on("click", function() {
        currentFilters = {}; // Clear the filter object
        currentPage = 1; // Reset to page 1
        pageSize = parseInt($('select[name="DataTables_Table_0_length"]').val(), 10); // Retain the selected page size

        // Clear the filter input fields
        $("#first_name, #last_name, #month, #id").val('');

        // Fetch table data without filters
        fetchTableData(currentFilters, currentPage, pageSize);
    });
    
  
    // Initial load
    fetchTableData(currentFilters, currentPage, pageSize);

    // fetch data every 3 seconds
    setInterval(() => fetchTableData(currentFilters, currentPage, pageSize), 3000);
});




  function confirmUnDropped(id, TFno) {
    console.log('id:', id); // Log the id value
    console.log('TFno:', TFno); // Log the TFno value

    Swal.fire({
        title: 'Are you sure?',
        text: `Do you really want to undropped this franchise? ${TFno}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, undropped it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'undropped_franchise.php',
                type: 'POST',
                data: { id: id },
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



function deleteOperator(TFno) {
    console.log('Confirm delete called with TFno:', TFno); // Debugging line

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to undo this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            console.log('Sending delete request with TFno:', TFno); // Log when the delete request is confirmed

            // Send the delete request
            $.ajax({
                url: 'deleteOperator.php',
                type: 'POST',
                data: { TFno: TFno }, // Updated to send TFno instead of id
                dataType: 'json',
                success: function(response) {
                    console.log('Delete response:', response);
                    if (response.status === 'success') {
                        Swal.fire('Deleted!', 'Operator Deleted Successfully.', 'success');
                        // Optionally refresh the table or remove the deleted row from the UI
                    } else {
                        Swal.fire('Error!', response.message || 'There was a problem updating the record.', 'error');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error:', textStatus, errorThrown);
                    Swal.fire('Error!', 'There was a problem with the request.', 'error');
                }
            });
        }
    });
}

