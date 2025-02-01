<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../include/db_conn.php';

    $uploadDir = '../uploads/tricyclePics/';
    $allowedTypes = ['image/jpeg', 'image/png'];

    if (isset($_FILES['image']) && isset($_POST['step'])) {
        $file = $_FILES['image'];
        $step = $_POST['step'];
        $id = $_SESSION['id'] ?? null; // Ensure session ID exists

        if (!$id) {
            echo json_encode(["success" => false, "error" => "Session ID not found."]);
            exit;
        }

        // Validate file type
        if (!in_array($file['type'], $allowedTypes)) {
            echo json_encode(["success" => false, "error" => "Invalid file type. Only JPEG and PNG are allowed."]);
            exit;
        }

        // Generate unique filename
        $filename = uniqid() . "_" . basename($file['name']);
        $targetPath = $uploadDir . $filename;

        // Create upload directory if not exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            // Update database
            $stmt = $conn->prepare("SELECT tricyclePics FROM applicants WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $existingPics = $result->fetch_assoc()['tricyclePics'];
            $stmt->close();

            $tricyclePics = $existingPics ? json_decode($existingPics, true) : [];
            $tricyclePics[$step] = $filename; // Add or update step with new filename

            $stmt = $conn->prepare("UPDATE applicants SET tricyclePics = ? WHERE id = ?");
            $updatedPics = json_encode($tricyclePics);
            $stmt->bind_param("si", $updatedPics, $id);

            if ($stmt->execute()) {
                echo json_encode(["success" => true, "filename" => $filename]);
            } else {
                echo json_encode(["success" => false, "error" => $stmt->error]);
            }

            $stmt->close();
        } else {
            echo json_encode(["success" => false, "error" => "Failed to save the file."]);
        }
    } else {
        echo json_encode(["success" => false, "error" => "No file or step information provided."]);
    }

    $conn->close();
}
?>
