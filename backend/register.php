<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../login.html');
    exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($name === '' || $email === '' || $password === '') {
    header('Location: ../login.html?error=missing_fields');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ../login.html?error=invalid_email');
    exit;
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

try {
    $statement = $pdo->prepare(
        'INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)'
    );
    $statement->execute([$name, $email, $passwordHash]);

    header('Location: ../login.html?registered=1');
    exit;
} catch (PDOException $error) {
    if ($error->getCode() === '23000') {
        header('Location: ../login.html?error=email_exists');
        exit;
    }

    die('Registration failed: ' . $error->getMessage());
}
