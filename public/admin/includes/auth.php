<?php
require_once __DIR__ . '/../../../includes/functions.php';
session_start();

function require_login() {
    if (empty($_SESSION['admin_id'])) {
        header('Location: /admin/login.php');
        exit;
    }
}

function current_admin_name(): string {
    return $_SESSION['admin_name'] ?? 'المشرف';
}
