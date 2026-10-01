<?php
require_once __DIR__ . '/database.php';

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function setting(string $key, string $fallback = ''): string
{
    static $settings = null;

    if ($settings === null) {
        try {
            $rows = db()->query('SELECT setting_key, setting_value FROM settings')->fetchAll();
            $settings = [];
            foreach ($rows as $row) {
                $settings[$row['setting_key']] = $row['setting_value'];
            }
        } catch (Throwable $exception) {
            $settings = [];
        }
    }

    return $settings[$key] ?? $fallback;
}

function rows(string $sql, array $params = []): array
{
    $statement = db()->prepare($sql);
    $statement->execute($params);
    return $statement->fetchAll();
}

function row(string $sql, array $params = []): ?array
{
    $statement = db()->prepare($sql);
    $statement->execute($params);
    $result = $statement->fetch();
    return $result ?: null;
}

function asset(string $path): string
{
    $base = trim(BASE_URL);
    return ($base ? rtrim($base, '/') . '/' : '') . 'assets/' . ltrim($path, '/');
}

function upload_url(?string $path): string
{
    if (!$path) {
        return asset('img/placeholder.svg');
    }

    $base = trim(UPLOAD_URL);
    return ($base ? rtrim($base, '/') . '/' : 'uploads/') . ltrim($path, '/');
}

function active_menu(string $file): string
{
    return basename($_SERVER['SCRIPT_NAME']) === $file ? ' class="is-active"' : '';
}

function excerpt(?string $text, int $length = 160): string
{
    $clean = trim(strip_tags((string) $text));
    if (mb_strlen($clean) <= $length) {
        return $clean;
    }

    return mb_substr($clean, 0, $length - 3) . '...';
}
