<?php
session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$wallet = trim($data['wallet'] ?? '');

if (!$wallet) {
    echo json_encode(['success' => false, 'error' => 'Wallet required']);
    exit;
}

// Optional: you could include check-user.php here
$_SESSION['wallet_address'] = $wallet;

echo json_encode(['success' => true]);
