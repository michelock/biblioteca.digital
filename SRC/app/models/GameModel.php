<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';

final class GameModel
{
    public function getGames(): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->query('SELECT * FROM juegos WHERE activo = TRUE ORDER BY id ASC');
        return $stmt->fetchAll();
    }

    public function getUserProgress(int $userId): array
    {
        $pdo = Database::getConnection();
        $sql = 'SELECT pg.*, j.nombre AS juego_nombre
                FROM progreso_juegos pg
                INNER JOIN juegos j ON j.id = pg.juego_id
                WHERE pg.usuario_id = :user_id
                ORDER BY pg.actualizado_en DESC';

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':user_id' => $userId]);

        return $stmt->fetchAll();
    }

    public function saveProgress(int $userId, int $gameId, array $data): bool
    {
        $pdo = Database::getConnection();

        $sql = 'INSERT INTO progreso_juegos (usuario_id, juego_id, nivel_actual, puntuacion, precision, wpm, libros_recogidos)
                VALUES (:usuario_id, :juego_id, :nivel_actual, :puntuacion, :precision, :wpm, :libros_recogidos)
                ON CONFLICT (usuario_id, juego_id)
                DO UPDATE SET nivel_actual = EXCLUDED.nivel_actual,
                              puntuacion = EXCLUDED.puntuacion,
                              precision = EXCLUDED.precision,
                              wpm = EXCLUDED.wpm,
                              libros_recogidos = EXCLUDED.libros_recogidos,
                              actualizado_en = NOW()';

        $stmt = $pdo->prepare($sql);

        return $stmt->execute([
            ':usuario_id' => $userId,
            ':juego_id' => $gameId,
            ':nivel_actual' => $data['nivel_actual'] ?? 1,
            ':puntuacion' => $data['puntuacion'] ?? 0,
            ':precision' => $data['precision'] ?? 0,
            ':wpm' => $data['wpm'] ?? 0,
            ':libros_recogidos' => $data['libros_recogidos'] ?? 0,
        ]);
    }
}
