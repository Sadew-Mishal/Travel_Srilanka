<?php
session_start();

$host = 'localhost';
$database = 'travel_srilanka';
$username = 'root';
$password = '';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$database;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $error) {
    die('Database connection failed: ' . $error->getMessage());
}
