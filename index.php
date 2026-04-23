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

// --- Metadatos dinámicos por página ---
$meta = [];

switch ($page) {
    case 'home':
        $meta['title']       = 'TV Digital 48 | Noticias, entretenimiento y contenido digital';
        $meta['description'] = 'Mantente informado con TV Digital 48. Noticias, cobertura local, entretenimiento y contenido multimedia actualizado.';
        break;

    case 'canal48':
        $meta['title']       = 'Canal 48 | Noticias en vivo y cobertura 24/7 - TV Digital 48';
        $meta['description'] = 'Sintoniza Canal 48: noticias locales, nacionales e internacionales. Cobertura en vivo, análisis y entretenimiento las 24 horas.';
        $meta['image']       = 'assets/images/favicon.png';
        break;

    case 'toptravel':
        $meta['title']       = 'Top Travel | Revista digital de viajes - TV Digital 48';
        $meta['description'] = 'Descubre los mejores destinos, hoteles exclusivos y experiencias únicas. Top Travel, tu revista digital de viajes.';
        $meta['image']       = 'assets/images/toptravel_negro.jpg';
        break;

    case 'top':
        $meta['title']       = 'Lo Más Top | Tendencias y contenido viral - TV Digital 48';
        $meta['description'] = 'Lo más visto, lo más compartido. Descubre el contenido que es tendencia en TV Digital 48.';
        break;

    case 'nosotros':
        $meta['title']       = 'Nosotros | Conoce TV Digital 48';
        $meta['description'] = 'Somos TV Universo, una plataforma multimedia que integra lo mejor del periodismo, el entretenimiento y los viajes.';
        break;

    case 'contacto':
        $meta['title']       = 'Contacto | TV Digital 48';
        $meta['description'] = 'Contáctanos para colaboraciones, publicidad o cualquier consulta. Estamos aquí para escucharte.';
        break;

    case 'post':
        $postId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($postId) {
            $metaPost = getPostById($postId);
            if ($metaPost) {
                $meta['title']       = $metaPost['title'] . ' - TV Digital 48';
                $meta['description'] = $metaPost['excerpt'] ?: truncateText(strip_tags($metaPost['content']), 160);
                $meta['image']       = $metaPost['image_url'] ?? '';
                $meta['type']        = 'article';
            }
        }
        break;

    case 'video':
        $videoId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($videoId) {
            $metaVideo = getVideoById($videoId);
            if ($metaVideo) {
                $meta['title']       = $metaVideo['title'] . ' - TV Digital 48';
                $meta['description'] = 'Mira este video en TV Digital 48: ' . $metaVideo['title'];
                $meta['image']       = $metaVideo['thumbnail'] ?? '';
                $meta['type']        = 'video.other';
            }
        }
        break;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($meta['title'] ?? 'TV Digital 48 | Noticias, entretenimiento y contenido digital', ENT_QUOTES, 'UTF-8') ?></title>
    <?php include __DIR__ . '/includes/meta.php'; ?>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
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
