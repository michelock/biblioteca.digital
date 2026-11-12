<?php

declare(strict_types=1);

function getDatabaseConnection(): PDO
{
    $host = $_ENV['DB_HOST'] ?? 'localhost';
    $port = $_ENV['DB_PORT'] ?? '5432';
    $dbname = $_ENV['DB_NAME'] ?? 'biblioteca_digital';
    $user = $_ENV['DB_USER'] ?? 'postgres';
    $password = $_ENV['DB_PASS'] ?? 'postgres';

    $dsn = sprintf(
        'pgsql:host=%s;port=%s;dbname=%s',
        $host,
        $port,
        $dbname
    );

    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    return $pdo;
}
