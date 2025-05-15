<?php
require 'includes/db.php'; // This defines $conn (MySQLi)

function createDao($daoName, $daoSymbol, $daoDescription, $tokenName, $tokenSymbol, $tokenSupply, $governanceEnabled, $voteQuorum, $voteThreshold, $voteDuration, $voteDays, $roles, $userWallet) {
    global $conn;

    // Prepare SQL statement
    $sql = "INSERT INTO daos (
        dao_name, dao_symbol, dao_description, token_name, token_symbol,
        token_supply, governance_enabled, vote_quorum, vote_threshold,
        vote_duration, vote_days, roles, user_wallet
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        return false;
    }

    $stmt->bind_param(
        "sssssiiiiisss", 
        $daoName, $daoSymbol, $daoDescription,
        $tokenName, $tokenSymbol, $tokenSupply,
        $governanceEnabled, $voteQuorum, $voteThreshold,
        $voteDuration, $voteDays, $roles, $userWallet
    );

    if (!$stmt->execute()) {
        error_log("Execute failed: " . $stmt->error);
        return false;
    }

    return true;
}
?>
