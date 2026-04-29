<?php

declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

function currentUser(): ?array
{
    return $_SESSION['user'] ?? null;
}

function loginUser(array $user): void
{
    $_SESSION['user'] = [
        'id' => $user['id'],
        'first_name' => $user['first_name'],
        'last_name' => $user['last_name'],
        'email' => $user['email'],
    ];
}

function logoutUser(): void
{
    unset($_SESSION['user']);
}
