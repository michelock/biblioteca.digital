<?php

declare(strict_types=1);

function ensureSessionStarted(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function setFlash(string $key, string $message): void
{
    ensureSessionStarted();
    $_SESSION['flash'][$key] = $message;
}

function getFlash(string $key): ?string
{
    ensureSessionStarted();

    if (!isset($_SESSION['flash'][$key])) {
        return null;
    }

    $message = $_SESSION['flash'][$key];
    unset($_SESSION['flash'][$key]);

    return $message;
}

function redirect(string $path): void
{
    header('Location: ' . $path);
    exit;
}

function requireAuth(): void
{
    ensureSessionStarted();

    if (!isset($_SESSION['usuario_id'])) {
        redirect('/public/index.php?action=login');
    }
}
