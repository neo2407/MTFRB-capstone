<?php
session_start(); // Start the session
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

    /* Custom styling for the toggle switch */
    .custom-switch .custom-control-label::before {
        background-color: #2680C2;
    }
</style>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <?php include "../include/topbarAdmin.php"; ?>

    <!-- Main Content -->
    <div class="container-fluid" style="margin-left:20px;">
        <h3 class="h3 mb-0 text-gray-800">System Maintenance</h3>
        <div class="page-wrapper" style="min-height: 548px; margin-left: -75px;">
            <div class="content container-lg">
                <!-- System Maintenance Toggle Switch -->
               <form method="POST" action="maintenance_toggle.php">
    <div class="form-check form-switch">
        <!-- Send 'on' if checked -->
        <input class="form-check-input" type="checkbox" role="switch" id="maintenanceToggle" name="maintenance_toggle" value="on" 
            <?php echo isset($_SESSION['maintenance_mode']) && $_SESSION['maintenance_mode'] == true ? 'checked' : ''; ?>>
        <label class="form-check-label" for="maintenanceToggle">Enable System Maintenance</label>
        
        <!-- Send 'off' if not checked (fallback) -->
        <input type="hidden" name="maintenance_toggle" value="off">
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
</form>

                <p id="maintenanceStatus">
                    <?php
                    if (isset($_SESSION['maintenance_mode']) && $_SESSION['maintenance_mode'] == true) {
                        echo "System is in Maintenance Mode.";
                    } else {
                        echo "System is Active.";
                    }
                    ?>
                </p>
            </div>
        </div>
    </div>

    <?php 
        include "../include/scripts.php"; 
        include "../include/scriptsAdmin.php";
        include "../include/footerAdmin.php";
    ?>

    <!-- Bootstrap JS files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</div>
