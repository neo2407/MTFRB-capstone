
<!-- Function to delete data -->
<script type="text/javascript">
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure to delete this data?',
            text: "You won't be able to undo this action!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "delete.php?id=" + id;
            }
        })
    }
</script>

  <!--Function sa pag display ng notif-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  function checkForNotifications() {
  $.ajax({
    url: 'check_notifications.php',
    method: 'GET',
    dataType: 'json',
    success: function(data) {
      console.log("Notifications data:", data);
      $('#notification-count').text(data.count);

      let applications = data.applications;
      let complaints = data.complaints;
      let notifications = data.notifications;
      let dropdownMenu = $('#alertsDropdown').next('.dropdown-menu'); // Select the dropdown menu

      dropdownMenu.empty(); // Clear existing notifications

      // Display new applications
      applications.forEach(app => {
        dropdownMenu.append(`
          <li>
            <a class="dropdown-item" href="#" onclick="markApplicationAsSeen(${app.id}); return false;">
              New application from ${app.first_name} ${app.last_name}
            </a>
          </li>
        `);
      });

      // Display new complaints
      complaints.forEach(complaint => {
        dropdownMenu.append(`
          <li>
            <a class="dropdown-item" href="#" onclick="markComplaintsAsSeen(${complaint.id}); return false;">
              New complaint from ${complaint.first_name} ${complaint.last_name}
            </a>
          </li>
        `);
      });

      // Display other notifications
      notifications.forEach(notification => {
        dropdownMenu.append(`
          <li>
            <a class="dropdown-item" href="#" onclick="markNotificationAsSeen(${notification.id}); return false;">
              ${notification.message}
            </a>
          </li>
        `);
      });
    },
    error: function(xhr, status, error) {
      console.error("Error fetching notifications:", error);
    }
  });
}

// Optional: Automatically check for notifications on page load
$(document).ready(function() {
  checkForNotifications(); // Call the function to check for notifications
});


  // Function to mark applications as seen
  function markApplicationAsSeen(id) {
    console.log("Marking application as seen:", id);
    $.ajax({
      url: 'mark_application_as_seen.php',
      method: 'POST',
      data: { id: id },
      dataType: 'json',
      success: function(response) {
        console.log("Mark application as seen response:", response);
        if (response.success) {
          checkForNotifications();
        } else {
          console.error("Error marking application as seen:", response.error);
        }
      },
      error: function(xhr, status, error) {
        console.error("Error in markApplicationAsSeen:", error);
      }
    });
  }

  // Function to mark applications as seen
  function markComplaintsAsSeen(id) {
    console.log("Marking complaints as seen:", id);
    $.ajax({
      url: 'mark_complaints_as_seen.php',
      method: 'POST',
      data: { id: id },
      dataType: 'json',
      success: function(response) {
        console.log("Mark complaints as seen response:", response);
        if (response.success) {
          checkForNotifications();
        } else {
          console.error("Error marking complaints as seen:", response.error);
        }
      },
      error: function(xhr, status, error) {
        console.error("Error in markComplaintsAsSeen:", error);
      }
    });
  }
  // Function to mark other notifications as seen
  function markNotificationAsSeen(id) {
    console.log("Marking notification as seen:", id);
    $.ajax({
      url: 'mark_notification_as_seen.php',
      method: 'POST',
      data: { id: id },
      dataType: 'json',
      success: function(response) {
        console.log("Mark notification as seen response:", response);
        if (response.success) {
          checkForNotifications();
        } else {
          console.error("Error marking notification as seen:", response.error);
        }
      },
      error: function(xhr, status, error) {
        console.error("Error in markNotificationAsSeen:", error);
      }
    });
  }

  setInterval(checkForNotifications, 3000); // Check every 5 seconds
</script>

  <!-- function sa search at filtering-->
 <script>
  $(document).ready(function() {
    $('#search_input').on('keyup', function() {
      filterTable();
    });

    $('#filter_select').on('change', function() {
      filterTable();
    });

    function filterTable() {
      let filterValue = $('#filter_select').val();
      let searchValue = $('#search_input').val();
      
      $.ajax({
        url: 'search_applicant.php',
        type: 'GET',
        data: {
          filter: filterValue,
          search: searchValue
        },
        success: function(response) {
          $('#table_body').html(response);
        }
      });
    }
  });
</script>


<!-- functions sa modal-->
<script>
    let currentApplicantId=null; // to store the current applicant ID

    function showDetails(id) {
        currentApplicantId = id; // store the applicant ID
        fetch(`getDetails.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                let tricyclePicsLinks = '';
                if (data.tricyclePics) {
                    const tricyclePicsArray = JSON.parse(data.tricyclePics);
                    tricyclePicsArray.forEach(pic => {
                        tricyclePicsLinks += `<a href="../../uploads/tricyclePics/${encodeURIComponent(pic)}" target="_blank">View Attachment</a><br>`;
                    });
                } else {
                    tricyclePicsLinks = 'No Tricycle Pictures available.';
                }

                let details = `
                    <strong>ID:</strong> ${data.id} <br>
                    <strong>First Name:</strong> ${data.first_name} <br>
                    <strong>Last Name:</strong> ${data.last_name} <br>
                    <strong>Email:</strong> ${data.email} <br>
                    <strong>Gender:</strong> ${data.gender} <br>
                    <strong>Application Date:</strong> ${data.applicationDate}<br>
                    <strong>Interview Schedule:</strong> <span id="interviewSchedule">${formatDate(data.interview_sched) || 'Pending'}</span><br>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>File Name</th>
                                <th>View</th>
                                <th>File Status</th>
                                <th>Validation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Drivers Picture</td>
                                <td><a href="../../uploads/driversPic/${data.driversPic}" target="_blank">View Attachment</a></td>
                                <td id="driversPicStatus">${data.driversPicStatus}</td>
                                <td>
                                    <button class="btn btn-success" onclick="validateFile(${data.id}, 'driversPic', 'valid')">Valid</button>
                                    <button class="btn btn-danger" onclick="validateFile(${data.id}, 'driversPic', 'invalid')">Invalid</button>
                                </td>
                            </tr>
                            <tr>
                                <td>License Picture</td>
                                <td><a href="../../uploads/license/${data.license}" target="_blank">View Attachment</a></td>
                                <td id="licenseStatus">${data.licenseStatus}</td>
                                <td>
                                    <button class="btn btn-success" onclick="validateFile(${data.id}, 'license', 'valid')">Valid</button>
                                    <button class="btn btn-danger" onclick="validateFile(${data.id}, 'license', 'invalid')">Invalid</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Tricycle Pictures</td>
                                <td>${tricyclePicsLinks}</td>
                                <td id="tricyclePicsStatus">${data.tricyclePicsStatus}</td>
                                <td>
                                    <button class="btn btn-success" onclick="validateFile(${data.id}, 'tricyclePics', 'valid')">Valid</button>
                                    <button class="btn btn-danger" onclick="validateFile(${data.id}, 'tricyclePics', 'invalid')">Invalid</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                `;
                document.getElementById('detailsContent').innerHTML = details; // ito yung connected sa modal_viewDetail.php under ng modal body
                let detailsModal = new bootstrap.Modal(document.getElementById('detailsModal'));
                detailsModal.show();
            })
            .catch(error => console.error('Error:', error));
    }


    function validateFile(id, fileType, status) {
    if (status === 'Invalid') {
        setTimeout(() => {
            Swal.fire({
                title: 'Remarks',
                input: 'textarea',
                inputLabel: 'Please provide remarks for invalid status:',
                inputPlaceholder: 'Enter your remarks here...',
                showCancelButton: true,
                inputValidator: (value) => {
                    if (!value) {
                        return 'You need to write something!';
                    }
                }
            }).then(result => {
                if (result.isConfirmed) {
                    const remarks = result.value;
                    sendValidationRequest(id, fileType, status, remarks);
                }
            }).catch(() => {
                // Handle the case where the user cancels the SweetAlert dialog
            });
        }, 100); // 100 ms delay
    } else {
        sendValidationRequest(id, fileType, status);
    }
}

function sendValidationRequest(id, fileType, status, remarks = '') {
    console.log(`Sending request with id: ${id}, fileType: ${fileType}, status: ${status}, remarks: ${remarks}`);

    fetch('fileStatus.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id=${id}&fileType=${fileType}&status=${status}&remarks=${remarks}`
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
        if (data.includes("Record updated successfully")) {
            const statusElement = document.getElementById(`${fileType}Status`);
            if (statusElement) {
                statusElement.innerText = status;
            } else {
                console.error(`Element with id ${fileType}Status not found.`);
            }
        } else {
            console.error('Failed to update file status.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}


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

 function addInterview() {
    const interviewForm = document.getElementById('interviewForm');
    const interviewSched = document.getElementById('interview_sched').value;
    const formData = new FormData(interviewForm);

    if (!interviewSched) {
        Swal.fire({
            icon: 'warning',
            title: 'Warning',
            text: 'Please select an interview schedule.',
        });
        return;
    }

    fetch('addInterviewSchedule.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if (data.includes("Interview schedule added successfully")) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Interview schedule added successfully!',
            });

            // Convert the interview schedule to 12-hour format with AM/PM
            const formattedSched = formatTo12Hour(interviewSched);
            document.getElementById('interview_sched_display').value = formattedSched;

            // Show the buttons
            document.getElementById('sendMailBtn').removeAttribute('hidden');
            document.getElementById('sendSMSBtn').removeAttribute('hidden');

        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data, 
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while adding the interview schedule.',
        });
    });
}


// Function to format datetime to 12-hour format with AM/PM
function formatTo12Hour(datetime) {
    const date = new Date(datetime);
    let hours = date.getHours();
    const minutes = date.getMinutes();
    const ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // The hour '0' should be '12'
    const minutesStr = minutes < 10 ? '0' + minutes : minutes;
    const strTime = hours + ':' + minutesStr + ' ' + ampm;
    return `${date.getMonth() + 1}/${date.getDate()}/${date.getFullYear()} ${strTime}`;
}   


function sendMail() {
    // Show loading spinner
    document.getElementById('loadingSpinner').style.display = 'block';

    // Get the hidden ID value
    const id = document.querySelector('input[name="id"]').value;

    fetch('sendMail.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            id: id,
        }),
    })
    .then(response => response.json())
    .then(data => {
        // Hide loading spinner
        document.getElementById('loadingSpinner').style.display = 'none';

        if (data.status === "success") {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: data.message,
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message,
            });
        }
    })
    .catch(error => {
        // Hide loading spinner
        document.getElementById('loadingSpinner').style.display = 'none';

        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to send message.',
        });
    });
}

// send SMS function
function sendSMS() { 
    // Show loading spinner
    document.getElementById('loadingSpinner').style.display = 'block';

    // Get the hidden ID value
    const id = document.querySelector('input[name="id"]').value;

    fetch('sendSMS.php', { 
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            id: id,
        }),
    })
    .then(response => response.json())
    .then(data => {
         console.log(data); // Add this to log the full response
        // Hide loading spinner
        document.getElementById('loadingSpinner').style.display = 'none';

        if (data.status === "success") {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: data.message,
            });
        } else { // babalik to sa error if ibang api ang gagamitin
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'SMS sent successfully!',
            });
        }
    })
    .catch(error => {
        // Hide loading spinner
        document.getElementById('loadingSpinner').style.display = 'none';

        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to send message.',
        });
    });
}
</script>




