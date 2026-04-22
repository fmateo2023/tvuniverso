<?php
/**
 * TV Universo - Configuración principal
 * Conexión a MySQL vía PDO + constantes globales
 */

// --- Configuración de base de datos ---
define('DB_HOST', 'localhost');
define('DB_USER', 'root');          // Cambiar en cPanel
define('DB_PASS', '');              // Cambiar en cPanel
define('DB_NAME', 'tvuniverso_db');
define('DB_CHARSET', 'utf8mb4');

// --- URL base del sitio ---
define('BASE_URL', 'http://localhost/public_html');  // Cambiar en producción
define('SITE_NAME', 'TV Universo');

// --- Seguridad ---
define('SESSION_LIFETIME', 3600); // 1 hora
define('CSRF_TOKEN_NAME', 'csrf_token');

// --- Iniciar sesión segura ---
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_strict_mode', 1);
    session_start();
}

// --- Conexión PDO ---
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET,
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    error_log("Error de conexión BD: " . $e->getMessage());
    die("Error de conexión a la base de datos. Contacte al administrador.");
}

// --- Zona horaria ---
date_default_timezone_set('America/Mexico_City');
