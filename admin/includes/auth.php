<?php
session_start();
require_once __DIR__ . '/../../includes/functions.php';

function admin_user(): ?array
{
    return $_SESSION['admin_user'] ?? null;
}

function require_admin(): void
{
    if (!admin_user()) {
        header('Location: login.php');
        exit;
    }
}

function verify_admin_password(string $password, string $stored): bool
{
    if (strlen($stored) === 64 && ctype_xdigit($stored)) {
        return hash_equals($stored, hash('sha256', $password));
    }

    return password_verify($password, $stored);
}

function upload_file(string $field): ?string
{
    if (empty($_FILES[$field]['name']) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    if (!is_dir(UPLOAD_DIR)) {
        mkdir(UPLOAD_DIR, 0775, true);
    }

    $extension = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'pdf', 'doc', 'docx', 'xls', 'xlsx'];
    if (!in_array($extension, $allowed, true)) {
        return null;
    }

    $name = date('YmdHis') . '-' . bin2hex(random_bytes(5)) . '.' . $extension;
    $target = UPLOAD_DIR . $name;
    move_uploaded_file($_FILES[$field]['tmp_name'], $target);

    return $name;
}

