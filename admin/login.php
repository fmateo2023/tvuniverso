<?php
/**
 * TV Universo - Admin Login
 */

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

// Si ya está logueado, redirigir al dashboard
if (isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrf()) {
        $error = 'Token de seguridad inválido.';
    } else {
        $username = sanitize($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            $error = 'Completa todos los campos.';
        } elseif (!loginUser($username, $password)) {
            $error = 'Usuario o contraseña incorrectos.';
        } else {
            header('Location: index.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - TV Universo</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
<div class="login-page">
    <div class="login-box">
        <div class="login-box__title">📺 TV Universo</div>
        <p class="login-box__subtitle">Panel de Administración</p>

        <?php if ($error): ?>
        <div class="login-error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <?= csrfField() ?>

            <div class="form-group">
                <label for="username">Usuario</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Tu usuario" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Tu contraseña" required>
            </div>

            <button type="submit" class="btn btn--primary" style="width:100%;justify-content:center;">Iniciar sesión</button>
        </form>

        <p style="text-align:center;margin-top:var(--space-lg);font-size:0.8rem;color:var(--text-muted);">
            <a href="../index.php" style="color:var(--blue);">← Volver al sitio</a>
        </p>
    </div>
</div>
</body>
</html>
