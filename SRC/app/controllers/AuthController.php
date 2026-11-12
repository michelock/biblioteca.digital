<?php

declare(strict_types=1);

require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../helpers/validation.php';

final class AuthController
{
    public function register(array $input): array
    {
        $required = ['nombre', 'email', 'password'];
        $errors = validateRequired($required, $input);

        if ($errors) {
            return ['success' => false, 'errors' => $errors];
        }

        $nombre = sanitizeString((string) $input['nombre']);
        $email = sanitizeEmail((string) $input['email']);
        $password = (string) $input['password'];

        if (!isValidEmail($email)) {
            return ['success' => false, 'errors' => ['El correo electrónico no es válido.']];
        }

        $passwordErrors = validatePassword($password);
        if ($passwordErrors) {
            return ['success' => false, 'errors' => $passwordErrors];
        }

        $userModel = new UserModel();
        if ($userModel->findByEmail($email)) {
            return ['success' => false, 'errors' => ['El correo ya está registrado.']];
        }

        $userId = $userModel->create([
            'nombre' => $nombre,
            'apellido' => $input['apellido'] ?? null,
            'email' => $email,
            'password' => $password,
            'telefono' => $input['telefono'] ?? null,
            'rol_id' => 3,
        ]);

        ensureSessionStarted();
        $_SESSION['usuario_id'] = $userId;
        $_SESSION['usuario_email'] = $email;

        return [
            'success' => true,
            'message' => 'Usuario registrado correctamente.',
            'user_id' => $userId,
        ];
    }

    public function login(array $input): array
    {
        $required = ['email', 'password'];
        $errors = validateRequired($required, $input);

        if ($errors) {
            return ['success' => false, 'errors' => $errors];
        }

        $email = sanitizeEmail((string) $input['email']);
        $password = (string) $input['password'];

        $userModel = new UserModel();
        $user = $userModel->login($email, $password);

        if (!$user) {
            return ['success' => false, 'errors' => ['Credenciales incorrectas.']];
        }

        ensureSessionStarted();
        $_SESSION['usuario_id'] = (int) $user['id'];
        $_SESSION['usuario_email'] = $user['email'];

        return [
            'success' => true,
            'message' => 'Inicio de sesión correcto.',
            'user' => $user,
        ];
    }

    public function logout(): void
    {
        ensureSessionStarted();
        session_unset();
        session_destroy();
        redirect('/public/index.php?action=login');
    }
}
