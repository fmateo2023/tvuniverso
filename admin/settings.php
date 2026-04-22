<?php
/**
 * TV Universo - Admin: Configuración General
 */
$adminTitle = '⚙️ Configuración';

require_once __DIR__ . '/layout.php';

// --- GUARDAR ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && validateCsrf()) {
    $fields = ['site_name', 'facebook', 'instagram', 'twitter', 'youtube', 'contact_email', 'contact_phone', 'contact_address', 'hero_title', 'hero_subtitle', 'hero_image'];

    foreach ($fields as $key) {
        $value = sanitize($_POST[$key] ?? '');
        $stmt = $pdo->prepare("UPDATE settings SET setting_value = :val WHERE setting_key = :key");
        $stmt->execute([':val' => $value, ':key' => $key]);
    }
    setFlash('Configuración guardada correctamente.', 'success');
    header('Location: settings.php');
    exit;
}

$s = getAllSettings();
?>

<div class="admin-form">
    <form method="POST">
        <?= csrfField() ?>

        <h3 style="margin-bottom:var(--space-lg);font-size:1rem;">🏷️ General</h3>
        <div class="form-group">
            <label>Nombre del sitio</label>
            <input type="text" name="site_name" class="form-control" value="<?= sanitize($s['site_name'] ?? '') ?>">
        </div>

        <h3 style="margin:var(--space-xl) 0 var(--space-lg);font-size:1rem;">🎬 Hero (Página principal)</h3>
        <div class="admin-form__row">
            <div class="form-group">
                <label>Título del Hero</label>
                <input type="text" name="hero_title" class="form-control" value="<?= sanitize($s['hero_title'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Subtítulo del Hero</label>
                <input type="text" name="hero_subtitle" class="form-control" value="<?= sanitize($s['hero_subtitle'] ?? '') ?>">
            </div>
        </div>
        <div class="form-group">
            <label>Imagen del Hero (URL)</label>
            <input type="url" name="hero_image" class="form-control" value="<?= sanitize($s['hero_image'] ?? '') ?>">
        </div>

        <h3 style="margin:var(--space-xl) 0 var(--space-lg);font-size:1rem;">📱 Redes Sociales</h3>
        <div class="admin-form__row">
            <div class="form-group">
                <label>Facebook</label>
                <input type="url" name="facebook" class="form-control" value="<?= sanitize($s['facebook'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Instagram</label>
                <input type="url" name="instagram" class="form-control" value="<?= sanitize($s['instagram'] ?? '') ?>">
            </div>
        </div>
        <div class="admin-form__row">
            <div class="form-group">
                <label>Twitter / X</label>
                <input type="url" name="twitter" class="form-control" value="<?= sanitize($s['twitter'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>YouTube</label>
                <input type="url" name="youtube" class="form-control" value="<?= sanitize($s['youtube'] ?? '') ?>">
            </div>
        </div>

        <h3 style="margin:var(--space-xl) 0 var(--space-lg);font-size:1rem;">📞 Contacto</h3>
        <div class="admin-form__row">
            <div class="form-group">
                <label>Email de contacto</label>
                <input type="email" name="contact_email" class="form-control" value="<?= sanitize($s['contact_email'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Teléfono</label>
                <input type="text" name="contact_phone" class="form-control" value="<?= sanitize($s['contact_phone'] ?? '') ?>">
            </div>
        </div>
        <div class="form-group">
            <label>Dirección</label>
            <input type="text" name="contact_address" class="form-control" value="<?= sanitize($s['contact_address'] ?? '') ?>">
        </div>

        <div style="margin-top:var(--space-xl);">
            <button type="submit" class="btn btn--primary">Guardar configuración</button>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
