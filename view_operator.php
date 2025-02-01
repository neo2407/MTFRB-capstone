<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tricycle Franchise Details</title>
    <link rel="icon" href="assets/img/MTFRB LOGO 2.png">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('assets/img/background.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .container {
            max-width: 450px;
            margin-top: 30px;
            background: #3468C0 url('../../assets/img/bg-lucban.png') no-repeat center center;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }
        .card-header {
            background-color: #FF9843;
            color: white;
            text-align: center;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .divider {
            border-bottom: 1px solid #d3d3d3;
            margin-bottom: 10px;
            padding-bottom: 10px;
        }
    </style>
</head>
<body>

<?php
include "include/db_conn.php"; 

if (isset($_GET['id'])) {
    $encodedId = htmlspecialchars($_GET['id']);
    $operatorId = base64_decode($encodedId);

    $query = "
    SELECT * FROM jan_operators WHERE id = ? UNION 
    SELECT * FROM feb_operators WHERE id = ? UNION 
    SELECT * FROM march_operators WHERE id = ? UNION 
    SELECT * FROM apr_operators WHERE id = ? UNION
    SELECT * FROM may_operators WHERE id = ? UNION  
    SELECT * FROM jun_operators WHERE id = ? UNION 
    SELECT * FROM jul_operators WHERE id = ? UNION 
    SELECT * FROM aug_operators WHERE id = ? UNION 
    SELECT * FROM sep_operators WHERE id = ? UNION 
    SELECT * FROM oct_operators WHERE id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiiiiiiiii", $operatorId, $operatorId, $operatorId, $operatorId, $operatorId, $operatorId, $operatorId, $operatorId, $operatorId, $operatorId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        echo "<div class='container'>";
        echo "    <div class='card'>";
        echo "        <div class='card-header'>";
        echo "            <h3>Tricycle Franchise Details</h3>";
        echo "        </div>";
        echo "        <div class='card-body text-center'>";
        echo "            <img src='uploads/operator/" . htmlspecialchars($row['operatorsPic']) . "' alt='Profile Picture' class='rounded-circle' style='height: 140px; width: 140px; object-fit: cover; border: 1px solid #d3d3d3; margin-bottom: 20px;'>";
        echo "            <div class='profile-info'>";
        echo "                <div class='d-flex justify-content-between divider'><strong>Tricycle Franchise #:</strong> <span class='text-secondary'>" . htmlspecialchars($row['TFno']) . "</span></div>";
        echo "                <div class='d-flex justify-content-between divider'><strong>Operator Name:</strong> <span class='text-secondary'>" . htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']) . "</span></div>";
        echo "                <div class='d-flex justify-content-between divider'><strong>Driver Name:</strong> <span class='text-secondary'>" . htmlspecialchars($row['driver1_name']) . "</span></div>";
        echo "                <div class='d-flex justify-content-between divider'><strong>Day Banned:</strong> <span class='text-secondary'>" . htmlspecialchars($row['dayBan']) . "</span></div>";
        echo "                <div class='d-flex justify-content-between divider'><strong>Expiration Date:</strong> <span class='text-secondary'>" . htmlspecialchars($row['expDate']) . "</span></div>";
        echo "                <div class='d-flex justify-content-between divider'><strong>Tricycle Color:</strong> <span class='text-secondary'>" . htmlspecialchars($row['tricColor']) . "</span></div>";
        echo "                <div class='d-flex justify-content-between divider'><strong>Body Built:</strong> <span class='text-secondary'>" . htmlspecialchars($row['tricType']) . "</span></div>";
        echo "                <div class='d-flex justify-content-between'><strong>TODA:</strong> <span class='text-secondary'>" . htmlspecialchars($row['toda']) . "</span></div>";
        echo "<br>";
       echo "<div class='text-center mt-2 d-flex justify-content-center gap-3'>";
echo "    <a href='complaintForm.php?id=" . htmlspecialchars($encodedId) . 
        "&TFno=" . urlencode($row['TFno']) . 
        "&colorOftric=" . urlencode($row['tricColor']) . 
        "&madeOf=" . urlencode($row['tricType']) . "' 
        class='btn btn-danger btn-md mx-2'>File a Complaint</a>";

echo "    <a href='drivers_ratings.php?TFno=" . urlencode($row['TFno']) . "' 
        class='btn btn-warning btn-md mx-2'>Rate the Driver</a>";
echo "</div>";

        echo "            </div>";
        echo "        </div>";
        echo "    </div>";
        echo "</div>";
    } else {
        echo "<div class='container text-center'><p>No data found for this operator.</p></div>";
    }
} else {
    echo "<div class='container text-center'><p>Invalid operator ID.</p></div>";
}
?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
