<?php
/**
 * TV Universo - Metadatos SEO, Open Graph y Twitter Cards
 * Incluir dentro del <head> en index.php
 * Variables esperadas: $meta (array con title, description, image, type)
 */

$defaultTitle       = 'TV Digital 48 | Noticias, entretenimiento y contenido digital';
$defaultDescription = 'Mantente informado con TV Digital 48. Noticias, cobertura local, entretenimiento y contenido multimedia actualizado.';
$defaultImage       = BASE_URL . '/assets/images/og-image.png';
$defaultType        = 'website';

$metaTitle       = $meta['title']       ?? $defaultTitle;
$metaDescription = $meta['description'] ?? $defaultDescription;
$metaImage       = $meta['image']       ?? $defaultImage;
$metaType        = $meta['type']        ?? $defaultType;

// URL canónica dinámica
$metaUrl = BASE_URL . '/' . ltrim($_SERVER['REQUEST_URI'], '/');

// Asegurar URL absoluta en imagen
if ($metaImage && !str_starts_with($metaImage, 'http')) {
    $metaImage = BASE_URL . '/' . ltrim($metaImage, '/');
}
?>
    <meta name="description" content="<?= htmlspecialchars($metaDescription, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="robots" content="index, follow">
    <meta name="author" content="TV Universo">
    <link rel="canonical" href="<?= htmlspecialchars($metaUrl, ENT_QUOTES, 'UTF-8') ?>">

    <!-- Open Graph -->
    <meta property="og:type" content="<?= htmlspecialchars($metaType, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:site_name" content="TV Digital 48">
    <meta property="og:title" content="<?= htmlspecialchars($metaTitle, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:description" content="<?= htmlspecialchars($metaDescription, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:image" content="<?= htmlspecialchars($metaImage, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:url" content="<?= htmlspecialchars($metaUrl, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:locale" content="es_MX">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($metaTitle, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($metaDescription, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($metaImage, ENT_QUOTES, 'UTF-8') ?>">
