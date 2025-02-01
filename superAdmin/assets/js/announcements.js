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



  function fetchTableData() {
    $.ajax({
      url: 'fetch-announcements.php',
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        var tableBody = $('#table_body');
        tableBody.empty();
        var rowCount = 1; 
        data.forEach(function(row) {
          var tableRow = `
            <tr>
              <td>${rowCount}</td>
              <td>${row.title}</td>
              <td>${row.inserted_at}</td>
        
              <td>
               <a href="edit_announcement.php?id=${row.id}" class="btn btn-greys me-2"><i class="fa fa-eye" aria-hidden="true"></i></i> View</a>
                                <a href="javascript:void(0);" onclick="confirmDelete(${row.id})" class="link-secondary">
                                <i class="fa-solid fa-trash btn btn-greys me-2 " ></i>
                                </a>
              </td>
            </tr>`;
          tableBody.append(tableRow);
          rowCount++; // Increment the row number
        });
      }
    });
  }
  
  setInterval(fetchTableData, 5000);
  fetchTableData();


  function confirmDelete(id) {
    // Use SweetAlert for confirmation
    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to delete this announcement?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'delete_announcement.php',
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
                            text: 'Error deleting announcement: ' + response.message,
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