<?php
/**
 * TV Universo - Admin Layout
 * Sidebar + header compartido para todas las páginas admin
 */

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';
requireAuth();

$user = currentUser();
$currentAdmin = basename($_SERVER['PHP_SELF'], '.php');

function adminLink(string $file, string $label, string $icon, string $current): string {
    $active = ($current === $file) ? 'active' : '';
    return "<a href='{$file}.php' class='{$active}'>{$icon} {$label}</a>";
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
<div class="admin-layout">
    <!-- Sidebar Toggle -->
    <button class="sidebar-toggle" id="sidebarToggle" aria-label="Menú">☰</button>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar__logo">
            📺 TV Universo
            <small>Panel de Administración</small>
            <small style="color:#555;font-size:0.6rem;margin-top:4px;">v1.0.1</small>
        </div>

        <nav class="sidebar__nav">
            <div class="sidebar__section">Principal</div>
            <?= adminLink('index', 'Dashboard', '📊', $currentAdmin) ?>

            <div class="sidebar__section">Contenido</div>
            <?= adminLink('posts', 'Noticias', '📰', $currentAdmin) ?>
            <?= adminLink('videos', 'Videos', '🎥', $currentAdmin) ?>
            <?= adminLink('categories', 'Categorías', '🗂️', $currentAdmin) ?>

            <div class="sidebar__section">Secciones</div>
            <?= adminLink('home', 'Home', '🏠', $currentAdmin) ?>
            <?= adminLink('canal48', 'Canal 48', '📺', $currentAdmin) ?>
            <?= adminLink('toptravel', 'Top Travel', '✈️', $currentAdmin) ?>
            <?= adminLink('top', 'Lo Más Top', '⭐', $currentAdmin) ?>

            <div class="sidebar__section">Sistema</div>
            <?= adminLink('users', 'Usuarios', '👤', $currentAdmin) ?>
            <?= adminLink('settings', 'Configuración', '⚙️', $currentAdmin) ?>
            <?= adminLink('contacts', 'Mensajes', '📩', $currentAdmin) ?>
        </nav>

        <div class="sidebar__footer">
            <a href="logout.php">🚪 Cerrar sesión</a>
        </div>
    </aside>

    <!-- Main -->
    <main class="admin-main">
        <div class="admin-header">
            <h1 class="admin-header__title"><?= $adminTitle ?? 'Dashboard' ?></h1>
            <div class="admin-header__user">
                👤 <?= sanitize($user['username']) ?> (<?= sanitize($user['role']) ?>)
            </div>
        </div>

        <?= flashMessage() ?>
