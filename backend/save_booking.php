<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../booking.html');
    exit;
}

$customerName = trim($_POST['customer_name'] ?? '');
$whatsappNumber = trim($_POST['whatsapp_number'] ?? '');
$selectedCities = trim($_POST['selected_cities'] ?? '');
$vehicleName = trim($_POST['vehicle_name'] ?? '');
$vehiclePrice = (float) ($_POST['vehicle_price'] ?? 0);
$travelDays = (int) ($_POST['travel_days'] ?? 0);
$guideAdded = isset($_POST['guide_added']) && $_POST['guide_added'] === '1' ? 1 : 0;
$totalAmount = (float) ($_POST['total_amount'] ?? 0);
$paymentMethod = trim($_POST['payment_method'] ?? '');
$receiptFileName = null;
$userId = $_SESSION['user_id'] ?? null;

if (
    $customerName === '' ||
    $selectedCities === '' ||
    $vehicleName === '' ||
    $vehiclePrice <= 0 ||
    $travelDays <= 0 ||
    $totalAmount <= 0 ||
    $paymentMethod === ''
) {
    header('Location: ../booking.html?booking=missing');
    exit;
}

if (isset($_FILES['receipt_file']) && $_FILES['receipt_file']['error'] === UPLOAD_ERR_OK) {
    $uploadDirectory = __DIR__ . '/../uploads/receipts';

    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true);
    }

    $originalName = basename($_FILES['receipt_file']['name']);
    $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

    if (!in_array($extension, $allowedExtensions, true)) {
        header('Location: ../booking.html?booking=invalid_receipt');
        exit;
    }

    $receiptFileName = uniqid('receipt_', true) . '.' . $extension;
    $targetPath = $uploadDirectory . '/' . $receiptFileName;

    move_uploaded_file($_FILES['receipt_file']['tmp_name'], $targetPath);
}

$statement = $pdo->prepare(
    'INSERT INTO bookings (
        user_id,
        customer_name,
        whatsapp_number,
        selected_cities,
        vehicle_name,
        vehicle_price,
        travel_days,
        guide_added,
        total_amount,
        payment_method,
        receipt_file_name
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
);

$statement->execute([
    $userId,
    $customerName,
    $whatsappNumber,
    $selectedCities,
    $vehicleName,
    $vehiclePrice,
    $travelDays,
    $guideAdded,
    $totalAmount,
    $paymentMethod,
    $receiptFileName
]);

header('Location: ../booking.html?booking=success');
exit;
