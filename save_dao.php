<?php
// save_dao.php
require '../includes/db.php'; // Adjust if your DB connection file is named differently

$creatorWallet = $_POST['creator_wallet'] ?? '';
$daoName = $_POST['name'] ?? '';
$description = $_POST['description'] ?? '';
$treasuryWallet = $_POST['treasury_wallet'] ?? ''; // Optional, if available
$governanceToken = $_POST['governance_token'] ?? ''; // Optional
$tokenMintAddress = $_POST['token_mint_address'] ?? ''; // Optional

$governance = $_POST['governance'] ?? '';
$votingDuration = $_POST['votingDuration'] ?? '';
$quorum = $_POST['quorum'] ?? '';
$proposalTypes = $_POST['proposalTypes'] ?? '';
$createdAt = date('Y-m-d H:i:s');

$sql = "INSERT INTO daos (
    creator_wallet, dao_name, description, treasury_wallet,
    created_at, governance_token, token_mint_address,
    governance, voting_duration, quorum, proposal_types
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssssss",
    $creatorWallet, $daoName, $description, $treasuryWallet,
    $createdAt, $governanceToken, $tokenMintAddress,
    $governance, $votingDuration, $quorum, $proposalTypes
);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}

$conn->close();
