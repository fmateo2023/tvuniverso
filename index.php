<?php
/**
 * TV Universo - Router Principal
 * Enruta las peticiones a las páginas correspondientes
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/auth.php';

// Obtener la página solicitada
$page = isset($_GET['page']) ? sanitize($_GET['page']) : 'home';

// Páginas válidas
$validPages = ['home', 'canal48', 'top', 'toptravel', 'nosotros', 'contacto', 'post', 'video'];

if (!in_array($page, $validPages)) {
    $page = 'home';
}

// Cargar settings globales
$settings = getAllSettings();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TV Universo - Canal 48 y Top Travel. Tu ventana al mundo.">
    <title><?= SITE_NAME ?> - <?= ucfirst($page) ?></title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="icon" type="image/jpeg" href="assets/images/canal48.jpg">
</head>
<body>

<?php include __DIR__ . '/includes/navbar.php'; ?>

<main>
    <?php include __DIR__ . '/pages/' . $page . '.php'; ?>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>

<button class="scroll-top" id="scrollTopBtn" onclick="window.scrollTo({top:0,behavior:'smooth'})" aria-label="Volver arriba">↑</button>

<script src="assets/js/main.js"></script>
</body>
</html>
