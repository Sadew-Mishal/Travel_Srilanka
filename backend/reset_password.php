<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../reset-password.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';

if ($email === '' || $password === '' || $confirmPassword === '') {
    header('Location: ../reset-password.php?error=missing');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ../reset-password.php?error=invalid_email');
    exit;
}

if ($password !== $confirmPassword) {
    header('Location: ../reset-password.php?error=password_mismatch');
    exit;
}

$hasLetter = preg_match('/[a-zA-Z]/', $password);
$hasNumber = preg_match('/[0-9]/', $password);
$hasSpecial = preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password);

if (!$hasLetter || !$hasNumber || !$hasSpecial) {
    header('Location: ../reset-password.php?error=weak_password');
    exit;
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$statement = $pdo->prepare('UPDATE admins SET password_hash = ? WHERE email = ?');
$statement->execute([$passwordHash, $email]);

if ($statement->rowCount() === 0) {
    header('Location: ../reset-password.php?error=not_found');
    exit;
}

header('Location: ../login.html?reset=success');
exit;
