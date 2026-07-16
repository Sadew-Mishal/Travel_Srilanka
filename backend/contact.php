<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.html#contact');
    exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $email === '' || $message === '') {
    header('Location: ../index.html?contact=missing#contact');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ../index.html?contact=invalid_email#contact');
    exit;
}

$statement = $pdo->prepare(
    'INSERT INTO contact_messages (full_name, email, message) VALUES (?, ?, ?)'
);
$statement->execute([$name, $email, $message]);

header('Location: ../index.html?contact=success#contact');
exit;
