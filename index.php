<?php
session_start();


/**Default value for maintenance_mode if not set
if (!isset($_SESSION['maintenance_mode'])) {
    $_SESSION['maintenance_mode'] = false;
}

// Redirect to maintenance.php if maintenance mode is enabled
if ($_SESSION['maintenance_mode'] == true) {
    header("Location: maintenance.php");
    exit();
}**/
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>MTFRB Lucban</title>
  <link rel="icon" href="assets/img/MTFRB LOGO 2.png">
  <!--<meta http-equiv="refresh" content="30"> automatic page reload --> 
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="assets/css/css2.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  
  <link href="assets/css/style2.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
.about-us {
            padding: 3rem 0;
            background-color: #fff;
        }

        .about-us .title-content {
            font-size: 2rem;
            font-weight: 600;
            color: #212529;
            margin-bottom: 1.5rem;
        }

        .about-us .title-content::after {
            content: "";
            display: block;
            width: 50px;
            height: 3px;
            background-color: #f3a362;
            margin: 5px auto 0;
        }


        .about-us p {
            font-size: 1rem;
            line-height: 1.8;
        }

        .about-us h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #212529;
        }

        .about-us .icon {
            margin-right: 15px;
        }

        .about-us .icon i {
            background-color: #fff;
            color: #f3a362;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            font-size: 22px;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .about-us h4 {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .about-us p {
            margin-bottom: 0.5rem;
        }

        s .d-flex.align-items-start {
            margin-bottom: 1.5rem;
        }

        .services .section-title {
            font-size: 1.75rem;
            /* Slightly smaller font size */
            font-weight: bold;
            text-align: center;
            color: #212529;
            margin-bottom: 1rem;
        }

        .services .section-subtitle {
            font-size: 0.9rem;
            /* Smaller font size */
            text-align: center;
            color: #6c757d;
            margin-bottom: 2rem;
        }

        .service-box {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            /* Reduce padding */
            background-color: #fff;
            border-radius: 6px;
            /* Smaller border radius */
            box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
            /* Reduce margin between boxes */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .service-box:hover {
            transform: translateY(-3px);
            /* Slightly less lift */
            box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.15);
        }

        .service-box .icon {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 48px;
            /* Reduce icon size */
            height: 48px;
            /* Reduce icon size */
            border-radius: 50%;
            background-color: #e9f9ff;
            /* Light blue background */
            color: #0d6efd;
            /* Icon color */
            font-size: 1.25rem;
            /* Reduce font size for the icon */
            margin-right: 0.75rem;
            /* Smaller spacing */
        }

        .service-box .content h4 {
            font-size: 1rem;
            /* Smaller heading size */
            font-weight: bold;
            color: #212529;
            margin-bottom: 0.3rem;
            /* Reduce spacing below heading */
        }

        .service-box .content p {
            font-size: 0.85rem;
            /* Smaller font size */
            color: #6c757d;
            margin-bottom: 0.75rem;
            /* Reduce spacing below paragraph */
        }

        .service-box .learn-more {
            font-size: 0.85rem;
            /* Smaller link font size */
            color: #0d6efd;
            text-decoration: none;
            font-weight: 600;
        }

        .service-box .learn-more i {
            margin-left: 5px;
        }
 /*--------------------------------------------------------------
# Services
--------------------------------------------------------------*/
.services .content {
    padding: 5rem;
    padding-bottom: 8rem;
}

.services .text-center {
    color: white;
    padding: 2rem;
}

.services .service-item .title {
    font-size: 1.85rem !important;
}


.services .service-item {
    height: 100%;
    padding: 30px;
    transition: 0.3s;
    border-radius: 10px;
    display: flex;
}

.services.service-item:hover {
    transform: translateY(-2px);
    box-shadow: 0px 5px 12px rgba(0, 0, 0, 0.15);
}

.services .service-item .icon {
    color: #ffff;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    font-size: 22px;
    border-radius: 50%;
}

.services .service-item p {
    margin-bottom: 0;
    color: color-mix(in srgb, var(#ffffff), transparent 40%);
    transition: 0.3s;
}

.services .service-item:hover p {
    color: color-mix(in srgb, var(#ffffff), transparent 10%);
}


/*--------------------------------------------------------------
# Announcement
--------------------------------------------------------------*/

.announcement .content {
    padding:1rem;
    padding-bottom: 3rem;
    
}

.announcement .announcement-title {
    color: #fff;
}

.announcement .card-content h3 {
    font-size: 1.75rem;
    margin-bottom: 8px;
}

.announcement .card-content p {
    color: #666;
    font-size: 0.938rem;
    line-height: 1.3;
}


.announcement .swiper {
    display: flex;
    justify-content: center;
    padding: 1.89rem;
    max-width: 1100px;
    width: 100%;
}

.announcement .swiper .swiper-slide {
    display: flex;
    justify-content: center; /* Center content vertically */
    align-items: center; /* Center content horizontally */
    width: 100%; /* Ensure slides take up full width */
    height: 500px; /* Set a fixed height for uniformity */
    box-sizing: border-box; /* Include padding and border in total width and height */
    overflow: hidden; /* Prevent content from overflowing */
    margin-left:-0.5px;
    margin-right:-1px;
}

.announcement .swiper .swiper-slide img {
    width: 100%;
    height: 250px; /* Set a fixed height for all images */
    object-fit: cover; /* Ensure the image covers the entire area while maintaining aspect ratio */
    margin-bottom: 1rem;
    border-radius: 8px; /* Optional: Add a border-radius for a rounded corner effect */
}

.announcement .swiper .swiper-wrapper {
    display: flex;
    justify-content: space-between;
    width: 100%;
}

.announcement .swiper-button-next,
.swiper-button-prev {
    opacity: 0.7;
    color: #FF9843;
    transition: all 0.3s ease;
}

.announcement .swiper-button-next:hover,
.swiper-button-prev:hover {
    opacity: 1;
    color: #FF9843;
}

/* Position the buttons outside the swiper */
.announcement .swiper-button-prev {
    left: -2px; /* Move the button farther left */
}

.announcement .swiper-button-next {
    right: -2px; /* Move the button farther right */
}  

.navbar-nav .nav-link {
    margin: 0 30px;
    /* Adjust this value to set the space between links */
    color: #0b0000;
    font-weight: 400;
}

.nav-link:hover {
    color: #FF9843;
}

.nav-link:active {
    color: #FF9843;
}

.nav-link:active::backdrop {
    color: #FF9843;
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
</head>

<body>

<!--pre-loader-->
<div id="preloader">
    <img src="assets/img/output-onlinegiftools.gif" alt="Loading...">
    <p class="loading-text">Just a moment...</p>
</div>

<nav class="navbar navbar-expand-md navbar-light shadow-sm p-3 mb-0 bg-white">
  <div class="container d-flex justify-content-between">
    <a class="navbar-brand" href="index.php">
      <img src="assets/img/MTFRB Lucban.jpg" class="logo-pic" alt="Logo of MTFRB Lucban">
    </a>
    
    <button class="navbar-toggler" type="button" data-bs-toggle="modal" data-bs-target="#navModal">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav"> <!-- Center the nav items -->
            <li class="nav-item">
                 <a class="nav-link" href="#About">Home</a>
             </li>
             <li class="nav-item">
                <a class="nav-link" href="#About">About</a>
             </li>
             <li class="nav-item">
                <a class="nav-link" href="#Services">Services</a>
             </li>
             <li class="nav-item">
                <a class="nav-link" href="#Contact-Us">Contact</a>
             </li>
             <li class="nav-item">
                <a class="nav-link" href="faq.php" target="_blank">FAQ</a>
             </li>
                
        <!-- Google Translate dropdown 
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="googleTranslateDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Translate
          </a>
          <div class="dropdown-menu" aria-labelledby="googleTranslateDropdown">
            <div id="google_translate_element"></div>
          </div>
        </li>-->
      </ul>
      <a href="login.php" target="_blank" class="btn btn-primary">LOGIN</a>
    </div>
  </div>
</nav>

<!-- Modal -->
<div class="modal fade" id="navModal" tabindex="-1" aria-labelledby="navModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    <div class="modal-content">
      <div class="modal-body">
        <ul class="nav flex-column">
          <li class="nav-item">
             <a class="nav-link" href="#About">Home</a>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="#About">About</a>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="#Services">Services</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#Contact-Us">Contact</a>
        </li>
        <li class="nav-item">
             <a class="nav-link" href="faq.php">FAQ</a>
        </li>
        <li class="nav-item">
           <a class="nav-link" href="login.php" target="_blank">Login</a>
        </li>
          <!-- Google Translate dropdown
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="googleTranslateDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Translate
            </a>
            <div class="dropdown-menu" aria-labelledby="googleTranslateDropdown">
              <div id="google_translate_element"></div>
            </div>
          </li> -->
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- google translate / js
<script type="text/javascript">
    function googleTranslateElementInit() {
      new google.translate.TranslateElement({
        pageLanguage: 'en',
        includedLanguages: 'en,tl', // Only include English and Filipino
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE
      }, 'google_translate_element');

      const savedLang = localStorage.getItem('selectedLang');
      if (savedLang) {
        setTimeout(() => {
          translateLanguage(savedLang);
        }, 1000); // Adjusted delay to 1 second
      }
    }

    function translateLanguage(lang) {
      const checkDropdown = setInterval(() => {
        const translateSelect = document.querySelector('.goog-te-combo');
        if (translateSelect) {
          clearInterval(checkDropdown);
          translateSelect.value = lang;
          translateSelect.dispatchEvent(new Event('change'));
          localStorage.setItem('selectedLang', lang);
        } else {
          console.warn('Google Translate dropdown not found. Retrying...');
        }
      }, 100); // Check every 100 milliseconds
    }

  // Ensure the Google Translate script has loaded before calling googleTranslateElementInit
  window.addEventListener('load', function() {
    setTimeout(function() {
      googleTranslateElementInit();
    }, 1000); // Increased wait time before initialization
  });

  // Debugging function to check if the dropdown exists in the DOM
  function checkIfDropdownExists() {
    setTimeout(() => {
      const translateSelect = document.querySelector('.goog-te-combo');
      console.log(translateSelect ? "Dropdown found!" : "Dropdown still not found.");
      console.log(document.body.innerHTML); // Log the current state of the body for debugging
    }, 5000); // Check 5 seconds after loading
  }
  window.addEventListener('load', checkIfDropdownExists); // Add debugging check on load
</script>
<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>-->

<section id="Home" class="hero section dark-background">
    <div id="hero-carousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#hero-carousel" data-bs-slide-to="0" class="active" aria-current="true"
          aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#hero-carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#hero-carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>

      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="assets/img/bg-lucban.png" class="image1" alt="Slide 1">
          <div class="carousel-caption top-0 mt-5">
            <p class="slide-title text-align mt-5">Municipal Tricycle Franchising and Regulatory Board - Lucban</p>
            <p class="slide-description mt-2 w-75">The MTFRB Lucban Website provides an online application portal for tricycle franchises, 
            facilitating efficient services and offering a complaint system for commuters to improve the process.</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="assets/img/download.png" class="image2" alt="Slide 2">
          <div class="carousel-caption top-0 mt-5">
            <p class="slide-title text-align mt-5">Municipal Tricycle Franchising and Regulatory Board - Lucban</p>
            <p class="slide-description mt-2 w-75">The MTFRB Lucban Website provides an online application portal for tricycle franchises, 
            facilitating efficient services and offering a complaint system for commuters to improve the process.</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="assets/img/TAXICLE.png" class="image3" alt="Slide 3">
          <div class="carousel-caption top-0 mt-5">
            <p class="slide-title text-align mt-5">Municipal Tricycle Franchising and Regulatory Board - Lucban</p>
            <p class="slide-description mt-2 w-75">The MTFRB Lucban Website provides an online application portal for tricycle franchises, facilitating efficient services and offering a complaint system for commuters to improve the process.</p>
          </div>
        </div>
      </div>

      <button class="carousel-control-prev" type="button" data-bs-target="#hero-carousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#hero-carousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </section>
  
    <section class="about-us" id="About">
        <div class="container">
            <div class="row align-items-start">
                <!-- Left Column: About Us Details -->
                <h2 class="title-content text-center">About Us</h2>
                <p class="text-center">
                    Welcome to the official page of the <b>Municipal Tricycle Franchising and Regulatory Board (MTFRB)
                        Lucban,</b>
                    your trusted partner in regulating and enhancing tricycle transportation within our municipality.
                </p>
                <p class="text-center mb-4">
                    At MTFRB Lucban, we are dedicated to providing a well-organized system for tricycle operators,
                    drivers, and
                    the commuting public. Our online platform reflects our commitment to improving public service by
                    making
                    tricycle franchise applications, complaint resolutions, and other essential services accessible,
                    efficient,
                    and transparent.
                </p>

                <!-- Right Column: What We Do -->
                <h3 class="mb-4 text-center">What We Do</h3>
                <!-- Item 1 -->

                <div class="col-md-6">

                    <div class="d-flex align-items-start mb-3">
                        <div class="icon">
                            <i class="fa-solid fa-file-signature"></i>
                        </div>
                        <div>
                            <h4>Streamlined Franchise Application</h4>
                            <p>
                                Our digital portal simplifies the process of applying for new or renewing existing
                                tricycle franchises,
                                ensuring all transactions are straightforward and accessible.
                            </p>
                        </div>
                    </div>

                    <!-- Item 2 -->
                    <div class="d-flex align-items-start mb-3">
                        <div class="icon">
                            <i class="fa-solid fa-comments"></i>
                        </div>
                        <div>
                            <h4>Complaint Management</h4>
                            <p>
                                We provide a platform for residents and commuters to voice their concerns regarding
                                tricycle operations,
                                promoting accountability and service improvement.
                            </p>
                        </div>
                    </div>

                </div>

                <div class="col-md-6">
                    <!-- Item 3 -->
                    <div class="d-flex align-items-start mb-3">
                        <div class="icon">
                            <i class="fa-solid fa-clipboard-check"></i>
                        </div>
                        <div>
                            <h4>Compliance and Monitoring</h4>
                            <p>
                                We enforce regulations and standards to ensure tricycle services are safe, efficient,
                                and
                                environmentally
                                friendly.
                            </p>
                        </div>
                    </div>

                    <!-- Item 4 -->
                    <div class="d-flex align-items-start mb-3">
                        <div class="icon">
                            <i class="fa-solid fa-people-group"></i>
                        </div>
                        <div>
                            <h4>Community Support</h4>
                            <p>
                                MTFRB Lucban collaborates with the Tricycle Operators and Drivers Associations (TODA) to
                                support
                                livelihoods while maintaining service quality and commuter satisfaction.
                            </p>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </section>
    
  <section class="announcement">
    <div class="content" syt>
        <p class="announcement-title text-center fs-2 fw-semibold">News & Announcements</p>
        <div class="swiper mySwiper container">
            <div class="swiper-wrapper content">
                <?php
                include "include/db_conn.php";

                // Fetch up to 5 announcements from the database
                $sql = "SELECT * FROM announcements ORDER BY inserted_at DESC LIMIT 5";
                $result = mysqli_query($conn, $sql);

                $announcements = [];
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $announcements[] = $row;
                    }
                }

                // Ensure at least 3 announcements are displayed
                while (count($announcements) < 3) {
                    $announcements = array_merge($announcements, $announcements);
                }

                // Limit to a maximum of 5 announcements
                $announcements = array_slice($announcements, 0, 5);

                // Display the announcements
                foreach ($announcements as $row) {
                    ?>
                    <div class="swiper-slide card">
                        <img class="card-img-top" src="uploads/announcements/<?php echo htmlspecialchars($row['image']); ?>" alt="Card image cap" style="padding:1rem;">
                        <div class="card-body">
                            <h3 class="text-center"><?php echo htmlspecialchars($row['title']); ?></h3>
                            
                            <div class="text-center">
                                <button class="btn btn-warning read-more-btn"
                        data-title="<?php echo htmlspecialchars(stripslashes($row['title'])); ?>"
                        data-content="<?php 
                            echo htmlspecialchars(
                                stripslashes(
                                    str_replace(["\\r\\n", "\\r", "\\n"], "\n", $row['content'])
                                )
                            ); ?>"
                                 data-image="uploads/announcements/<?php echo htmlspecialchars($row['image']); ?>">
                                    Read More
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php
                }

                mysqli_close($conn);
                ?>
            </div>
             <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        </div>
    </div>
</section>


<!-- Bootstrap Modal Announcement -->
<div class="modal fade" id="announcementModal" tabindex="-1" aria-labelledby="announcementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header text-center w-100">
                <h5 class="modal-title text-uppercase fw-bold" id="announcementModalLabel"></h5>
            </div>
            <div class="modal-body text-center" style="margin-top: 20px;">
                <div class="image-container"> <!-- Container for consistent sizing -->
                    <img src="" alt="Announcement Image" id="announcementImage" class="img-fluid mb-3">
                </div>
                <p id="announcementContent" class="text-center"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<style>
    .modal-header {
    justify-content: center;
    background-color: white;
}

.modal-title {
    font-size: 1.5rem;
    color: #3468C0 !important; /* Enforcing text color */
    margin: 0; /* Removes default margin */
}

.modal-body {
    display: flex;
    flex-direction: column;
    align-items: center; /* Centers content horizontally */
    justify-content: center; /* Centers content vertically */
    background-color: white;
    padding: 20px; /* Adds padding for spacing */
}

.image-container {
    width: 100%; /* Container takes full width */
    max-width: 600px; /* Set the maximum width of the container */
    max-height: 400px; /* Set the maximum height of the container */
    height: 400px; /* Set a fixed height to ensure consistent sizing */
    display: flex;
    justify-content: center; /* Center the image horizontally */
    align-items: center; /* Center the image vertically */
    overflow: hidden; /* Ensures content doesn't overflow the container */
  
    background-color: #f9f9f9; /* Optional: Adds a background color */
}

#announcementImage {
    max-width: 100%; /* Ensures the image doesn't exceed the container's width */
    max-height: 100%; /* Ensures the image doesn't exceed the container's height */
    object-fit: contain; /* Fits the image within the container without cropping */
}

</style>



  <section id="How-it-works" class="how-it-works">
    <div class="content">
      <button class="requirements-btn" data-bs-toggle="modal" data-bs-target="#reg-modal">REQUIREMENTS</button>
      <p class="title text-center"><a
          href="https://scribehow.com/shared/How_to_Apply_for_a_Tricycle_Franchise_Online_A_Step-by-Step_Guide__iR0NVWe4TBa83iITw_aC5A"
          target="_blank" data-toggle="tooltip" data-placement="bottom"
          title="Click Here">Tricycle Franchise Application Step-by-Step Guide</a></p>

      <div class="card-group">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title text-center">Tricycle Franchise Application Submission</h5>
            <div class="text-center">
              <img class="card-img" src="assets/img/Submit.png" alt="Card image cap">
            </div>
            <p class="card-text fs-5 text-center">Step 1</p>
            <p class="card-text text-center d-inline-block">Create an account and fill out the online application form with your personal and vehicle details, and upload the required documents.</p>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <h5 class="card-title text-center">Processing and Evaluation</h5>
            <div class="text-center">
              <img class="card-img" src="assets/img/assessment.png" alt="Card image cap">
            </div>
            <p class="card-text fs-5 text-center">Step 2</p>
            <p class="card-text text-center">Your application will be reviewed for completeness and compliance.</p>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <h5 class="card-title text-center">Wait SMS or Email</h5>
            <div class="text-center">
              <img class="card-img" src="assets/img/sms.png" alt="Card image cap">
            </div>
            <p class="card-text fs-5 text-center">Step 3</p>
            <p class="card-text text-center">Upon submission, you will receive an SMS or Email message with details on
              when to
              visit the office for the review of your application for approval.</p>
          </div>
        </div>
      </div>
      <div class="text-center">
        <a href="franchise_applicant/account-registration.php" target="_blank" class="btn btn-warning report-btn mt-3">Apply Now</a>
      </div>
    </div>
  </section>

  <!--Requirements-->

  <div class="modal fade" id="reg-modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal-title">Requirements</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h5>Tricycle</h5>
          <ul>
            <li><i class="fa-solid fa-check-square"></i> Photocopy (CR) Certificate of Registration from LTO.</li>
            <li><i class="fa-solid fa-check-square"></i> Photocopy (OR) Official Receipt from LTO</li>
            <li><i class="fa-solid fa-check-square"></i> Photo paper Printed Tricycle Picture (3R size) Front-Back-Motor
              Side - Inside Front.</li>
            <li><i class="fa-solid fa-check-square"></i> Tricycle Inspection.</li>
            <li><i class="fa-solid fa-check-square"></i> Deed of Sale (Notarized).</li>
          </ul>
          <h5>Operator</h5>
          <ul>
            <li><i class="fa-solid fa-check-square"></i> (1 pc.size 2x2) Latest Operator picture.</li>
            <li><i class="fa-solid fa-check-square"></i> Photocopy sedula.</li>
            <li><i class="fa-solid fa-check-square"></i> Barangay Clearance (Franchise Renewal).</li>
            <li><i class="fa-solid fa-check-square"></i> Tricycle Inspection.</li>
            <li><i class="fa-solid fa-check-square"></i> <strong>TODA</strong> Certification (Original)</li>
          </ul>
          <h5>Driver</h5>
          <ul>
            <li><i class="fa-solid fa-check-square"></i> (1 pc. Size 2x2) Latest Driver picture.</li>
            <li><i class="fa-solid fa-check-square"></i> Photocopy Medical Certf. (Sputum) w/ health card (Laminated).
            </li>
            <li><i class="fa-solid fa-check-square"></i> Photocopy Professional driver’s license.
            <li>
          </ul>
        </div>
      </div>
    </div>
  </div>


    <section id="Services" class="services">

        <p class="text-center fs-2  fw-semibold mb-2">Services</p>
        <div class="container pb-3">

            <div class="row">

                <div class="col-lg-6">
                    <div class="service-item d-flex">
                        <div class="icon"><i class="fas fa-file-contract"></i></div>
                        <div>
                            <p class="title text-white fw-semibold">Franchise Issuance and Renewal</p>
                            <p class="description text-white">Granting permits for tricycle operators to operate within
                                a
                                municipality and
                                renewal of existing tricycle franchises.</p>
                        </div>
                    </div>
                </div>
                <!-- End Service Item -->

                <div class="col-lg-6">
                    <div class="service-item d-flex">
                        <div class="icon"><i class="fas fa-route"></i></div>
                        <div>
                            <p class="title text-white fw-semibold">Regulation of Tricycle Operations</p>
                            <p class="description text-white">Setting and enforcing operational boundaries and routes
                                and
                                establishing guidelines for tricycle drivers and operators.</p>
                        </div>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-lg-6">
                    <div class="service-item d-flex">
                        <div class="icon flex-shrink-0"><i class="fas fa-money-bill-wave"></i></div>
                        <div>
                            <p class="title text-white fw-semibold">Fare Regulation</p>
                            <p class="description text-white">Determining and approving fare rates for tricycle
                                services.</p>
                        </div>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-lg-6">
                    <div class="service-item d-flex">
                        <div class="icon flex-shrink-0"><i class="fas fa-id-card"></i></div>
                        <div>
                            <p class="title text-white fw-semibold">Driver and Operator Registration</p>
                            <p class="description text-white">Ensuring all drivers and operators are properly registered
                                and
                                licensed.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="service-item d-flex">
                        <div class="icon flex-shrink-0"><i class="fas fa-shield-alt"></i></div>
                        <div>
                            <p class="title text-white fw-semibold">Compliance Monitoring</p>
                            <p class="description text-white">Conducting inspections to ensure tricycles comply with
                                local
                                ordinances and standards (e.g., safety and environmental requirements).</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="service-item d-flex">
                        <div class="icon flex-shrink-0"><i class="fas fa-handshake"></i></div>
                        <div>
                            <p class="title text-white fw-semibold">Dispute Resolution</p>
                            <p class="description text-white">Handling complaints and conflicts between tricycle
                                operators,
                                drivers, and passengers.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="service-item d-flex">
                        <div class="icon flex-shrink-0"><i class="fas fa-tools"></i></div>
                        <div>
                            <p class="title text-white fw-semibold">Approval of Tricycle Design and Safety Standards</p>
                            <p class="description text-white">Approving tricycle body designs and safety equipment to
                                meet
                                municipal standards.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="service-item d-flex">
                        <div class="icon"><i class="fas fa-comment-dots"></i></div>
                        <div>
                            <p class="title text-white fw-semibold">Complaints and Feedback Management</p>
                            <p class="description text-white">Addressing commuter and community concerns regarding
                                tricycle
                                operations.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>
    
  <section id="Contact-Us" class="contact">
    <div class="content">
      <p class="text-center fs-2 fw-semibold">For complaint and other concerns</p>
      <div class="card-group">
        <div class="card">
          <div class="text-center">
            <img class="card-img" src="assets/img/complaint2.png"
              alt="Card image cap">
          </div>
          <div class="card-body">
            <p class="card-title text-center">Online Complaint Form</p>
            <p class="card-text text-center">Fill out our online complaint form to submit your feedback. Provide detailed
              information to help us understand and resolve your concerns efficiently.</p>
          </div>
        </div>
        <div class="card">
          <div class="text-center">
            <img class="card-img" src="assets/img/envelope-on-hand-holding-smartphone-screen-online-communication-send-email-digital-chat-concept-flat-illustration-template-for-web-banner-landing-page-infographic-vector.jpg"
              alt="Card image cap">
          </div>
          <div class="card-body">
            <p class="card-title text-center">Email</p>
            <p class="card-text mt-3 text-center">You can also send us an email, including Concern in the subject line. </p>
            <p class="card-email text-center">lucban@mtfrb.gov.ph</p>
          </div>
        </div>
        <div class="card">
          <div class="text-center">
            <img class="card-img"
              src="assets/img/vecteezy_communication-phone-people-and-social-networks_12961774.jpg"
              alt="Card image cap">
          </div>
          <div class="card-body">
            <p class="card-title text-center">Contact Us</p>
            <p class="card-text mt-3 text-center">Have feedback or need help? Get in touch with MTFRB Lucban!</p>
            <p class="card-number text-center">(042) 540-226</p>
          </div>
        </div>
      </div>
      <div class="text-center">
        <a href="complaintForm.php" target="_blank" class="btn btn-warning report-btn mt-5">File a Complaint</a>
      </div>
    </div>
  </section>

 <section class="MTFRB">
    <div class="content row justify-content-center">
      <div class="card-group">
        <div class="card text-center">
          <img class="card-img" src="assets/img/Vice Mayor.png" alt="Card image cap">
          <div class="card-body">
            <span class="name">Arnel C. Abcede </span>
            <span class="position">Vice Mayor</span>
          </div>
        </div>
      </div>
      <div class="card-group">
        <div class="card text-center">
          <img class="card-img" src="assets/img/Mayor.png" alt="Card image cap">
          <div class="card-body">
            <span class="name">Agustin M. Villaverde</span>
            <span class="position">Mayor</span>
          </div>
        </div>
      </div>

      <div class="card-group">
        <div class="card text-center">
          <img class="card-img" src="assets/img/Councilor.png" alt="Card image cap">
          <div class="card-body">
            <span class="name">Aven Vince V. Rada</span>
            <span class="position">Councilor/MTFRB Chairman</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!---MTFRB Staff-->
  <p class="title text-center fs-3 fw-semibold ">MTFRB Staff</p>
  <section class="Staff">
    <div class="swiper mySwiper container">
      <div class="swiper-wrapper content">

        <div class="swiper-slide card">
          <div class="card-content">
            <div class="image">
              <img src="assets/img/Barbierra.png" alt="">
            </div>
            <div class="name-profession">
              <span class="name">Judith S. Barbierra</span>
              <span class="profession">Administrative Aide 1</span>
            </div>
          </div>
        </div>
        <div class="swiper-slide card">
          <div class="card-content">
            <div class="image">
              <img src="assets/img/Babat.png" class="card-image" alt="">
            </div>
            <div class="name-profession">
              <span class="name">Justin Lee Babat</span>
              <span class="profession">Administrative Aide 1</span>
            </div>
          </div>
        </div>
        <div class="swiper-slide card">
          <div class="card-content">
            <div class="image">
              <img src="assets/img/Veloso.png" alt="">
            </div>
            <div class="name-profession">
              <span class="name">Janice Ian E. Veloso</span>
              <span class="profession">Administrative Aide 1</span>
            </div>
          </div>
        </div>
        <div class="swiper-slide card">
          <div class="card-content">
            <div class="image">
              <img src="assets/img/Mary.png" alt="">
            </div>
            <div class="name-profession">
              <span class="name">Mary Rose L. Cada</span>
              <span class="profession">Administrative Aide 1</span>
            </div>
          </div>
        </div>
        <div class="swiper-slide card">
          <div class="card-content">
            <div class="image">
              <img src="assets/img/Laguerta.png" alt="">
            </div>
            <div class="name-profession">
              <span class="name">Maica B. Laguerta</span>
              <span class="profession">Administrative Aide 1</span>
            </div>
          </div>
        </div>
        <div class="swiper-slide card">
          <div class="card-content">
            <div class="image">
              <img src="assets/img/Omlas.png" alt="">
            </div>
            <div class="name-profession">
              <span class="name">Joey O. Omlas</span>
              <span class="profession">Administrative Aide 1</span>
            </div>
          </div>
        </div>
        <div class="swiper-slide card">
          <div class="card-content">
            <div class="image">
              <img src="assets/img/Fortus1.png" alt="">
            </div>
            <div class="name-profession">
              <span class="name">Ramil Fortus</span>
              <span class="profession">Administrative Aide 1/Inspector</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-pagination"></div>
  </section>

  <!-- footer section start -->
  <footer id="footer">
    <div class="container mr-5">
      <div class="row">
        <div class="col-md-4">
          <a href="admin/admin_login.php" target="_blank""><img src="assets/img/MTFRB LOGO 2.png" alt="footer-logo" class="logo-footer"></a>
          <div class="footer-about">
            <p style="color: #ffff;">MTFRB Lucban is an online application portal for tricycle franchises, offering
              efficient services and a complaint system for commuters to streamline the process. </p>
          </div>

        </div>
        <div class="col-md-2">
          <div class="useful-link">
            <h2>Useful Links</h2>
           
            <div class="use-links mb-3">
            <li><a href="#Home"><i class="fa-solid fa-angles-right"></i> Home</a></li>
              <li><a href="#About"><i class="fa-solid fa-angles-right"></i> About</a></li>
              
              <li><a href="#Services"><i class="fa-solid fa-angles-right"></i> Services</a></li>
              <li><a href="#Contact-Us"><i class="fa-solid fa-angles-right"></i>Contact Us</a></li>
              <li><a href="faq.php" target="_blank"><i class="fa-solid fa-angles-right"></i> FAQ</a></li>
            </div>
          </div>

        </div>
        <div class="col-md-2">
          <div class="social-links">
            
            <div class="social-icons mb-3">
              <li><a href="https://www.facebook.com/mtfrb.lgu"><i class="fa-brands fa-facebook-f"></i> Facebook</a></li>
            </div>
          </div>


        </div>
        <div class="col-md-4">
          <div class="address">
            <h2>Address</h2>
           
            <div class="address-links mb-3">
              <li class="address1"><i class="fa-solid fa-location-dot"></i>Lucban -Sampaloc Road, 88 A. Racelis Ave,
                Lucban, 4328 Quezon</li>
              <li><a><i class="fa-solid fa-phone"></i>(042) 540-2261</a></li>
              <li><a><i class="fa-solid fa-envelope"></i>avenbince@gmail.com</a></li>
            </div>
          </div>
        </div>

      </div>
    </div>
           

  </footer>
  <section id="copy-right">
   <a href="superAdmin/superAdmin_login.php" target="_blank">
  <div class="copy-right-sec">
    <i class="fa-solid fa-copyright"></i>
    2025 MTFRB Lucban. All rights reserved.
  </div>
</a>

  </section>

  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/swiper-bundle.min.js"></script>
  <script src="assets/js/script.js"></script>

<!--<script src="assets/js/translate.js"> </script>-->
<!--<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>-->
<script>
    // swiper carousel
var swiper = new Swiper(".mySwiper", {
    slidesPerView: 3,
    spaceBetween: 30,
    grabCursor: true,
    autoplay: {
        delay: 2000,
        disableOnInteraction: false,
        pauseOnMouseEnter: true,
    },
    slidesPerGroup: 1,
    loop: true,
    loopFillGroupWithBlank: true,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints: {
        // when window width is >= 320px
        360: {
            slidesPerView: 1,
            spaceBetween: 10
        },
        // when window width is >= 480px
        480: {
            slidesPerView: 2,
            spaceBetween: 20
        },
        // when window width is >= 768px
        768: {
            slidesPerView: 3,
            spaceBetween: 30
        }
    }
});



</script>
<script>
 document.addEventListener('DOMContentLoaded', function () {
  const modalElement = document.getElementById('announcementModal');
  const modal = new bootstrap.Modal(modalElement, {
    backdrop: 'static', // Prevent closing by clicking outside
    keyboard: false // Prevent closing with Esc key
  });

  document.querySelectorAll('.read-more-btn').forEach(button => {
    button.addEventListener('click', function () {
      const title = this.getAttribute('data-title');
      const content = this.getAttribute('data-content');
      const image = this.getAttribute('data-image');

      document.getElementById('announcementModalLabel').textContent = title;
      document.getElementById('announcementContent').textContent = content;
      document.getElementById('announcementImage').src = image;

      modal.show();
    });
  });
});
</script>

<?php include "include/scripts.php"?>
</body>

</html>