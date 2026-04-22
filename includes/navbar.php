<?php
/**
 * TV Universo - Navbar
 * Navegación principal del sitio
 */
$currentPage = $page ?? 'home';
?>
<nav class="navbar">
    <div class="container navbar__inner">
        <a href="index.php" class="navbar__logo">
            <span>TV</span><span>Universo</span>
        </a>

        <div class="navbar__menu">
            <a href="index.php" class="navbar__link <?= $currentPage === 'home' ? 'navbar__link--active' : '' ?>">Inicio</a>
            <a href="index.php?page=canal48" class="navbar__link <?= $currentPage === 'canal48' ? 'navbar__link--active' : '' ?>">Canal 48</a>
            <a href="index.php?page=top" class="navbar__link <?= $currentPage === 'top' ? 'navbar__link--active' : '' ?>">Lo Más Top</a>
            <a href="index.php?page=toptravel" class="navbar__link <?= $currentPage === 'toptravel' ? 'navbar__link--active' : '' ?>">Top Travel</a>
            <a href="index.php?page=nosotros" class="navbar__link <?= $currentPage === 'nosotros' ? 'navbar__link--active' : '' ?>">Nosotros</a>
            <a href="index.php?page=contacto" class="navbar__link <?= $currentPage === 'contacto' ? 'navbar__link--active' : '' ?>">Contacto</a>
        </div>

        <button class="navbar__toggle" aria-label="Menú">☰</button>
    </div>
</nav>
