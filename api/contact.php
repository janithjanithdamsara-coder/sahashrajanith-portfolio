<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    $input = $_POST;
}

$name    = isset($input['name']) ? trim($input['name']) : '';
$email   = isset($input['email']) ? trim($input['email']) : '';
$subject = isset($input['subject']) ? trim($input['subject']) : 'Portfolio Inquiry';
$message = isset($input['message']) ? trim($input['message']) : '';

if (empty($name) || empty($email) || empty($message)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please fill in all required fields (Name, Email, Message).']);
    exit;
}

// 1. Always save message locally to data/portfolio.json so no message is ever lost
$dataFile = __DIR__ . '/../data/portfolio.json';
if (file_exists($dataFile)) {
    $data = json_decode(file_get_contents($dataFile), true);
    if (!isset($data['messages'])) {
        $data['messages'] = [];
    }
    $newMessage = [
        'id'      => 'msg_' . time() . '_' . rand(100, 999),
        'name'    => htmlspecialchars($name),
        'email'   => htmlspecialchars($email),
        'subject' => htmlspecialchars($subject),
        'message' => htmlspecialchars($message),
        'date'    => date('Y-m-d H:i:s'),
        'read'    => false
    ];
    array_unshift($data['messages'], $newMessage);
    file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));
}

// 2. Load SMTP Config
$smtpConfig = [];
$configFile = __DIR__ . '/smtp_config.php';
if (file_exists($configFile)) {
    $smtpConfig = require $configFile;
}

$emailSent = false;
$smtpError = '';

if (!empty($smtpConfig['smtp_pass']) && $smtpConfig['smtp_pass'] !== 'YOUR_16_DIGIT_APP_PASSWORD_HERE') {
    $smtpResult = sendSmtpMailCurl($smtpConfig, $name, $email, $subject, $message);
    if ($smtpResult['success']) {
        $emailSent = true;
    } else {
        $smtpError = $smtpResult['error'];
    }
}

echo json_encode([
    'success'    => true,
    'email_sent' => $emailSent,
    'message'    => 'Thank you for reaching out! Your message has been received by Sahashra Janith.',
    'smtp_note'  => $emailSent ? 'Delivered via Gmail SMTP' : ($smtpError ? 'Saved to system (' . $smtpError . ')' : 'Saved to system dashboard')
]);

/**
 * Robust cURL Gmail SMTP Mailer with IPv4 fallback
 */
function sendSmtpMailCurl($config, $senderName, $senderEmail, $subject, $bodyText) {
    $user = $config['smtp_user'] ?? '';
    $pass = str_replace(' ', '', $config['smtp_pass'] ?? '');
    $recipient = $config['recipient_email'] ?? $user;

    if (!function_exists('curl_init')) {
        return ['success' => false, 'error' => 'cURL PHP extension disabled'];
    }

    $ch = curl_init();

    $htmlBody = "
    <div style='font-family: Arial, sans-serif; background:#0d1117; color:#ffffff; padding:24px; border-radius:12px; border:1px solid #00f2fe;'>
        <h2 style='color:#00f2fe; margin-top:0;'>🚀 New Portfolio Message</h2>
        <p><strong>Sender Name:</strong> " . htmlspecialchars($senderName) . "</p>
        <p><strong>Sender Email:</strong> <a href='mailto:" . htmlspecialchars($senderEmail) . "' style='color:#00f2fe;'>" . htmlspecialchars($senderEmail) . "</a></p>
        <p><strong>Subject:</strong> " . htmlspecialchars($subject) . "</p>
        <hr style='border:0; border-top:1px solid rgba(255,255,255,0.1); margin:16px 0;' />
        <p><strong>Message:</strong></p>
        <div style='background:rgba(255,255,255,0.05); padding:16px; border-radius:8px; border-left:3px solid #00f2fe;'>
            " . nl2br(htmlspecialchars($bodyText)) . "
        </div>
    </div>";

    $headers = [
        "From: \"$senderName (Portfolio)\" <$user>",
        "Reply-To: \"$senderName\" <$senderEmail>",
        "To: <$recipient>",
        "Subject: Portfolio Contact: $subject",
        "MIME-Version: 1.0",
        "Content-Type: text/html; charset=UTF-8"
    ];

    $payload = implode("\r\n", $headers) . "\r\n\r\n" . $htmlBody;

    curl_setopt($ch, CURLOPT_URL, 'smtps://smtp.gmail.com:465');
    curl_setopt($ch, CURLOPT_PORT, 465);
    curl_setopt($ch, CURLOPT_USE_SSL, CURLUSESSL_ALL);
    curl_setopt($ch, CURLOPT_USERPWD, "$user:$pass");
    curl_setopt($ch, CURLOPT_MAIL_FROM, "<$user>");
    curl_setopt($ch, CURLOPT_MAIL_RCPT, ["<$recipient>"]);
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 6); // 6 second max timeout so page never hangs

    $stream = fopen('php://memory', 'r+');
    fwrite($stream, $payload);
    rewind($stream);

    curl_setopt($ch, CURLOPT_READFUNCTION, function($ch, $fd, $length) use (&$stream) {
        return fread($stream, $length);
    });
    curl_setopt($ch, CURLOPT_UPLOAD, true);

    $exec = curl_exec($ch);
    $error = curl_error($ch);
    $errno = curl_errno($ch);
    curl_close($ch);
    fclose($stream);

    if ($exec) {
        return ['success' => true];
    } else {
        return ['success' => false, 'error' => "cURL SMTP Error ($errno): $error"];
    }
}
