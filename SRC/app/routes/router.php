<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../controllers/BookController.php';
require_once __DIR__ . '/../controllers/LoanController.php';
require_once __DIR__ . '/../controllers/GameController.php';

function sendJson(array $payload, int $status = 200): void
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

function handleRequest(): void
{
    ensureSessionStarted();

    $action = $_GET['action'] ?? 'health';
    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

    if ($action === 'health') {
        sendJson([
            'status' => 'ok',
            'app' => APP_NAME,
            'environment' => APP_ENV,
        ]);
    }

    if ($action === 'register' && $method === 'POST') {
        $controller = new AuthController();
        $response = $controller->register($_POST);
        sendJson($response, $response['success'] ? 201 : 400);
    }

    if ($action === 'login' && $method === 'POST') {
        $controller = new AuthController();
        $response = $controller->login($_POST);
        sendJson($response, $response['success'] ? 200 : 401);
    }

    if ($action === 'logout') {
        $controller = new AuthController();
        $controller->logout();
    }

    if ($action === 'profile' && $method === 'GET') {
        requireAuth();
        $userId = (int) ($_SESSION['usuario_id'] ?? 0);
        $controller = new UserController();
        $response = $controller->profile($userId);
        sendJson($response, $response['success'] ? 200 : 404);
    }

    if ($action === 'books' && $method === 'GET') {
        $controller = new BookController();
        $search = $_GET['search'] ?? null;
        $response = $controller->list(is_string($search) ? $search : null);
        sendJson($response, 200);
    }

    if ($action === 'book-detail' && $method === 'GET') {
        $id = (int) ($_GET['id'] ?? 0);
        $controller = new BookController();
        $response = $controller->detail($id);
        sendJson($response, $response['success'] ? 200 : 404);
    }

    if ($action === 'loans' && $method === 'GET') {
        requireAuth();
        $userId = (int) ($_SESSION['usuario_id'] ?? 0);
        $controller = new LoanController();
        $response = $controller->listByUser($userId);
        sendJson($response, 200);
    }

    if ($action === 'games' && $method === 'GET') {
        $controller = new GameController();
        $response = $controller->list();
        sendJson($response, 200);
    }

    if ($action === 'game-progress' && $method === 'GET') {
        requireAuth();
        $userId = (int) ($_SESSION['usuario_id'] ?? 0);
        $controller = new GameController();
        $response = $controller->progress($userId);
        sendJson($response, 200);
    }

    if ($action === 'save-game-progress' && $method === 'POST') {
        requireAuth();
        $userId = (int) ($_SESSION['usuario_id'] ?? 0);
        $gameId = (int) ($_POST['game_id'] ?? 0);
        $controller = new GameController();
        $response = $controller->saveProgress($userId, $gameId, $_POST);
        sendJson($response, $response['success'] ? 200 : 400);
    }

    sendJson(['success' => false, 'message' => 'Ruta no encontrada.'], 404);
}
