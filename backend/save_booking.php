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
$receiptFileName = trim($_POST['receipt_file_name'] ?? '');
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
