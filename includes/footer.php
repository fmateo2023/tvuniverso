<?php
/**
 * TV Universo - Footer
 * Pie de página con navegación, redes y copyright
 */
$s = $settings ?? getAllSettings();
?>
<footer class="footer">
    <div class="container">
        <div class="footer__grid">
            <!-- Marca -->
            <div>
                <div class="footer__brand">📺 TV Universo</div>
                <p class="footer__desc">Tu ventana al mundo. Noticias, entretenimiento y viajes en un solo lugar. Canal 48 y Top Travel, las marcas que te conectan.</p>
                <div class="footer__social">
                    <a href="<?= sanitize($s['facebook'] ?? '#') ?>" target="_blank" rel="noopener" title="Facebook">📘</a>
                    <a href="<?= sanitize($s['instagram'] ?? '#') ?>" target="_blank" rel="noopener" title="Instagram">📷</a>
                    <a href="<?= sanitize($s['twitter'] ?? '#') ?>" target="_blank" rel="noopener" title="Twitter">🐦</a>
                    <a href="<?= sanitize($s['youtube'] ?? '#') ?>" target="_blank" rel="noopener" title="YouTube">▶️</a>
                </div>
            </div>

            <!-- Navegación -->
            <div>
                <h4 class="footer__title">Navegación</h4>
                <div class="footer__links">
                    <a href="index.php">Inicio</a>
                    <a href="index.php?page=canal48">Canal 48</a>
                    <a href="index.php?page=top">Lo Más Top</a>
                    <a href="index.php?page=toptravel">Top Travel</a>
                </div>
            </div>

            <!-- Empresa -->
            <div>
                <h4 class="footer__title">Empresa</h4>
                <div class="footer__links">
                    <a href="index.php?page=nosotros">Nosotros</a>
                    <a href="index.php?page=contacto">Contacto</a>
                    <a href="admin/login.php">Admin</a>
                </div>
            </div>

            <!-- Contacto -->
            <div>
                <h4 class="footer__title">Contacto</h4>
                <div class="footer__links">
                    <a href="mailto:<?= sanitize($s['contact_email'] ?? '') ?>"><?= sanitize($s['contact_email'] ?? '') ?></a>
                    <a href="tel:<?= sanitize($s['contact_phone'] ?? '') ?>"><?= sanitize($s['contact_phone'] ?? '') ?></a>
                    <span style="color:var(--text-secondary);font-size:0.9rem;"><?= sanitize($s['contact_address'] ?? '') ?></span>
                </div>
            </div>
        </div>

        <div class="footer__bottom">
            <span>&copy; <?= date('Y') ?> TV Universo. Todos los derechos reservados.</span>
            <span>Canal 48 &bull; Top Travel</span>
        </div>
    </div>
</footer>
