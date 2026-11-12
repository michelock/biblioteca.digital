<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';

final class UserModel
{
    public function create(array $data): int
    {
        $pdo = Database::getConnection();

        $sql = 'INSERT INTO usuarios (nombre, apellido, email, password_hash, telefono, rol_id, activo, avatar_url)
                VALUES (:nombre, :apellido, :email, :password_hash, :telefono, :rol_id, :activo, :avatar_url)';

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nombre' => $data['nombre'],
            ':apellido' => $data['apellido'] ?? null,
            ':email' => strtolower(trim($data['email'])),
            ':password_hash' => password_hash($data['password'], PASSWORD_BCRYPT),
            ':telefono' => $data['telefono'] ?? null,
            ':rol_id' => $data['rol_id'] ?? 3,
            ':activo' => true,
            ':avatar_url' => $data['avatar_url'] ?? null,
        ]);

        return (int) $pdo->lastInsertId();
    }

    public function findByEmail(string $email): ?array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => strtolower(trim($email))]);

        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function findById(int $id): ?array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);

        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function login(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);

        if (!$user) {
            return null;
        }

        if (!password_verify($password, (string) $user['password_hash'])) {
            return null;
        }

        return $user;
    }
}
