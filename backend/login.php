<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../login.html');
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($email === '' || $password === '') {
    header('Location: ../login.html?error=missing_fields');
    exit;
}

$statement = $pdo->prepare('SELECT id, name, email, password_hash FROM users WHERE email = ?');
$statement->execute([$email]);
$user = $statement->fetch();

if (!$user || !password_verify($password, $user['password_hash'])) {
    header('Location: ../login.html?error=invalid_login');
    exit;
}

$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['name'];
$_SESSION['user_email'] = $user['email'];

header('Location: ../booking.html?login=success');
exit;
