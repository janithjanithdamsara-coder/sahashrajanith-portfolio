<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$dataFile = __DIR__ . '/../data/portfolio.json';

if (!file_exists($dataFile)) {
    http_response_code(404);
    echo json_encode(['error' => 'Data file not found']);
    exit;
}

$jsonContent = file_get_contents($dataFile);
$data = json_decode($jsonContent, true);

// Exclude sensitive information before outputting public data
if (isset($data['admin_password_hash'])) {
    unset($data['admin_password_hash']);
}
if (isset($data['messages'])) {
    unset($data['messages']);
}

echo json_encode($data, JSON_PRETTY_PRINT);
