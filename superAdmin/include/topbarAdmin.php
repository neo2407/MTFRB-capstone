<style>
 /* Ensure the bell icon container is positioned relative */
    .nav-link {
    position: relative;  
}

/* Style the notification badge */
#notification-count {
    position: absolute;
    top: 15px; /* Adjust this value to move the badge up */
    right: 0; /* Adjust this value to move the badge to the right */
    background-color: #dc3545; /* Bootstrap's badge-danger background color */
    color: white; /* Text color */
    border-radius: 50%;
    padding: 0.3em 0.3em; /* Adjust padding as needed */
    font-size: 0.75em; /* Adjust font size as needed */
}
.nav-link .fas.fa-bell {
    font-size: 24px; /* Adjust this value as needed */
}      
</style>

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



<!--pre-loader-->
<div id="preloader">
    <img src="../assets/img/output-onlinegiftools.gif" alt="Loading...">
    <p class="loading-text">Just a moment...</p>
</div>

<!-- Topbar -->

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow ">
     <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link">
                        <i class="fa fa-bars" style="margin-right:50px;"></i>
                    </button>

<!-- Scan Qr Code -->
<div>
        <button id="scanQr" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#qrScannerModal">
            <i class="fas fa-qrcode fa-fw"></i> Scan QR Code
        </button>
</div>
                                   

<!-- Topbar Navbar -->
<ul class="navbar-nav ml-auto">

    <!-- Nav Item - Alerts -->
    <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell fa-fs"></i>
            <!-- Counter - Alerts -->
            <span id="notification-count" class="badge badge-danger"><?php echo $total_notifications; ?></span>
        </a>
        <!-- Dropdown - Alerts -->
        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
            aria-labelledby="alertsDropdown">
            
            
        </div>
    </li>

    <div class="topbar-divider d-none d-sm-block"></div>

    <!-- Nav Item - User Information -->
    <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           
            <div class="d-flex flex-column">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Admin Name'; ?>
                </span>
                <span class="mr-2 d-none d-lg-inline text-gray-600" style="font-size: 0.7rem;">
                    <?php echo isset($_SESSION['account_type']) ? $_SESSION['account_type'] : 'Account Type'; ?>
                </span>
            </div>
             <img class="img-profile rounded-circle"
             src="<?php echo isset($_SESSION['profile_picture']) ? '../../uploads/profile_pics/' . $_SESSION['profile_picture'] : '../../uploads/profile_pics/default.jpg'; ?>" 
                                class="rounded-circle profile-img" height="28" alt="Admin Profile" loading="lazy" />
        </a>
        
        <!-- Dropdown - User Information -->
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
               aria-labelledby="userDropdownToggle">
                <a class="dropdown-item" href="#" id="userProfileLink" data-bs-toggle="modal" data-bs-target="#profileModal">
                    <i class="fas fa-user fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <!--<a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-fw mr-2 text-gray-400"></i>
                    Settings
                </a>-->
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="../dashboard/superAdmin_logout.php" id="logoutLink" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
        </div>

        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal" style="margin-right:10px;">Cancel</button>
                    <a class="btn btn-primary" href="../superAdmin_logout.php">Logout</a>
                </div>
            </div>
        
    </li>

</ul>

</nav>

<!-- Profile Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileModalLabel">Account Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="editInfo_account.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <!-- Profile Picture with Light Gray Border -->
                        <div class="col-md-4 text-center mb-3">
                            <div class="profile-card">
                                <img src=" <?php echo isset($_SESSION['profile_picture']) ? '../../uploads/profile_pics/' . $_SESSION['profile_picture'] : '../../uploads/profile_pics/default.jpg'; ?> "alt="Profile Picture" class="profile-picture">
                            </div>
                        </div>

                        <!-- Personal Information Fields -->
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fName">First Name:</label>
                                    <input type="text" class="form-control" id="fName" name="f_name" value="<?php echo isset($_SESSION['f_name']) ? $_SESSION['f_name']: 'First Name';?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="lName">Last Name:</label>
                                    <input type="text" class="form-control" id="lName" name="l_name" value="<?php echo isset($_SESSION['l_name']) ? $_SESSION['l_name']: 'Last Name';?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="middleName">Middle Name:</label>
                                    <input type="text" class="form-control" id="middleName" name="m_name" value="<?php echo isset($_SESSION['m_name']) ? $_SESSION['m_name']: 'Middle Name';?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="uname">Username:</label>
                                    <input type="text" class="form-control" id="uname" name="username" value="<?php echo isset($_SESSION['username']) ? $_SESSION['username']: 'Usernames';?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Account Information -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email']: 'Email';?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="jobPosition">Job Position:</label>
                            <input type="text" class="form-control" id="jobPosition" name="job_position" value="<?php echo isset($_SESSION['job_position']) ? $_SESSION['job_position']: 'Job Position';?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="accountType">Account Type:</label>
                            <input type="text" class="form-control" id="accountType" name="account_type" value="<?php echo isset($_SESSION['account_type']) ? $_SESSION['account_type'] : 'Account Type'; ?>">
                           
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="contactNumber">Contact Number:</label>
                            <input type="text" class="form-control" id="contactNumber" name="contact_number" value="<?php echo isset($_SESSION['contact_number']) ? $_SESSION['contact_number'] : 'Contact Number'; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="accountStatus">Account Status:</label>
                            <input type="text" class="form-control" id="accountStatus" name="account_status" value="<?php echo isset($_SESSION['account_status']) ? $_SESSION['account_status'] : 'Account Status'; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="address">Address:</label>
                            <textarea class="form-control" id="address" name="address" rows="2"><?php echo isset($_SESSION['address']) ? $_SESSION['address'] : 'Address'; ?></textarea>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- CSS for Styling -->
<style>
    .profile-picture {
        height: 170px;
        width: 160px;
        border: 2px solid lightgray; /* Light gray border */
        border-radius: 8px; /* Rounded corners */
        padding:10px; /* Add space between the border and the picture */
        box-sizing: border-box; /* Ensure padding is included in the total width and height */
    }
    .modal-body .row {
        margin-bottom: 10px; /* Add space between rows */
    }
    .modal-body label {
        font-weight: bold; /* Bold labels */
    }
    .profile-card {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px;
    }
</style>

<!-- Modal for QR Code Scanner -->
<div class="modal fade" id="qrScannerModal" tabindex="-1" role="dialog" aria-labelledby="qrScannerModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="qrScannerModalLabel">Scan QR Code</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Container for the QR code scanner -->
        <div id="qr-reader" style="width: 100%; margin: auto;"></div>

        <!-- Container to display the result -->
        <div id="qr-result" class="alert alert-info" style="display:none; text-align: center; margin-top: 20px;"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Include the HTML5 QR code library -->
<script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>

<!-- Custom JavaScript -->
<script>
let html5QrCode;

document.getElementById('scanQr').addEventListener('click', function() {
    console.log('Scan button clicked. Starting QR scanner...');
    $('#qrScannerModal').modal('show');
    startQrScanner();
});

function startQrScanner() {
    console.log('Starting QR scanner...');
    if (html5QrCode) {
        stopQrScanner();
    }

    html5QrCode = new Html5Qrcode("qr-reader");

    const qrCodeSuccessCallback = (decodedText, decodedResult) => {
        console.log('QR Code scanned:', decodedText);

        const isUrl = decodedText.startsWith("http://") || decodedText.startsWith("https://");

        if (isUrl) {
            setTimeout(() => {
                window.open(decodedText, '_blank'); // Open the link in a new tab
                closeModal(); // Close the modal properly after scanning
            }, 100); // Slight delay to ensure the scanner stops properly
        } else {
            document.getElementById('qr-result').innerText = `QR Code Data: ${decodedText}`;
            document.getElementById('qr-result').style.display = 'block';
            closeModal(); // Close the modal properly after displaying the result
        }

        stopQrScanner();
    };

    html5QrCode.start(
        { facingMode: "environment" },
        {
            fps: 10,
            qrbox: 250
        },
        qrCodeSuccessCallback
    ).catch(err => {
        console.error('Error starting the QR code scanner:', err);
        stopQrScanner(); // Ensure scanner stops if it fails to start
    });
}

function stopQrScanner() {
    if (html5QrCode) {
        console.log('Stopping QR scanner...');
        html5QrCode.stop().then(() => {
            console.log('QR scanner stopped.');
            html5QrCode.clear();
            html5QrCode = null;
        }).catch(err => {
            console.error('Error stopping the QR code scanner:', err);
            html5QrCode.clear(); // Clear even if stop fails
            html5QrCode = null;
        });
    } else {
        console.log('No QR scanner instance to stop.');
    }
}

function closeModal() {
    $('#qrScannerModal').modal('hide');
    // Make sure backdrop and modal classes are properly removed
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
    stopQrScanner(); // Stop the scanner in case it's still running
}

// Attach stopQrScanner directly to modal close buttons
document.querySelector('#qrScannerModal .close').addEventListener('click', function() {
    console.log('Close button clicked. Stopping QR scanner...');
    closeModal();
});

document.querySelector('#qrScannerModal .btn-secondary').addEventListener('click', function() {
    console.log('Cancel button clicked. Stopping QR scanner...');
    closeModal();
});

// Debugging modal close event
$('#qrScannerModal').on('hide.bs.modal', function () {
    console.log('hide.bs.modal: Modal is closing. Stopping QR scanner...');
    closeModal();
});

$('#qrScannerModal').on('hidden.bs.modal', function () {
    console.log('hidden.bs.modal: Modal is closed.');
    closeModal(); // Ensures that the QR scanner and modal cleanup happens even after closure
});

</script>


<!-- automatic logout session -->
<script>
let timeout;
let isLoggedOut = false; // Flag to check if the user is logged out

function resetTimer() {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        if (!isLoggedOut) { // Only redirect if the user is not logged out
            window.location.href = '../superAdmin_logout.php';
        }
    }, 3600000); // automatic logout after 1 hour if no activities made // 7200000 if 2hours
}

window.onload = resetTimer;
document.onmousemove = resetTimer;
document.onkeypress = resetTimer;

// Detect if the page is being reloaded by using sessionStorage
window.addEventListener('beforeunload', (event) => {
    if (!sessionStorage.getItem('isReloading')) {
        isLoggedOut = true; // Set this flag to true only when navigating away or closing the browser
    }
    sessionStorage.removeItem('isReloading'); // Clean up after use
});

// Detect a page reload
window.addEventListener('keydown', (event) => {
    if ((event.ctrlKey && event.key === 'r') || event.key === 'F5') {
        sessionStorage.setItem('isReloading', 'true'); // Mark page as reloading
    }
});

window.addEventListener('click', (event) => {
    if (event.target.tagName === 'A' && event.target.href === window.location.href) {
        sessionStorage.setItem('isReloading', 'true'); // Mark page as reloading when clicking the same page link
    }
});


</script>



<!-- automatic record of logout when exiting browser -->
<script>
// Track if a link was clicked or navigation occurred within the site
let isLinkClick = false; 

// Function to send the logout request when the user exits the site
function sendLogout() {
    navigator.sendBeacon('../include/record_logout.php?logout=true');
    console.log("Logout recorded.");
}

// Attach an event listener to detect link clicks within the site
document.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', function () {
        isLinkClick = true; // Set flag when navigating within the site
    });
});

// Reset the flag when the page fully loads
window.addEventListener('load', function () {
    setTimeout(() => isLinkClick = false, 100); // Reset flag after load
});

// Use the 'beforeunload' event to detect tab/browser close only
window.addEventListener('beforeunload', function (e) {
    // Only log out if the user is not navigating within the site
    if (!isLinkClick) {
        sendLogout(); // Send logout request on tab/browser close
    }
});
</script>







    
<!-- End of Topbar -->