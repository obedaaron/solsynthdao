<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// phantom_login.php
require './includes/db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $walletAddress = $_POST['walletAddress'] ?? null;

    if (!$walletAddress) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'error' => 'Wallet address is required']);
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE wallet_address = ?");
    $stmt->bind_param("s", $walletAddress);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $loginMethod = 'wallet';
$stmt = $conn->prepare("INSERT INTO users (wallet_address, login_method, created_at) VALUES (?, ?, NOW())");
$stmt->bind_param("ss", $walletAddress, $loginMethod);

        $stmt->execute();
    }

    session_start();
    $_SESSION['wallet_address'] = $walletAddress;
    $_SESSION['login_method'] = 'phantom';

    echo json_encode(['status' => 'success']);
}
?>
