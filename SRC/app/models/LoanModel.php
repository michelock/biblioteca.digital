<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';

final class LoanModel
{
    public function getByUser(int $userId): array
    {
        $pdo = Database::getConnection();

        $sql = 'SELECT p.*, l.titulo, c.codigo_barras
                FROM prestamos p
                INNER JOIN copias_libro c ON c.id = p.copia_id
                INNER JOIN libros l ON l.id = c.libro_id
                WHERE p.usuario_id = :user_id
                ORDER BY p.fecha_prestamo DESC';

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':user_id' => $userId]);

        return $stmt->fetchAll();
    }
}
