<?php
session_start();
require '../includes/db.php';

$data = json_decode(file_get_contents("php://input"), true);
$wallet = trim($data['wallet_address']);

if (!$wallet) {
  echo json_encode(['success' => false, 'error' => 'No wallet']);
  exit;
}

$stmt = $conn->prepare("SELECT * FROM users WHERE wallet_address = ?");
$stmt->bind_param("s", $wallet);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
  // Create new user
  $stmt = $conn->prepare("INSERT INTO users (wallet_address, login_method) VALUES (?, 'wallet')");
  $stmt->bind_param("s", $wallet);
  $stmt->execute();
  $user_id = $stmt->insert_id;
} else {
  $user_id = $user['id'];
}

$_SESSION['user_id'] = $user_id;
echo json_encode(['success' => true]);
?>
