<?php

declare(strict_types=1);

require_once __DIR__ . '/../models/LoanModel.php';

final class LoanController
{
    public function listByUser(int $userId): array
    {
        $model = new LoanModel();
        return ['success' => true, 'loans' => $model->getByUser($userId)];
    }
}
