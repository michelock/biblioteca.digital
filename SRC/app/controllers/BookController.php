<?php

declare(strict_types=1);

require_once __DIR__ . '/../models/BookModel.php';

final class BookController
{
    public function list(?string $search = null): array
    {
        $model = new BookModel();
        return ['success' => true, 'books' => $model->listAll($search)];
    }

    public function detail(int $id): array
    {
        $model = new BookModel();
        $book = $model->findById($id);

        if (!$book) {
            return ['success' => false, 'errors' => ['Libro no encontrado.']];
        }

        return ['success' => true, 'book' => $book];
    }
}
