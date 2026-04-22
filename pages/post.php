<?php
/**
 * TV Universo - Detalle de Post
 */

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$post = $id ? getPostById($id) : null;

if (!$post) {
    echo '<div class="page-header"><div class="container"><h1 class="page-header__title">Artículo no encontrado</h1><p class="page-header__desc"><a href="index.php" style="color:var(--blue);">Volver al inicio</a></p></div></div>';
    return;
}

// Incrementar vistas
incrementViews('posts', $id);

// Posts relacionados (misma categoría)
$related = getPosts(['type' => $post['type'], 'category_id' => $post['category_id']], 3);
$related = array_filter($related, fn($p) => $p['id'] !== $post['id']);
?>

<div class="page-header">
    <div class="container">
        <div style="display:flex;gap:var(--space-sm);margin-bottom:var(--space-md);">
            <span class="badge <?= $post['type'] === 'canal48' ? 'badge--canal48' : 'badge--toptravel' ?>">
                <?= $post['type'] === 'canal48' ? 'Canal 48' : 'Top Travel' ?>
            </span>
            <span class="badge" style="background:var(--bg-block);"><?= sanitize($post['category_name'] ?? '') ?></span>
        </div>
        <h1 class="page-header__title"><?= sanitize($post['title']) ?></h1>
        <p class="page-header__desc" style="margin-top:var(--space-md);font-size:0.9rem;color:var(--text-muted);">
            <?= formatDate($post['created_at']) ?> &bull; 👁 <?= $post['views'] + 1 ?> vistas
        </p>
    </div>
</div>

<section class="section">
    <div class="container" style="max-width:900px;">
        <?php if ($post['image_url']): ?>
        <div style="border-radius:var(--radius-md);overflow:hidden;margin-bottom:var(--space-2xl);">
            <img src="<?= sanitize($post['image_url']) ?>" alt="<?= sanitize($post['title']) ?>" style="width:100%;height:auto;">
        </div>
        <?php endif; ?>

        <div style="font-size:1.05rem;line-height:1.8;color:var(--text-secondary);">
            <?= nl2br(sanitize($post['content'])) ?>
        </div>

        <!-- Navegación -->
        <div style="margin-top:var(--space-2xl);padding-top:var(--space-xl);border-top:1px solid rgba(255,255,255,0.05);display:flex;gap:var(--space-md);">
            <a href="index.php?page=<?= $post['type'] === 'canal48' ? 'canal48' : 'toptravel' ?>" class="btn btn--outline btn--small">
                ← Volver a <?= $post['type'] === 'canal48' ? 'Canal 48' : 'Top Travel' ?>
            </a>
            <a href="index.php" class="btn btn--outline btn--small">🏠 Inicio</a>
        </div>
    </div>
</section>

<!-- Relacionados -->
<?php if (!empty($related)): ?>
<section class="section section--dark">
    <div class="container">
        <h2 class="section__title">Contenido relacionado</h2>
        <div class="cards-grid">
            <?php foreach (array_slice($related, 0, 3) as $rel): ?>
            <a href="index.php?page=post&id=<?= $rel['id'] ?>" class="card">
                <div class="card__image">
                    <img src="<?= sanitize($rel['image_url'] ?? '') ?>" alt="<?= sanitize($rel['title']) ?>" loading="lazy">
                </div>
                <div class="card__body">
                    <h3 class="card__title"><?= sanitize($rel['title']) ?></h3>
                    <p class="card__excerpt"><?= sanitize($rel['excerpt'] ?? '') ?></p>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
