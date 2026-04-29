<?php

declare(strict_types=1);

define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
define('DB_PORT', getenv('DB_PORT') ? (int)getenv('DB_PORT') : 3306);
define('DB_NAME', getenv('DB_NAME') ?: 'lumio');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): void
{
    header("Location: {$path}");
    exit;
}
