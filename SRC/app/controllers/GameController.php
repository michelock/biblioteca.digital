<?php

declare(strict_types=1);

require_once __DIR__ . '/../models/GameModel.php';

final class GameController
{
    public function list(): array
    {
        $model = new GameModel();
        return ['success' => true, 'games' => $model->getGames()];
    }

    public function progress(int $userId): array
    {
        $model = new GameModel();
        return ['success' => true, 'progress' => $model->getUserProgress($userId)];
    }

    public function saveProgress(int $userId, int $gameId, array $data): array
    {
        $model = new GameModel();
        $saved = $model->saveProgress($userId, $gameId, $data);

        if (!$saved) {
            return ['success' => false, 'errors' => ['No se pudo guardar el progreso.']];
        }

        return ['success' => true, 'message' => 'Progreso guardado correctamente.'];
    }
}
