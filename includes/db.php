<?php

$host = 'localhost';
$user = 'root';
$pass = ''; // your MySQL password
$db   = 'solsynth';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}
?>
