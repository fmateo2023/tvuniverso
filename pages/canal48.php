<?php
/**
 * TV Universo - Canal 48
 * Noticias, videos, en vivo y categorías
 */

$catFilter = isset($_GET['cat']) ? (int)$_GET['cat'] : 0;
$filters = ['type' => 'canal48'];
if ($catFilter) $filters['category_id'] = $catFilter;

$posts = getPosts($filters, 12);
$videos = getVideos(['section' => 'canal48'], 6);
$categories = getCategories('noticias');
?>

<!-- Header -->
<div class="page-header">
    <div class="container">
        <h1 class="page-header__title">📺 <span>Canal 48</span></h1>
        <p class="page-header__desc">Noticias, videos y contenido en vivo. Tu fuente de información confiable.</p>
    </div>
</div>

<!-- En Vivo -->
<section class="section">
    <div class="container">
        <div class="live-banner">
            <div class="live-banner__info">
                <div class="live-dot"></div>
                <div>
                    <strong style="font-size:1.1rem;">Señal en vivo</strong>
                    <p style="color:var(--text-secondary);font-size:0.9rem;">Canal 48 transmitiendo las 24 horas</p>
                </div>
            </div>
            <span class="badge badge--live">● EN VIVO</span>
        </div>

        <!-- Placeholder de video en vivo -->
        <div style="background:var(--bg-block);border-radius:var(--radius-md);aspect-ratio:16/9;max-height:500px;display:flex;align-items:center;justify-content:center;margin-bottom:var(--space-2xl);">
            <div style="text-align:center;color:var(--text-muted);">
                <div style="font-size:3rem;margin-bottom:var(--space-md);">📺</div>
                <p style="font-size:1.1rem;font-weight:600;">Señal en vivo - Canal 48</p>
                <p style="font-size:0.9rem;">La transmisión estará disponible próximamente</p>
            </div>
        </div>
    </div>
</section>

<!-- Filtro por categorías -->
<section class="section section--dark">
    <div class="container">
        <h2 class="section__title">Noticias</h2>

        <div class="tabs">
            <a href="index.php?page=canal48" class="tab <?= !$catFilter ? 'tab--active' : '' ?>">Todas</a>
            <?php foreach ($categories as $cat): ?>
            <a href="index.php?page=canal48&cat=<?= $cat['id'] ?>" class="tab <?= $catFilter === (int)$cat['id'] ? 'tab--active' : '' ?>">
                <?= sanitize($cat['name']) ?>
            </a>
            <?php endforeach; ?>
        </div>

        <?php if (!empty($posts)): ?>
        <div class="cards-grid">
            <?php foreach ($posts as $post): ?>
            <a href="index.php?page=post&id=<?= $post['id'] ?>" class="card">
                <div class="card__image">
                    <img src="<?= sanitize($post['image_url'] ?? '') ?>" alt="<?= sanitize($post['title']) ?>" loading="lazy">
                    <span class="badge badge--canal48"><?= sanitize($post['category_name'] ?? 'Canal 48') ?></span>
                </div>
                <div class="card__body">
                    <span class="card__category"><?= sanitize($post['category_name'] ?? '') ?></span>
                    <h3 class="card__title"><?= sanitize($post['title']) ?></h3>
                    <p class="card__excerpt"><?= sanitize($post['excerpt'] ?? '') ?></p>
                    <div class="card__meta">
                        <span><?= formatDate($post['created_at']) ?></span>
                        <span>👁 <?= $post['views'] ?></span>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p style="color:var(--text-secondary);text-align:center;padding:var(--space-2xl);">No hay noticias en esta categoría.</p>
        <?php endif; ?>
    </div>
</section>

<!-- Videos Canal 48 -->
<?php if (!empty($videos)): ?>
<section class="section">
    <div class="container">
        <h2 class="section__title">🎥 Videos</h2>
        <div class="cards-grid">
            <?php foreach ($videos as $video): ?>
            <a href="index.php?page=video&id=<?= $video['id'] ?>" class="card card--video">
                <div class="card__image">
                    <img src="<?= sanitize($video['thumbnail'] ?? '') ?>" alt="<?= sanitize($video['title']) ?>" loading="lazy">
                </div>
                <div class="card__body">
                    <span class="card__category"><?= sanitize($video['category_name'] ?? '') ?></span>
                    <h3 class="card__title"><?= sanitize($video['title']) ?></h3>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
