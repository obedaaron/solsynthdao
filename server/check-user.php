<?php
header('Content-Type: application/json');
require '../includes/db.php';

$data = json_decode(file_get_contents('php://input'), true);
$wallet = trim($data['wallet'] ?? '');

if (!$wallet) {
    echo json_encode(['error' => 'Wallet address required']);
    exit;
}

$stmt = $pdo->prepare("SELECT id FROM users WHERE wallet_address = ?");
$stmt->execute([$wallet]);

echo json_encode(['exists' => $stmt->fetch() !== false]);
