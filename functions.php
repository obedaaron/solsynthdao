<?php
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function validateFormData($data) {
    if (empty($data['dao_name']) || empty($data['dao_symbol']) || empty($data['dao_description'])) {
        return false;
    }
    if (empty($data['token_name']) || empty($data['token_symbol']) || !is_numeric($data['token_supply'])) {
        return false;
    }
    return true;
}
?>
