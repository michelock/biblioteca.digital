<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

final class Database
{
    private static ?PDO $instance = null;

    public static function getConnection(): PDO
    {
        if (self::$instance instanceof PDO) {
            return self::$instance;
        }

        self::$instance = getDatabaseConnection();
        return self::$instance;
    }
}
