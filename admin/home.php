<?php
/**
 * TV Universo - Admin: Configuración del HOME
 * Gestionar hero image y contenido destacado
 */
$adminTitle = '🏠 Configuración del Home';

require_once __DIR__ . '/layout.php';

// Procesar subida de imagen hero
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['hero_image'])) {
    if (!validateCsrf()) {
        setFlash('Token de seguridad inválido.', 'error');
    } else {
        $uploaded = uploadImage($_FILES['hero_image'], 'hero');
        if ($uploaded) {
            // Eliminar imagen anterior si existe y no es la default
            $oldImage = getSetting('hero_image');
            if ($oldImage && file_exists(__DIR__ . '/../' . $oldImage) && strpos($oldImage, 'uploads/') === 0) {
                @unlink(__DIR__ . '/../' . $oldImage);
            }
            saveSetting('hero_image', $uploaded);
            setFlash('✅ Imagen del Hero actualizada correctamente.');
        } else {
            setFlash('Error al subir la imagen. Verifica que sea JPG/PNG/GIF/WEBP y menor a 5MB.', 'error');
        }
    }
    header('Location: home.php');
    exit;
}

$currentHero = getSetting('hero_image') ?: 'assets/images/hero_canal48.png';
$homePosts = getPosts(['section' => 'home'], 20);
$trendPosts = getPosts(['section' => 'tendencia'], 20);
?>

<div class="admin-form__section-preview" style="margin-bottom:var(--space-xl);">
    👉 Esto se muestra en la <strong>página principal (HOME)</strong>
</div>

<?= flashMessage() ?>

<!-- HERO IMAGE -->
<div class="admin-form" style="margin-bottom:var(--space-2xl);">
    <h3 style="font-size:1.1rem;margin-bottom:var(--space-lg);">🖼️ Imagen del Hero</h3>

    <div style="display:flex;gap:var(--space-xl);align-items:flex-start;flex-wrap:wrap;">
        <!-- Preview -->
        <div style="flex-shrink:0;">
            <p style="font-size:0.8rem;color:var(--text-muted);margin-bottom:var(--space-sm);">Imagen actual:</p>
            <img src="../<?= sanitize($currentHero) ?>" alt="Hero actual"
                 style="width:320px;height:180px;object-fit:cover;border-radius:var(--radius-md);box-shadow:var(--shadow-card);">
        </div>

        <!-- Upload form -->
        <div style="flex:1;min-width:250px;">
            <form method="POST" enctype="multipart/form-data">
                <?= csrfField() ?>
                <div class="form-group">
                    <label for="hero_image">Subir nueva imagen</label>
                    <input type="file" name="hero_image" id="hero_image" accept="image/*" required
                           class="form-control" style="padding:10px;">
                    <span class="admin-form__hint">JPG, PNG, GIF o WEBP. Máximo 5MB. Recomendado: 1920x1080px</span>
                </div>

                <!-- Preview de la nueva imagen -->
                <div id="hero-preview" style="display:none;margin-bottom:var(--space-md);">
                    <p style="font-size:0.8rem;color:var(--text-muted);margin-bottom:var(--space-sm);">Vista previa:</p>
                    <img id="hero-preview-img" src="" alt="Preview"
                         style="width:320px;height:180px;object-fit:cover;border-radius:var(--radius-md);border:2px dashed var(--rosa);">
                </div>

                <button type="submit" class="btn btn--primary btn--small">Subir y reemplazar</button>
            </form>
        </div>
    </div>
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

<!-- CONTENIDO HOME -->
<h3 style="margin-bottom:var(--space-lg);font-size:1rem;">🟢 Contenido visible en HOME</h3>
<p style="color:var(--text-secondary);font-size:0.9rem;margin-bottom:var(--space-lg);">
    Para agregar contenido al Home, ve a <a href="posts.php" style="color:var(--rosa);">Noticias</a> y selecciona la sección "Home" al crear o editar.
</p>

<?php if (!empty($homePosts)): ?>
<div class="table-wrapper" style="margin-bottom:var(--space-2xl);">
    <table class="admin-table">
        <thead>
            <tr><th>Título</th><th>Tipo</th><th>Destacado</th><th>Acciones</th></tr>
        </thead>
        <tbody>
            <?php foreach ($homePosts as $p): ?>
            <tr>
                <td><?= sanitize(truncateText($p['title'], 50)) ?></td>
                <td><span class="section-tag section-tag--<?= $p['type'] ?>"><?= $p['type'] === 'canal48' ? '📺 Canal 48' : '✈️ Top Travel' ?></span></td>
                <td><?= $p['featured'] ? '⭐' : '—' ?></td>
                <td class="admin-table__actions">
                    <a href="posts.php?action=edit&id=<?= $p['id'] ?>" class="btn-edit">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php else: ?>
<p style="color:var(--text-muted);margin-bottom:var(--space-2xl);">No hay contenido asignado al Home.</p>
<?php endif; ?>

<h3 style="margin-bottom:var(--space-lg);font-size:1rem;">🔥 Contenido en Tendencia (Home)</h3>
<?php if (!empty($trendPosts)): ?>
<div class="table-wrapper">
    <table class="admin-table">
        <thead>
            <tr><th>Título</th><th>Tipo</th><th>Acciones</th></tr>
        </thead>
        <tbody>
            <?php foreach ($trendPosts as $p): ?>
            <tr>
                <td><?= sanitize(truncateText($p['title'], 50)) ?></td>
                <td><span class="section-tag section-tag--tendencia">Tendencia</span></td>
                <td class="admin-table__actions">
                    <a href="posts.php?action=edit&id=<?= $p['id'] ?>" class="btn-edit">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php else: ?>
<p style="color:var(--text-muted);">No hay contenido en Tendencia.</p>
<?php endif; ?>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
