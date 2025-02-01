
<?php
 
  session_start();

  include "../../include/db_conn.php";
  
  // Check if the user is logged in
  if (!isset($_SESSION['email'])) {
      header("Location: ../operator_login.php");
      exit();

  }
  
  // Fetch operator data from the database
  $email = $conn->real_escape_string($_SESSION['email']);
  $sql = "SELECT * FROM jan_operators WHERE email = ? UNION ALL
          SELECT * FROM feb_operators WHERE email = ? UNION ALL
          SELECT * FROM march_operators WHERE email = ? UNION ALL
          SELECT * FROM apr_operators WHERE email = ? UNION ALL
          SELECT * FROM may_operators WHERE email = ? UNION ALL
          SELECT * FROM jun_operators WHERE email = ? UNION ALL
          SELECT * FROM jul_operators WHERE email = ? UNION ALL
          SELECT * FROM aug_operators WHERE email = ? UNION ALL
          SELECT * FROM sep_operators WHERE email = ? UNION ALL
          SELECT * FROM oct_operators WHERE email = ? ";
  
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssssssssss", $email, $email, $email, $email, $email, $email, $email, $email, $email, $email);
  $stmt->execute();
  $result = $stmt->get_result();
  
  if ($result === false) {
      echo "Error: " . $conn->error;
      exit();
  } elseif ($result->num_rows > 0) {
      // Applicant data found, display it
      $row = $result->fetch_assoc();
  } else {
      echo "Operator data not found.";
      exit();
  }
?>

<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Operator Profile</title>
  <link rel="icon" href="../assets/img/mtfrbLogo.png">
  <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/profile.css">
</head>

<body>