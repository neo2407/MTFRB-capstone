<?php
session_start();
include "../../include/db_conn.php";
include "../../include/functions.php"; // fix position nito, ito ang unang kino-call

// nag kaka error pag inalis ko  ito kahit meron na sa check_notifications
// Fetch the count of new applications
$new_applications_sql = "SELECT id, first_name, last_name FROM applicants WHERE is_new = 1";
$new_applications_result = mysqli_query($conn, $new_applications_sql);
$new_applications = mysqli_fetch_all($new_applications_result, MYSQLI_ASSOC);

// Fetch unseen update notifications
$notifications_sql = "SELECT id, message FROM notifications WHERE seen = 0";
$notifications_result = mysqli_query($conn, $notifications_sql);
$notifications = mysqli_fetch_all($notifications_result, MYSQLI_ASSOC);

// Combine both counts update at applications
$total_notifications = count($new_applications) + count($notifications);
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- <meta http-equiv="refresh" content="30">--> 

      <link rel="shortcut icon" type="image/x-icon" href="../assets/img/MTFRBLogo.png">
      <title> MTFRB LUCBAN</title>
   
      
      <!-- Bootstrap -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
      <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
      <!-- Bootstrap -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
      
      <!-- Font Awesome -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

      <!-- SweetAlert -->
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

      <!-- Jquery -->
     
      <script src="../../assets/js/jquery.js"></script> <!-- pang load ng notif message -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
      
      <!-- css for notif icon--> 
      <link rel="stylesheet" href="../../assets/css/notif.css">
  </head>

  <body>
    <!-- Navigation bar with notification dropdown -->
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
        <b><a class="navbar-brand" href="#">MTFRB LUCBAN</a></b>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
              <a class="nav-link notification-icon" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa-solid fa-bell"></i>
                <span id="notification-count" class="badge badge-danger">0</span>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDropdown">
                <h6 class="dropdown-header">New Notifications</h6>
                <div class="dropdown-divider"></div>
                <ul id="notification-list" class="list-unstyled dropdown-menu"></ul>
              </div>
            </li>
          </ul>
        </div>
      </nav>

        
      <div class="container" style="padding: 30px;">

          
          <legend> Tricycle Franchise Applicants </legend>
          <!-- Filter Dropdown -->
          <div class="input-group mb-3">
            <select id="filter_select" class="form-select">
              <option value="">Select Filter</option>
              <option value="first_name">First Name</option>
              <option value="last_name">Last Name</option>
              <option value="email">Email</option>
              <option value="gender">Gender</option>
              <option value="applicationDate">Application Date</option>
            </select>
            <input type="text" class="form-control" id="search_input" placeholder="Search">
          </div>

          <div class="table-responsive">
          <table class="table table-hover text-center">
            <thead class="table-dark">
                <tr>
                <th scope="col">#</th>
                <th scope="col">ID</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Email</th>
                <th scope="col">Gender</th>
                <th scope="col">Application Date</th>
                <th scope="col">Applicant Status</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody id="table_body">
            <!-- pang load ng new applicant from index or admin and apply through ajax-->
                <script src = ../../assets/js/load_table_applicant.js></script>
            </tbody>
          </table> 
          <a href="add-new.php" class="btn btn-dark mb-3">Add New</a> 
        </div>
        </div>
        <script src=../../assets/js/update_applicant_status.js></script>
          <?php include "../../include/scripts.php"; 
                include "../../include/modal_viewDetails.php";
          ?>
          <!-- Bootstrap  dito yan sa baba bawal mabago-->
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"  integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
       </script>
    </body>
</html>
