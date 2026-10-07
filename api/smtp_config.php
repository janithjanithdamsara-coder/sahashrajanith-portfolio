<?php
/**
 * ==========================================================================
 * SAHASHRA JANITH PORTFOLIO - SMTP EMAIL CONFIGURATION
 * ==========================================================================
 * File Location: c:\xampp\htdocs\janithme\api\smtp_config.php
 * 
 * INSTRUCTIONS:
 * 1. Replace 'YOUR_16_DIGIT_APP_PASSWORD_HERE' below with your 16-character
 *    Google App Password (e.g. 'abcd efgh ijkl mnop').
 * 2. Save this file.
 */

return [
    // Your Gmail address
    'smtp_user'       => 'sahashrajanith@gmail.com',

    // PASTE YOUR 16-CHARACTER GMAIL APP PASSWORD HERE:
    'smtp_pass'       => 'ljan ezog mste jytx',

    // Destination email where client messages will be sent
    'recipient_email' => 'sahashrajanith@gmail.com',

    // Gmail Server Settings
    'smtp_host'       => 'smtp.gmail.com',
    'smtp_port'       => 587,
    'smtp_secure'     => 'tls'
];
