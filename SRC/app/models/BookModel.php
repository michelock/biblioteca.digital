<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';

final class BookModel
{
    public function listAll(?string $search = null): array
    {
        $pdo = Database::getConnection();

        $sql = 'SELECT l.*, c.nombre AS categoria, a.nombre AS autor_nombre, a.apellido AS autor_apellido
                FROM libros l
                LEFT JOIN categorias c ON c.id = l.categoria_id
                LEFT JOIN autores a ON a.id = l.autor_id';

        $params = [];

        if ($search !== null && trim($search) !== '') {
            $sql .= ' WHERE l.titulo ILIKE :search OR a.nombre ILIKE :search OR c.nombre ILIKE :search';
            $params[':search'] = '%' . trim($search) . '%';
        }

        $sql .= ' ORDER BY l.id DESC';

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('SELECT * FROM libros WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);

        $book = $stmt->fetch();
        return $book ?: null;
    }

    public function getFeatured(): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->query('SELECT * FROM libros WHERE destacado = TRUE ORDER BY id DESC LIMIT 6');
        return $stmt->fetchAll();
    }
}
