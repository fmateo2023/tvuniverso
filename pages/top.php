<?php
/**
 * TV Universo - Lo Más Top
 * Contenido más visto y videos virales
 */

$topPosts = getPosts(['section' => 'top'], 8);
$topVideos = getVideos(['section' => 'top'], 6);
?>

<!-- Header -->
<div class="page-header">
    <div class="container">
        <span style="color:var(--verde);font-size:0.8rem;letter-spacing:3px;text-transform:uppercase;font-weight:600;">Destacados</span>
        <h1 class="page-header__title" style="margin-top:8px;">Lo Más <span>Top</span></h1>
        <div style="width:60px;height:3px;background:linear-gradient(90deg,var(--verde),var(--azul));margin-top:16px;border-radius:2px;"></div>
        <p class="page-header__desc" style="margin-top:12px;">El contenido más visto, los videos virales y lo que todos están hablando.</p>
    </div>
</div>

<!-- Contenido más visto -->
<section class="section">
    <div class="container">
        <h2 class="section__title">🔥 Contenido más visto</h2>
        <?php if (!empty($topPosts)): ?>
        <div class="cards-grid">
            <?php foreach ($topPosts as $i => $post): ?>
            <a href="index.php?page=post&id=<?= $post['id'] ?>" class="card <?= $i === 0 ? 'card--large' : '' ?>">
                <div class="card__image">
                    <img src="<?= sanitize($post['image_url'] ?? '') ?>" alt="<?= sanitize($post['title']) ?>" loading="lazy">
                    <span class="badge badge--trending">#<?= $i + 1 ?> Top</span>
                </div>
                <div class="card__body">
                    <span class="card__category"><?= sanitize($post['category_name'] ?? '') ?></span>
                    <h3 class="card__title"><?= sanitize($post['title']) ?></h3>
                    <p class="card__excerpt"><?= sanitize($post['excerpt'] ?? '') ?></p>
                    <div class="card__meta">
                        <span><?= formatDate($post['created_at']) ?></span>
                        <span>👁 <?= $post['views'] ?> vistas</span>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p style="color:var(--text-secondary);text-align:center;padding:var(--space-2xl);">Próximamente contenido trending.</p>
        <?php endif; ?>
    </div>
</section>

<!-- Videos virales -->
<?php if (!empty($topVideos)): ?>
<section class="section section--dark">
    <div class="container">
        <h2 class="section__title">🎬 Videos virales</h2>
        <div class="cards-grid">
            <?php foreach ($topVideos as $video): ?>
            <a href="index.php?page=video&id=<?= $video['id'] ?>" class="card card--video">
                <div class="card__image">
                    <img src="<?= sanitize($video['thumbnail'] ?? '') ?>" alt="<?= sanitize($video['title']) ?>" loading="lazy">
                    <span class="badge badge--trending">Viral</span>
                </div>
                <div class="card__body">
                    <span class="card__category"><?= sanitize($video['category_name'] ?? '') ?></span>
                    <h3 class="card__title"><?= sanitize($video['title']) ?></h3>
                    <div class="card__meta">
                        <span>👁 <?= $video['views'] ?> vistas</span>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
