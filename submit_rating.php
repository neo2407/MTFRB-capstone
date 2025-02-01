<?php
session_start();
include "include/db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $TFno = htmlspecialchars($_POST['TFno']);
    $stars = intval($_POST['stars']);
    $comments = htmlspecialchars($_POST['comments']);
 

    // Validate input
    if (empty($TFno) || empty($stars) || empty($comments)) {
        $_SESSION['status'] = "All fields are required.";
        header("Location: drivers_ratings.php?TFno=$TFno");
        exit();
    }

    // Insert into database using prepared statements
    $query = "INSERT INTO driver_ratings (TFno, stars, comments, date_rated) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $TFno,  $stars, $comments);

    if ($stmt->execute()) {
         $_SESSION['status'] = "Ratings Submitted Successfully";
                    $_SESSION['status_code'] = "success";
                    header('Location: index.php');
    } else {
        $_SESSION['status'] = "Something went wrong. Please try again.";
        $_SESSION['status_code'] = "error";
                    header('Location: index.php');
    }

    $stmt->close();
    $conn->close();
} else {
    $_SESSION['status'] = "Invalid request.";
    header("Location: drivers_ratings.php");
    exit();
}
?>
