<?php
/**
 * TV Universo - Admin: Top Travel
 * Gestionar artículos de la revista digital
 */
$adminTitle = '✈️ Top Travel';

require_once __DIR__ . '/layout.php';

$travelPosts = getPosts(['type' => 'toptravel'], 20);
$revistaCats = getCategories('revista');
?>

<div class="admin-form__section-preview" style="margin-bottom:var(--space-xl);">
    🟣 Este contenido se mostrará en la sección <strong>Revista Digital (Top Travel)</strong>
</div>

<p style="color:var(--text-secondary);font-size:0.9rem;margin-bottom:var(--space-lg);">
    <a href="posts.php?action=create" style="color:var(--blue);">+ Crear nuevo artículo para Top Travel</a>
</p>

<h3 style="margin-bottom:var(--space-lg);font-size:1rem;">📚 Categorías de revista</h3>
<div style="display:flex;gap:var(--space-sm);flex-wrap:wrap;margin-bottom:var(--space-xl);">
    <?php foreach ($revistaCats as $cat): ?>
    <span class="badge badge--toptravel"><?= sanitize($cat['name']) ?></span>
    <?php endforeach; ?>
</div>

<?php if (!empty($travelPosts)): ?>
<div class="table-wrapper">
    <table class="admin-table">
        <thead>
            <tr><th>Título</th><th>Categoría</th><th>Sección</th><th>Destacado</th><th>Vistas</th><th>Acciones</th></tr>
        </thead>
        <tbody>
            <?php foreach ($travelPosts as $p): ?>
            <tr>
                <td><?= sanitize(truncateText($p['title'], 50)) ?></td>
                <td><?= sanitize($p['category_name'] ?? '—') ?></td>
                <td><span class="section-tag section-tag--<?= $p['section'] ?>"><?= ucfirst($p['section']) ?></span></td>
                <td><?= $p['featured'] ? '⭐' : '—' ?></td>
                <td><?= $p['views'] ?></td>
                <td class="admin-table__actions">
                    <a href="posts.php?action=edit&id=<?= $p['id'] ?>" class="btn-edit">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php else: ?>
<p style="color:var(--text-muted);">No hay artículos de Top Travel.</p>
<?php endif; ?>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
