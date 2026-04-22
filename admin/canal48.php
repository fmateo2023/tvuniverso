<?php
/**
 * TV Universo - Admin: Canal 48
 * Gestionar contenido exclusivo del canal
 */
$adminTitle = '📺 Canal 48';

require_once __DIR__ . '/layout.php';

$canal48Posts = getPosts(['type' => 'canal48'], 20);
$canal48Videos = getVideos(['section' => 'canal48'], 20);
?>

<div class="admin-form__section-preview" style="margin-bottom:var(--space-xl);">
    🔵 Este contenido se mostrará en <strong>Canal 48</strong>
</div>

<h3 style="margin-bottom:var(--space-lg);font-size:1rem;">📰 Noticias de Canal 48</h3>
<p style="color:var(--text-secondary);font-size:0.9rem;margin-bottom:var(--space-lg);">
    <a href="posts.php?action=create" style="color:var(--blue);">+ Crear nueva noticia para Canal 48</a>
</p>

<?php if (!empty($canal48Posts)): ?>
<div class="table-wrapper" style="margin-bottom:var(--space-2xl);">
    <table class="admin-table">
        <thead>
            <tr><th>Título</th><th>Sección</th><th>Destacado</th><th>Vistas</th><th>Acciones</th></tr>
        </thead>
        <tbody>
            <?php foreach ($canal48Posts as $p): ?>
            <tr>
                <td><?= sanitize(truncateText($p['title'], 50)) ?></td>
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
<?php endif; ?>

<h3 style="margin-bottom:var(--space-lg);font-size:1rem;">🎥 Videos de Canal 48</h3>
<?php if (!empty($canal48Videos)): ?>
<div class="table-wrapper">
    <table class="admin-table">
        <thead>
            <tr><th>Título</th><th>Destacado</th><th>Vistas</th><th>Acciones</th></tr>
        </thead>
        <tbody>
            <?php foreach ($canal48Videos as $v): ?>
            <tr>
                <td><?= sanitize(truncateText($v['title'], 50)) ?></td>
                <td><?= $v['featured'] ? '⭐' : '—' ?></td>
                <td><?= $v['views'] ?></td>
                <td class="admin-table__actions">
                    <a href="videos.php?action=edit&id=<?= $v['id'] ?>" class="btn-edit">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
