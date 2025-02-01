<?php
if (isset($_POST['image'])) {
    $image = $_POST['image'];
    $image = str_replace('data:image/png;base64,', '', $image);
    $image = str_replace(' ', '+', $image);
    $data = base64_decode($image);

    $fileName = '../../violationsReceipt/receipt_' . time() . '.png';
    if (file_put_contents($fileName, $data)) {
        echo json_encode(["status" => "success", "message" => "Receipt saved successfully", "file" => $fileName]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to save receipt"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "No image data found"]);
}
?>
