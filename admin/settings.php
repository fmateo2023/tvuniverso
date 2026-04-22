<?php
/**
 * TV Universo - Admin: Configuración General
 */
$adminTitle = '⚙️ Configuración';

require_once __DIR__ . '/layout.php';

// --- GUARDAR ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && validateCsrf()) {
    $fields = ['site_name', 'facebook', 'instagram', 'twitter', 'youtube', 'contact_email', 'contact_phone', 'contact_address', 'hero_title', 'hero_subtitle'];

    foreach ($fields as $key) {
        $value = sanitize($_POST[$key] ?? '');
        saveSetting($key, $value);
    }

    // Subir imagen del hero si se proporcionó
    if (!empty($_FILES['hero_image']['name']) && $_FILES['hero_image']['error'] === UPLOAD_ERR_OK) {
        $uploaded = uploadImage($_FILES['hero_image'], 'hero');
        if ($uploaded) {
            $oldImage = getSetting('hero_image');
            if ($oldImage && file_exists(__DIR__ . '/../' . $oldImage) && strpos($oldImage, 'uploads/') === 0) {
                @unlink(__DIR__ . '/../' . $oldImage);
            }
            saveSetting('hero_image', $uploaded);
        }
    }

    setFlash('Configuración guardada correctamente.', 'success');
    header('Location: settings.php');
    exit;
}

$s = getAllSettings();
$currentHero = $s['hero_image'] ?? 'assets/images/hero_canal48.png';
?>

<div class="admin-form">
    <form method="POST" enctype="multipart/form-data">
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

        <!-- Imagen del Hero con upload -->
        <div class="form-group">
            <label>Imagen del Hero</label>
            <div style="display:flex;gap:var(--space-lg);align-items:flex-start;flex-wrap:wrap;">
                <div>
                    <p style="font-size:0.8rem;color:var(--text-muted);margin-bottom:var(--space-sm);">Actual:</p>
                    <img src="../<?= sanitize($currentHero) ?>" alt="Hero actual" id="hero-current"
                         style="width:280px;height:160px;object-fit:cover;border-radius:var(--radius-md);box-shadow:var(--shadow-card);">
                </div>
                <div style="flex:1;min-width:220px;">
                    <input type="file" name="hero_image" id="hero_image" accept="image/*"
                           class="form-control" style="padding:10px;">
                    <span class="admin-form__hint">JPG, PNG, GIF o WEBP. Máximo 5MB. Dejar vacío para mantener la actual.</span>
                    <div id="hero-preview" style="display:none;margin-top:var(--space-sm);">
                        <img id="hero-preview-img" src="" alt="Preview"
                             style="width:280px;height:160px;object-fit:cover;border-radius:var(--radius-md);border:2px dashed var(--rosa);">
                    </div>
                </div>
            </div>
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

<script>
document.getElementById('hero_image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('hero-preview');
    const img = document.getElementById('hero-preview-img');
    if (file && file.type.startsWith('image/')) {
        img.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    } else {
        preview.style.display = 'none';
    }
});
</script>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
