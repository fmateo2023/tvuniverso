<?php
/**
 * TV Universo - Top Travel (Revista Digital)
 * Estilo revista con categorías: Destinos, Experiencias, Hoteles
 */

$catFilter = isset($_GET['cat']) ? (int)$_GET['cat'] : 0;
$filters = ['type' => 'toptravel'];
if ($catFilter) $filters['category_id'] = $catFilter;

$posts = getPosts($filters, 12);
$categories = getCategories('revista');
?>

<!-- Header -->
<div class="page-header">
    <div class="container">
        <h1 class="page-header__title">✈️ <span>Top Travel</span></h1>
        <p class="page-header__desc">Revista digital de viajes. Destinos, experiencias y los mejores hoteles del mundo.</p>
    </div>
</div>

<!-- Filtro por categorías -->
<section class="section">
    <div class="container">
        <div class="tabs">
            <a href="index.php?page=toptravel" class="tab <?= !$catFilter ? 'tab--active' : '' ?>">Todos</a>
            <?php foreach ($categories as $cat): ?>
            <a href="index.php?page=toptravel&cat=<?= $cat['id'] ?>" class="tab <?= $catFilter === (int)$cat['id'] ? 'tab--active' : '' ?>">
                <?= sanitize($cat['name']) ?>
            </a>
            <?php endforeach; ?>
        </div>

        <?php if (!empty($posts)): ?>
        <div class="cards-grid--2">
            <?php foreach ($posts as $i => $post): ?>
            <a href="index.php?page=post&id=<?= $post['id'] ?>" class="card card--large">
                <div class="card__image">
                    <img src="<?= sanitize($post['image_url'] ?? '') ?>" alt="<?= sanitize($post['title']) ?>" loading="lazy">
                    <span class="badge badge--toptravel"><?= sanitize($post['category_name'] ?? 'Top Travel') ?></span>
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
        <p style="color:var(--text-secondary);text-align:center;padding:var(--space-2xl);">No hay artículos en esta categoría.</p>
        <?php endif; ?>
    </div>
</section>
