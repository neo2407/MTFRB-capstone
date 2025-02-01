<?php
session_start();
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mtfrb_lucban";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $stmt = $conn->prepare("SELECT id FROM applicants WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $row = $result->fetch_assoc();

}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Send Email</title>
</head>
<body>
    <form action="sendMail.php" method="POST">
        <label for="id">Applicant ID:</label>
        <input type="text" class="form-control" name="id" value="<?php echo htmlspecialchars($row['id'] ?? ''); ?>">
        <button type="submit">Send Email</button>
    </form>
    <?php include "../../include/scripts.php"; ?>
</body>
</html>