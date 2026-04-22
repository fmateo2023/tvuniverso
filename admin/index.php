<?php
/**
 * TV Universo - Admin Dashboard
 * Resumen general + últimos contenidos
 */
$adminTitle = '📊 Dashboard';
require_once __DIR__ . '/layout.php';

$totalPosts      = countRecords('posts');
$totalVideos     = countRecords('videos');
$totalCategories = countRecords('categories');
$totalUsers      = countRecords('users');
$totalContacts   = countRecords('contacts');
$canal48Count    = countRecords('posts', ['type' => 'canal48']);
$travelCount     = countRecords('posts', ['type' => 'toptravel']);

$recentPosts  = getPosts([], 5);
$recentVideos = getVideos([], 5);
?>

<!-- Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card__icon">📰</div>
        <div class="stat-card__value"><?= $totalPosts ?></div>
        <div class="stat-card__label">Noticias</div>
    </div>
    <div class="stat-card">
        <div class="stat-card__icon">🎥</div>
        <div class="stat-card__value"><?= $totalVideos ?></div>
        <div class="stat-card__label">Videos</div>
    </div>
    <div class="stat-card">
        <div class="stat-card__icon">🗂️</div>
        <div class="stat-card__value"><?= $totalCategories ?></div>
        <div class="stat-card__label">Categorías</div>
    </div>
    <div class="stat-card">
        <div class="stat-card__icon">📩</div>
        <div class="stat-card__value"><?= $totalContacts ?></div>
        <div class="stat-card__label">Mensajes</div>
    </div>
    <div class="stat-card">
        <div class="stat-card__icon">📺</div>
        <div class="stat-card__value"><?= $canal48Count ?></div>
        <div class="stat-card__label">Canal 48</div>
    </div>
    <div class="stat-card">
        <div class="stat-card__icon">✈️</div>
        <div class="stat-card__value"><?= $travelCount ?></div>
        <div class="stat-card__label">Top Travel</div>
    </div>
</div>

<!-- Últimas noticias -->
<h3 style="margin-bottom:var(--space-lg);font-size:1.1rem;">Últimas noticias</h3>
<div class="table-wrapper" style="margin-bottom:var(--space-2xl);">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Título</th>
                <th>Tipo</th>
                <th>Sección</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recentPosts as $post): ?>
            <tr>
                <td><?= sanitize(truncateText($post['title'], 50)) ?></td>
                <td>
                    <span class="section-tag section-tag--<?= $post['type'] ?>">
                        <?= $post['type'] === 'canal48' ? '📺 Canal 48' : '✈️ Top Travel' ?>
                    </span>
                </td>
                <td>
                    <span class="section-tag section-tag--<?= $post['section'] ?>">
                        <?= ucfirst($post['section']) ?>
                    </span>
                </td>
                <td><?= formatDate($post['created_at']) ?></td>
                <td class="admin-table__actions">
                    <a href="posts.php?action=edit&id=<?= $post['id'] ?>" class="btn-edit">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Últimos videos -->
<h3 style="margin-bottom:var(--space-lg);font-size:1.1rem;">Últimos videos</h3>
<div class="table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Título</th>
                <th>Sección</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recentVideos as $video): ?>
            <tr>
                <td><?= sanitize(truncateText($video['title'], 50)) ?></td>
                <td>
                    <span class="section-tag section-tag--<?= $video['section'] ?>">
                        <?= ucfirst($video['section']) ?>
                    </span>
                </td>
                <td><?= formatDate($video['created_at']) ?></td>
                <td class="admin-table__actions">
                    <a href="videos.php?action=edit&id=<?= $video['id'] ?>" class="btn-edit">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
