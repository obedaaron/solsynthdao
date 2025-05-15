<?php 
header('Content-Type: application/json');
require '../includes/db.php';

session_start(); // <--- Start session

$data = json_decode(file_get_contents('php://input'), true);
$wallet = trim($data['wallet'] ?? '');
$name = trim($data['name'] ?? '');
$bio = trim($data['bio'] ?? '');

if (!$wallet || !$name) {
    echo json_encode(['success' => false, 'error' => 'Required fields missing']);
    exit;
}

$stmt = $pdo->prepare("INSERT INTO users (wallet_address, name, bio) VALUES (?, ?, ?)");
try {
    $stmt->execute([$wallet, $name, $bio]);

    // ✅ Set session after saving
    $_SESSION['wallet_address'] = $wallet;

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'DB insert failed']);
}
