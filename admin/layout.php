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
    <link rel="stylesheet" href="../assets/css/admin.css?v=1.0.3">
    <style>
    /* Admin Critical CSS v1.0.3 - inline override */
    .admin-layout{display:flex!important;min-height:100vh}
    .sidebar{background:var(--bg-section,#1C1C1C);border-right:1px solid rgba(255,255,255,0.05);padding:1.5rem 0;position:fixed;top:0;left:0;bottom:0;width:260px;overflow-y:auto;z-index:100;transition:transform .3s ease;flex-shrink:0}
    .admin-main{flex:1;margin-left:260px;padding:2rem 3rem;min-height:100vh;min-width:0;overflow-x:hidden;color:#1A1A1A}
    .admin-header{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:2rem;padding-bottom:1.5rem;border-bottom:1px solid rgba(255,255,255,0.05)}
    .admin-header__title{font-size:1.5rem;font-weight:800;white-space:nowrap;color:#1A1A1A}
    .admin-header__user{white-space:nowrap;color:#5A5A5A}
    .stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:1.5rem;margin-bottom:2rem}
    .table-wrapper{overflow-x:auto;-webkit-overflow-scrolling:touch;width:100%}
    .admin-table{width:100%;min-width:700px;border-collapse:collapse}
    .admin-form__row{display:grid;grid-template-columns:1fr 1fr;gap:1.5rem}
    .sidebar-toggle{display:none;position:fixed;top:12px;left:12px;z-index:200;background:var(--bg-section,#1C1C1C);border:1px solid rgba(255,255,255,0.1);color:#fff;font-size:1.4rem;width:44px;height:44px;border-radius:6px;cursor:pointer;align-items:center;justify-content:center;text-align:center;padding:0;line-height:44px}
    .sidebar-overlay{display:none;position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.6);z-index:99}
    .sidebar-overlay.active{display:block}
    @media(max-width:768px){
        .sidebar-toggle{display:flex!important}
        .sidebar{transform:translateX(-100%);z-index:150}
        .sidebar.open{transform:translateX(0)}
        .admin-layout{display:block!important}
        .admin-main{margin-left:0!important;padding:1rem;padding-top:68px}
        .admin-header{flex-direction:column;align-items:flex-start}
        .admin-header__title{font-size:1.2rem;white-space:normal}
        .stats-grid{grid-template-columns:1fr 1fr;gap:.5rem}
        .admin-form__row{grid-template-columns:1fr}
    }
    @media(max-width:480px){
        .stats-grid{grid-template-columns:1fr}
        .admin-main{padding:.5rem;padding-top:64px}
    }
    </style>
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
            <small style="color:#555;font-size:0.6rem;margin-top:4px;">v1.0.3</small>
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
