<?php
require '../../vendor/autoload.php'; // Include the Intervention Image library

use Intervention\Image\ImageManagerStatic as Image;

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Ensure proper content type for JSON response
header('Content-Type: application/json');

try {
    // Fetch data from the form submission
    $orderId = htmlspecialchars($_POST['orderId']);
    $payor = htmlspecialchars($_POST['first_name']);
    $paymentDate = htmlspecialchars($_POST['paymentDate']);
    $nature = htmlspecialchars($_POST['nature']);
    $amount = htmlspecialchars($_POST['amount']);
    $amount_words = htmlspecialchars($_POST['amount_words']);

    // Validate required fields
    if (empty($orderId) || empty($payor) || empty($paymentDate) || empty($nature) || empty($amount) || empty($amount_words)) {
        throw new Exception('Missing required fields.');
    }

    // Image dimensions
    $imageWidth = 800; // Canvas width
    $imageHeight = 600; // Canvas height

    // Create a blank white image canvas
    $image = Image::canvas($imageWidth, $imageHeight, '#FFFFFF');

    // Add logos (if applicable)
    $leftLogoPath = '../../assets/img/mtfrbLogo.png'; 
    $rightLogoPath = '../../assets/img/sbLogo.jpg'; 

    if (file_exists($leftLogoPath)) {
        $leftLogo = Image::make($leftLogoPath)->resize(100, 100);
        $image->insert($leftLogo, 'top-left', 20, 20); // Positioning the left logo
    }

    if (file_exists($rightLogoPath)) {
        $rightLogo = Image::make($rightLogoPath)->resize(100, 100);
        $image->insert($rightLogo, 'top-right', 20, 20); // Positioning the right logo
    }

    // Add header text
    $image->text('Municipal Tricycle Franchising and Regulatory Board - Lucban', $imageWidth / 2, 50, function ($font) {
        $font->size(18);
        $font->align('center');
        $font->valign('top');
        $font->color('#000000');
    });

    $image->text('88 A. Racelis Ave, Lucban, 4328 Quezon', $imageWidth / 2, 80, function ($font) {
        $font->size(12);
        $font->align('center');
        $font->color('#000000');
    });

    // Add title for the document
    $image->text('ORDER OF PAYMENT', $imageWidth / 2, 120, function ($font) {
        $font->size(16);
        $font->align('center');
        $font->color('#000000');
    });

    // Add form fields as text on the image
    $image->text("Order ID: $orderId", 50, 150, function ($font) {
        $font->size(14);
        $font->color('#000000');
    });

    $image->text("Payor: $payor", 50, 180, function ($font) {
        $font->size(14);
        $font->color('#000000');
    });

    $image->text("Date: $paymentDate", 50, 210, function ($font) {
        $font->size(14);
        $font->color('#000000');
    });

    // Save the image to the `orderPayment` folder
    $savePath = '../../orderPayment/order_' . $orderId . '.png';
    if ($image->save($savePath)) {
        echo json_encode(['success' => true, 'file' => $savePath]);
    } else {
        throw new Exception('Failed to save the image.');
    }
} catch (Exception $e) {
    // Send error response as JSON
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
