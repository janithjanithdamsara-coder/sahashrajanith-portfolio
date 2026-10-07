<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('PORTFOLIO_DATA_FILE', __DIR__ . '/../data/portfolio.json');

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

function require_admin_login() {
    if (!is_admin_logged_in()) {
        header('Location: login.php');
        exit;
    }
}
