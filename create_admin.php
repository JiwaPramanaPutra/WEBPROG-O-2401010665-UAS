<?php
include 'includes/config.php';

// Ganti username & password di sini
$username = 'admin';
$password = password_hash('123456', PASSWORD_DEFAULT); // password = 123456

$stmt = $pdo->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
$stmt->execute([$username, $password]);

echo "Admin berhasil dibuat!";
?>
