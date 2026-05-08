<?php
/**
 * TV Universo - Navbar con Subheader Dinámico
 * Header: Logo + Inicio, Canal 48, Top Travel
 * Subheader: Cambia según la sección activa
 */
$currentPage = $page ?? 'home';

// Determinar sección activa para el subheader
$isCanal48Section = in_array($currentPage, ['canal48', 'top', 'post', 'video']);
$isTopTravelSection = ($currentPage === 'toptravel');
$showSubheader = $isCanal48Section || $isTopTravelSection;
?>
<div class="gradient-bar"></div>

<!-- HEADER PRINCIPAL -->
<header class="header-main">
    <div class="container header-main__inner">
        <a href="index.php" class="header-main__logo">
            <img src="assets/images/favicon.png" alt="TV Universo">
        </a>

        <nav class="header-main__nav">
            <a href="index.php" class="header-main__link <?= $currentPage === 'home' ? 'header-main__link--active' : '' ?>">
                <span class="header-main__dot"></span> Inicio
            </a>
            <a href="index.php?page=canal48" class="header-main__link <?= $isCanal48Section ? 'header-main__link--active' : '' ?>">
                <span class="header-main__dot"></span> Canal 48
            </a>
            <a href="index.php?page=toptravel" class="header-main__link <?= $isTopTravelSection ? 'header-main__link--active' : '' ?>">
                <span class="header-main__dot"></span> Top Travel
            </a>
        </nav>

        <button class="header-main__toggle" aria-label="Menú" id="menuToggle">☰</button>
    </div>
</header>

<!-- SUBHEADER DINÁMICO -->
<?php if ($showSubheader): ?>
<nav class="subheader <?= $isTopTravelSection ? 'subheader--toptravel' : 'subheader--canal48' ?>">
    <div class="container subheader__inner">
        <?php if ($isCanal48Section): ?>
            <!-- Submenú Canal 48 -->
            <a href="index.php?page=top" class="subheader__link <?= $currentPage === 'top' ? 'subheader__link--active' : '' ?>">Más Top</a>
            <a href="index.php?page=nosotros" class="subheader__link <?= $currentPage === 'nosotros' ? 'subheader__link--active' : '' ?>">Nosotros</a>
            <a href="index.php?page=contacto" class="subheader__link <?= $currentPage === 'contacto' ? 'subheader__link--active' : '' ?>">Contacto</a>
        <?php elseif ($isTopTravelSection): ?>
            <!-- Submenú Top Travel -->
            <a href="index.php?page=nosotros" class="subheader__link <?= $currentPage === 'nosotros' ? 'subheader__link--active' : '' ?>">Nosotros</a>
            <a href="index.php?page=contacto" class="subheader__link <?= $currentPage === 'contacto' ? 'subheader__link--active' : '' ?>">Contacto</a>
        <?php endif; ?>
    </div>
</nav>
<?php endif; ?>
