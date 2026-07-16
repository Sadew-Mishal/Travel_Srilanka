<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../admin-login.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($email === '' || $password === '') {
    header('Location: ../admin-login.php?error=missing');
    exit;
}

$statement = $pdo->prepare('SELECT id, name, email, password_hash FROM admins WHERE email = ?');
$statement->execute([$email]);
$admin = $statement->fetch();

if (!$admin || !password_verify($password, $admin['password_hash'])) {
    header('Location: ../admin-login.php?error=invalid');
    exit;
}

$_SESSION['admin_id'] = $admin['id'];
$_SESSION['admin_name'] = $admin['name'];
$_SESSION['admin_email'] = $admin['email'];

header('Location: ../admin-dashboard.php');
exit;
