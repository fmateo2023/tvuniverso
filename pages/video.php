<?php
/**
 * TV Universo - Detalle de Video
 */

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$video = $id ? getVideoById($id) : null;

if (!$video) {
    echo '<div class="page-header"><div class="container"><h1 class="page-header__title">Video no encontrado</h1><p class="page-header__desc"><a href="index.php" style="color:var(--blue);">Volver al inicio</a></p></div></div>';
    return;
}

incrementViews('videos', $id);
$moreVideos = getVideos(['section' => $video['section']], 4);
$moreVideos = array_filter($moreVideos, fn($v) => $v['id'] !== $video['id']);
?>

<div class="page-header">
    <div class="container">
        <span class="badge badge--canal48" style="margin-bottom:var(--space-md);display:inline-block;">🎥 Video</span>
        <h1 class="page-header__title"><?= sanitize($video['title']) ?></h1>
        <p class="page-header__desc" style="font-size:0.9rem;color:var(--text-muted);">
            <?= sanitize($video['category_name'] ?? '') ?> &bull; 👁 <?= $video['views'] + 1 ?> vistas
        </p>
    </div>
</div>

<section class="section">
    <div class="container" style="max-width:900px;">
        <!-- Player -->
        <div style="position:relative;padding-bottom:56.25%;height:0;border-radius:var(--radius-md);overflow:hidden;margin-bottom:var(--space-2xl);background:var(--bg-block);">
            <iframe
                src="<?= sanitize($video['url']) ?>"
                style="position:absolute;top:0;left:0;width:100%;height:100%;border:0;"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen
                loading="lazy"
            ></iframe>
        </div>

        <div style="display:flex;gap:var(--space-md);">
            <a href="index.php?page=canal48" class="btn btn--outline btn--small">← Canal 48</a>
            <a href="index.php?page=top" class="btn btn--outline btn--small">⭐ Lo Más Top</a>
        </div>
    </div>
</section>

<!-- Más videos -->
<?php if (!empty($moreVideos)): ?>
<section class="section section--dark">
    <div class="container">
        <h2 class="section__title">Más videos</h2>
        <div class="cards-grid">
            <?php foreach (array_slice($moreVideos, 0, 3) as $v): ?>
            <a href="index.php?page=video&id=<?= $v['id'] ?>" class="card card--video">
                <div class="card__image">
                    <img src="<?= sanitize($v['thumbnail'] ?? '') ?>" alt="<?= sanitize($v['title']) ?>" loading="lazy">
                </div>
                <div class="card__body">
                    <h3 class="card__title"><?= sanitize($v['title']) ?></h3>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
