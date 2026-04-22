<?php
/**
 * TV Universo - Sistema de Autenticación
 * Login, logout, verificación de sesión y roles
 */

require_once __DIR__ . '/../config.php';

/** Intenta autenticar un usuario */
function loginUser(string $username, string $password): bool {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Regenerar ID de sesión para prevenir session fixation
        session_regenerate_id(true);
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['username']  = $user['username'];
        $_SESSION['role']      = $user['role'];
        $_SESSION['logged_in'] = true;
        $_SESSION['login_time'] = time();
        return true;
    }
    return false;
}

/** Cierra la sesión del usuario */
function logoutUser(): void {
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $p["path"], $p["domain"], $p["secure"], $p["httponly"]);
    }
    session_destroy();
}

/** Verifica si el usuario está autenticado */
function isLoggedIn(): bool {
    if (empty($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        return false;
    }
    // Verificar expiración de sesión
    if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time']) > SESSION_LIFETIME) {
        logoutUser();
        return false;
    }
    return true;
}

/** Verifica si el usuario tiene rol de admin */
function isAdmin(): bool {
    return isLoggedIn() && ($_SESSION['role'] ?? '') === 'admin';
}

/** Protege una ruta: redirige al login si no está autenticado */
function requireAuth(): void {
    if (!isLoggedIn()) {
        header('Location: ' . BASE_URL . '/admin/login.php');
        exit;
    }
}

/** Protege una ruta: solo admin */
function requireAdmin(): void {
    requireAuth();
    if (!isAdmin()) {
        header('Location: ' . BASE_URL . '/admin/login.php');
        exit;
    }
}

/** Crea un hash seguro de contraseña */
function hashPassword(string $password): string {
    return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
}

/** Obtiene datos del usuario actual */
function currentUser(): ?array {
    if (!isLoggedIn()) return null;
    return [
        'id'       => $_SESSION['user_id'],
        'username' => $_SESSION['username'],
        'role'     => $_SESSION['role'],
    ];
}
