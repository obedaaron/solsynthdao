<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'includes/db.php';

$dao_name = $_POST['dao_name'];
$dao_symbol = $_POST['dao_symbol'];
$dao_description = $_POST['dao_description'];
$token_name = $_POST['token_name'];
$token_symbol = $_POST['token_symbol'];
$token_supply = isset($_POST['token_supply']) ? (int)$_POST['token_supply'] : 0;
$governance_enabled = isset($_POST['governance_enabled']) ? 1 : 0;
$vote_quorum = isset($_POST['vote_quorum']) ? (int)$_POST['vote_quorum'] : 0;
$vote_threshold = isset($_POST['vote_threshold']) ? (int)$_POST['vote_threshold'] : 0;
$vote_duration = isset($_POST['vote_duration']) ? (int)$_POST['vote_duration'] : 0;
$vote_days = $_POST['vote_days'];
$roles_array = isset($_POST['roles']) ? $_POST['roles'] : [];
$roles = json_encode($roles_array);
$created_at = date('Y-m-d H:i:s');

$stmt = $conn->prepare("INSERT INTO daos (
    dao_name, dao_symbol, dao_description,
    token_name, token_symbol, token_supply,
    governance_enabled, vote_quorum, vote_threshold,
    vote_duration, vote_days, roles, created_at
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param(
    "ssssssiiiisss",
    $dao_name, $dao_symbol, $dao_description,
    $token_name, $token_symbol, $token_supply,
    $governance_enabled, $vote_quorum, $vote_threshold,
    $vote_duration, $vote_days, $roles, $created_at
);

if ($stmt->execute()) {
    echo "DAO created successfully!";
} else {
    echo "Execute error: " . $stmt->error;
}
?>
