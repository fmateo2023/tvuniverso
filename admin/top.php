<?php
/**
 * TV Universo - Admin: Lo Más Top
 * Seleccionar contenido trending y videos virales
 */
$adminTitle = '⭐ Lo Más Top';

require_once __DIR__ . '/layout.php';

$topPosts = getPosts(['section' => 'top'], 20);
$topVideos = getVideos(['section' => 'top'], 20);
?>

<div class="admin-form__section-preview" style="margin-bottom:var(--space-xl);">
    🔴 Este contenido aparecerá en <strong>Lo Más Top</strong>
</div>

<p style="color:var(--text-secondary);font-size:0.9rem;margin-bottom:var(--space-lg);">
    Para agregar contenido a Lo Más Top, edita una noticia o video y selecciona la sección "Lo Más Top".
</p>

<h3 style="margin-bottom:var(--space-lg);font-size:1rem;">🔥 Noticias populares</h3>
<?php if (!empty($topPosts)): ?>
<div class="table-wrapper" style="margin-bottom:var(--space-2xl);">
    <table class="admin-table">
        <thead>
            <tr><th>Título</th><th>Tipo</th><th>Vistas</th><th>Acciones</th></tr>
        </thead>
        <tbody>
            <?php foreach ($topPosts as $p): ?>
            <tr>
                <td><?= sanitize(truncateText($p['title'], 50)) ?></td>
                <td><span class="section-tag section-tag--<?= $p['type'] ?>"><?= $p['type'] === 'canal48' ? '📺' : '✈️' ?> <?= ucfirst($p['type']) ?></span></td>
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
<p style="color:var(--text-muted);margin-bottom:var(--space-2xl);">No hay noticias en Lo Más Top.</p>
<?php endif; ?>

<h3 style="margin-bottom:var(--space-lg);font-size:1rem;">🎬 Videos virales</h3>
<?php if (!empty($topVideos)): ?>
<div class="table-wrapper">
    <table class="admin-table">
        <thead>
            <tr><th>Título</th><th>Vistas</th><th>Acciones</th></tr>
        </thead>
        <tbody>
            <?php foreach ($topVideos as $v): ?>
            <tr>
                <td><?= sanitize(truncateText($v['title'], 50)) ?></td>
                <td><?= $v['views'] ?></td>
                <td class="admin-table__actions">
                    <a href="videos.php?action=edit&id=<?= $v['id'] ?>" class="btn-edit">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php else: ?>
<p style="color:var(--text-muted);">No hay videos virales.</p>
<?php endif; ?>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
