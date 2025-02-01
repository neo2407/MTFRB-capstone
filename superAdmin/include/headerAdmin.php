<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../superAdmin_login.php");
    exit();
}

include "../include/db_conn.php";
include "../include/functions.php";//  this is the first file to be included

//include "check_notifications.php";


?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <link rel="icon" href="../../assets/img/mtfrbLogo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>SuperAdmin Dashboard</title>

    <!-- Custom fonts for this Admin-->
    <link href="../assets/fontawesome/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../assets/fontawesome/fontawesome.min.css">
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    
     <!-- Custom styles for Admin-->

    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
   <link href="../assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styles2.css">
   <!-- <link rel="stylesheet" href="../assets/css/table.css">-->
    <link rel="stylesheet" href="../assets/css/classic.css">
    <link rel="stylesheet" href="../assets/css/classic.date.css">

  
    </style>
    
       <!-- jQuery -->
       <script src="../assets/js/jquery.js"></script> <!-- Ensure this is the first script -->
       <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
       
   

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

   
    <!-- End of Content Wrapper -->


    