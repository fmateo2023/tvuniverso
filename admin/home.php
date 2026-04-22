<?php
/**
 * TV Universo - Admin: Configuración del HOME
 * Gestionar contenido destacado de la página principal
 */
$adminTitle = '🏠 Configuración del Home';

require_once __DIR__ . '/layout.php';

$homePosts = getPosts(['section' => 'home'], 20);
$trendPosts = getPosts(['section' => 'tendencia'], 20);
?>

<div class="admin-form__section-preview" style="margin-bottom:var(--space-xl);">
    👉 Esto se muestra en la <strong>página principal (HOME)</strong>
</div>

<h3 style="margin-bottom:var(--space-lg);font-size:1rem;">🟢 Contenido visible en HOME</h3>
<p style="color:var(--text-secondary);font-size:0.9rem;margin-bottom:var(--space-lg);">
    Para agregar contenido al Home, ve a <a href="posts.php" style="color:var(--blue);">Noticias</a> y selecciona la sección "Home" al crear o editar.
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
