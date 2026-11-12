<?php

declare(strict_types=1);

function sanitizeString(string $value): string
{
    return trim(strip_tags($value));
}

function sanitizeEmail(string $email): string
{
    return strtolower(trim(filter_var($email, FILTER_SANITIZE_EMAIL)));
}

function validateRequired(array $fields, array $data): array
{
    $errors = [];

    foreach ($fields as $field) {
        if (!isset($data[$field]) || sanitizeString((string) $data[$field]) === '') {
            $errors[] = "El campo {$field} es obligatorio.";
        }
    }

    return $errors;
}

function validatePassword(string $password): array
{
    $errors = [];

    if (strlen($password) < 8) {
        $errors[] = 'La contraseña debe tener al menos 8 caracteres.';
    }

    if (!preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
        $errors[] = 'La contraseña debe incluir al menos una mayúscula y un número.';
    }

    return $errors;
}

function isValidEmail(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}
