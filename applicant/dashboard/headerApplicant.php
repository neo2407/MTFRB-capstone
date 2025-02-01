
<?php
 
  session_start();

  include "../../include/db_conn.php";
  
  // Check if the user is logged in
  if (!isset($_SESSION['email'])) {
      header("Location: ../applicant_login.php");
      exit();

  }
  
  // Fetch applicant data from the database
  $email = $conn->real_escape_string($_SESSION['email']);
  $sql = "SELECT * FROM applicants WHERE email = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  
  if ($result === false) {
      echo "Error: " . $conn->error;
      exit();
  } elseif ($result->num_rows > 0) {
      // Applicant data found, display it
      $row = $result->fetch_assoc();
  } else {
      echo "Applicant data not found.";
      exit();
  }
?>

<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Applicant Profile</title>
  <link rel="icon" href="../assets/img/mtfrbLogo.png">
  <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/profile.css">
</head>

<body>