<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['wallet_address'])) {
    header("Location: ../index.php");
    exit();
}

$wallet_address = $_SESSION['wallet_address'];
$dao_name = $_POST['daoName'] ?? '';
$description = $_POST['daoDescription'] ?? '';
$governance_model = $_POST['governanceModel'] ?? '';
$voting_period = intval($_POST['votingPeriod'] ?? 0);
$minimum_quorum = intval($_POST['minimumQuorum'] ?? 0);

// Basic validation
if (empty($dao_name) || empty($description) || empty($governance_model)) {
    die("Missing required fields.");
}

$sql = "INSERT INTO daos (creator_wallet, dao_name, description, governance_model, voting_period, minimum_quorum) 
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssii", $wallet_address, $dao_name, $description, $governance_model, $voting_period, $minimum_quorum);

if ($stmt->execute()) {
    // Store dao_id in session if you need it for token setup
    $_SESSION['dao_id'] = $stmt->insert_id;
    header("Location: ../token_setup.php");
    exit();
} else {
    echo "Error saving DAO: " . $stmt->error;
}
?>
