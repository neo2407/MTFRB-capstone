


<nav class="navbar navbar-expand-md navbar-light shadow-sm p-3 mb-0 bg-white fixed-top">
    <div class="container-lg">
        <a class="navbar-brand" href="#">
            <img src="../assets/img/MTFRB Lucban.jpg" class="logo-pic" alt="Logo of MTFRB Lucban">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="modal" data-bs-target="#navModal">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link active">Home</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link active" aria-current="page">Profile</a>
                </li>
                
                <!-- Divider with inline CSS -->
                <li class="nav-item">
                    <div style="border-left: 1px solid #007bff; height: 100%; margin-left: 10px;"></div>
                </li>
                
                <!-- Avatar dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdownAvatarLink"
                       role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="ms-2">
                            <?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name']; ?> 
                        </span>
                        <img src="<?php echo isset($_SESSION['operatorsPic']) ? '../../uploads/operator/' . $_SESSION['operatorsPic'] : '../assets/img/mtfrbLogo.png'; ?>" 
                          class="rounded-circle" 
                          alt="Profile Picture" 
                          loading="lazy" 
                          style="margin-left: 10px; width: 28px; height: 28px; object-fit: cover;" /> <!-- Added margin-left -->
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownAvatarLink">
                        <li>
                            <a class="dropdown-item" href="../applicantLogout.php">Logout</a>
                        </li>
                    </ul>
                </li>
                <!-- Avatar dropdown -->
            </ul>
        </div>
    </div>
</nav>


  <!-- Modal -->
  <div class="modal fade" id="navModal" tabindex="-1" aria-labelledby="navModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../applicantLogout.php">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</nav>