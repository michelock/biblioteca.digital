<?php

declare(strict_types=1);

require_once __DIR__ . '/../models/UserModel.php';

final class UserController
{
    public function profile(int $userId): array
    {
        $model = new UserModel();
        $user = $model->findById($userId);

        if (!$user) {
            return ['success' => false, 'errors' => ['Usuario no encontrado.']];
        }

        return ['success' => true, 'user' => $user];
    }
}
