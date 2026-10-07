<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$dataFile = __DIR__ . '/../data/portfolio.json';

if (!file_exists($dataFile)) {
    echo json_encode(['success' => false, 'message' => 'Data file missing']);
    exit;
}

$data = json_decode(file_get_contents($dataFile), true);

if (!isset($data['analytics']) || !is_array($data['analytics'])) {
    $data['analytics'] = [
        'total_views' => 1240,
        'today_views' => 42,
        'today_date' => date('Y-m-d'),
        'unique_ips' => []
    ];
}

$analytics = &$data['analytics'];
$currentDate = date('Y-m-d');

// Reset today views if new day
if (($analytics['today_date'] ?? '') !== $currentDate) {
    $analytics['today_date'] = $currentDate;
    $analytics['today_views'] = 0;
}

// Track client IP
$clientIp = $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
$ipHash = md5($clientIp);

if (!isset($analytics['unique_ips']) || !is_array($analytics['unique_ips'])) {
    $analytics['unique_ips'] = [];
}

if (!in_array($ipHash, $analytics['unique_ips'])) {
    $analytics['unique_ips'][] = $ipHash;
}

// Increment total & today views
$analytics['total_views'] = ($analytics['total_views'] ?? 1240) + 1;
$analytics['today_views'] = ($analytics['today_views'] ?? 42) + 1;

// Save updated counts
file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));

echo json_encode([
    'success' => true,
    'total_views' => $analytics['total_views'],
    'today_views' => $analytics['today_views'],
    'unique_visitors' => count($analytics['unique_ips'])
]);
