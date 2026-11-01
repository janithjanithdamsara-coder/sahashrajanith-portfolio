<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('PORTFOLIO_DATA_FILE', __DIR__ . '/../data/portfolio.json');

// Secret key to access admin area: e.g. https://sahashrajanith.site/admin?key=sj2026
define('ADMIN_SECRET_KEY', 'sj2026');

function get_portfolio_data() {
    if (!file_exists(PORTFOLIO_DATA_FILE)) {
        return [];
    }
    return json_decode(file_get_contents(PORTFOLIO_DATA_FILE), true);
}

function save_portfolio_data($data) {
    return file_put_contents(PORTFOLIO_DATA_FILE, json_encode($data, JSON_PRETTY_PRINT));
}

function is_admin_logged_in() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function is_admin_key_authorized() {
    return isset($_SESSION['admin_key_authorized']) && $_SESSION['admin_key_authorized'] === true;
}

function check_admin_gate() {
    // 1. If already logged in as admin, full access granted
    if (is_admin_logged_in()) {
        return true;
    }

    // 2. Check if the secret key was provided in the URL (?key=... or ?access=...)
    $providedKey = trim($_GET['key'] ?? $_GET['access'] ?? '');
    if (!empty($providedKey) && $providedKey === ADMIN_SECRET_KEY) {
        $_SESSION['admin_key_authorized'] = true;
        // Clean URL so key is not visible in browser address bar or history
        header('Location: login.php');
        exit;
    }

    // 3. If session has been authorized with the key, allow viewing login page
    if (is_admin_key_authorized()) {
        return true;
    }

    // 4. Unauthorized attempt to access admin: silently redirect to public homepage
    header('Location: ../index.php');
    exit;
}

function require_admin_login() {
    if (!is_admin_logged_in()) {
        check_admin_gate();
        header('Location: login.php');
        exit;
    }
}
