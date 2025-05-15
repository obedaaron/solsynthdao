<?php
// egen.php
header('Content-Type: application/json');

$description = $_POST['description'] ?? '';

$apiKey = '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';
$apiUrl = 'https://openrouter.ai/api/v1/chat/completions';

$data = [
    'model' => 'openai/gpt-3.5-turbo', // Or use mistral/mistral-7b-instruct, anthropic/claude-3-haiku, etc.
    'messages' => [
        ['role' => 'system', 'content' => 'You are an assistant that extracts DAO configuration details from a user description. ONLY return valid JSON with these keys: name, description, governance, votingDuration, quorum, and proposalTypes. No explanations or extra text.'],
        ['role' => 'user', 'content' => $description]
    ]
];

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $apiKey,
    'Content-Type: application/json',
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
var_dump($response); exit;
curl_close($ch);

$responseData = json_decode($response, true);
$configText = $responseData['choices'][0]['message']['content'] ?? '{}';

$config = json_decode($configText, true);

echo json_encode(['success' => true, 'config' => $config]);
?>
