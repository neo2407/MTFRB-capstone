<?php
session_start();
$TFno = isset($_GET['TFno']) ? htmlspecialchars($_GET['TFno']) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rate the Driver</title>
    <link rel="icon" href="assets/img/MTFRB LOGO 2.png">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('assets/img/bg-lucban.png') no-repeat center center fixed;
            background-size: cover;
             background-color: #3468C0;
        }
        
        .rating-container {
            max-width: 500px;
            margin: 110px auto;
        }
        .card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }
        .card-header {
            background: #FF9843;
            color: #333;
            font-weight: bold;
            text-align: center;
            border-radius: 12px 12px 0 0;
        }
        .form-label {
            font-weight: bold;
        }
        .btn-primary {
            width: 100%;
            font-size: 18px;
            background-color:#2680C2;
        }
    </style>
</head>
<body>

<div class="container rating-container">
    <div class="card">
        <div class="card-header">
            <h3>Rate the Driver</h3>
        </div>
        <div class="card-body">
            <form action="submit_rating.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">Tricycle Franchise No.</label>
                    <input type="text" class="form-control" id="TFno" name="TFno" value="<?= $TFno ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Rating (1-5 Stars)</label>
                    <select class="form-control" name="stars" id="stars" required>
                        <option value="">Select Rating</option>
                        <option value="1">⭐ 1 - Poor</option>
                        <option value="2">⭐⭐ 2 - Fair</option>
                        <option value="3">⭐⭐⭐ 3 - Good</option>
                        <option value="4">⭐⭐⭐⭐ 4 - Very Good</option>
                        <option value="5">⭐⭐⭐⭐⭐ 5 - Excellent</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Comments</label>
                    <textarea class="form-control" name="comments" rows="3" placeholder="Write your feedback..." required></textarea>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit Rating</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include "include/scripts.php";?>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
