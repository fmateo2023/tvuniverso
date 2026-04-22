<?php
/**
 * TV Universo - HOME
 * Hero + Tendencia + Canal 48 + Top Travel
 */

$heroImage = $settings['hero_image'] ?? 'https://images.unsplash.com/photo-1478720568477-152d9b164e26?w=1200';
$featuredPosts = getPosts(['featured' => true, 'section' => 'home'], 4);
$trendingPosts = getPosts(['section' => 'tendencia'], 4);
$canal48Posts = getPosts(['type' => 'canal48'], 4);
$travelPosts = getPosts(['type' => 'toptravel'], 4);
$featuredVideos = getVideos(['featured' => true], 4);
?>

<!-- HERO -->
<section class="hero">
    <div class="hero__bg" style="background-image: url('<?= sanitize($heroImage) ?>')"></div>
    <div class="hero__overlay"></div>
    <div class="container hero__content">
        <span class="hero__tag">📺 EN VIVO</span>
        <h1 class="hero__title">
            Bienvenido a <span>TV Universo</span>
        </h1>
        <p class="hero__desc">Tu ventana al mundo. Noticias, entretenimiento y los mejores destinos de viaje en un solo lugar.</p>
        <div class="hero__actions">
            <a href="index.php?page=canal48" class="btn btn--primary">📺 Canal 48</a>
            <a href="index.php?page=toptravel" class="btn btn--outline">✈️ Top Travel</a>
        </div>
    </div>
</section>

<!-- TENDENCIA -->
<?php if (!empty($trendingPosts)): ?>
<section class="section">
    <div class="container">
        <h2 class="section__title">Tendencia</h2>
        <div class="cards-grid">
            <?php foreach ($trendingPosts as $post): ?>
            <a href="index.php?page=post&id=<?= $post['id'] ?>" class="card">
                <div class="card__image">
                    <img src="<?= sanitize($post['image_url'] ?? '') ?>" alt="<?= sanitize($post['title']) ?>" loading="lazy">
                    <span class="badge badge--trending">Tendencia</span>
                </div>
                <div class="card__body">
                    <span class="card__category"><?= sanitize($post['category_name'] ?? '') ?></span>
                    <h3 class="card__title"><?= sanitize($post['title']) ?></h3>
                    <p class="card__excerpt"><?= sanitize($post['excerpt'] ?? '') ?></p>
                    <div class="card__meta">
                        <span><?= formatDate($post['created_at']) ?></span>
                        <span><?= $post['type'] === 'canal48' ? '📺 Canal 48' : '✈️ Top Travel' ?></span>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- EXPLORAR / DESTACADOS -->
<?php if (!empty($featuredPosts)): ?>
<section class="section section--dark">
    <div class="container">
        <h2 class="section__title">Explorar</h2>
        <div class="cards-grid--2">
            <?php foreach ($featuredPosts as $i => $post): ?>
            <a href="index.php?page=post&id=<?= $post['id'] ?>" class="card <?= $i === 0 ? 'card--large' : '' ?>">
                <div class="card__image">
                    <img src="<?= sanitize($post['image_url'] ?? '') ?>" alt="<?= sanitize($post['title']) ?>" loading="lazy">
                    <span class="badge <?= $post['type'] === 'canal48' ? 'badge--canal48' : 'badge--toptravel' ?>">
                        <?= $post['type'] === 'canal48' ? 'Canal 48' : 'Top Travel' ?>
                    </span>
                </div>
                <div class="card__body">
                    <span class="card__category"><?= sanitize($post['category_name'] ?? '') ?></span>
                    <h3 class="card__title"><?= sanitize($post['title']) ?></h3>
                    <p class="card__excerpt"><?= sanitize($post['excerpt'] ?? '') ?></p>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- SECCIÓN CANAL 48 -->
<?php if (!empty($canal48Posts)): ?>
<section class="section">
    <div class="container">
        <h2 class="section__title">📺 Canal 48</h2>
        <div class="cards-grid">
            <?php foreach ($canal48Posts as $post): ?>
            <a href="index.php?page=post&id=<?= $post['id'] ?>" class="card">
                <div class="card__image">
                    <img src="<?= sanitize($post['image_url'] ?? '') ?>" alt="<?= sanitize($post['title']) ?>" loading="lazy">
                    <span class="badge badge--canal48">Canal 48</span>
                </div>
                <div class="card__body">
                    <span class="card__category"><?= sanitize($post['category_name'] ?? '') ?></span>
                    <h3 class="card__title"><?= sanitize($post['title']) ?></h3>
                    <p class="card__excerpt"><?= sanitize($post['excerpt'] ?? '') ?></p>
                    <div class="card__meta">
                        <span><?= formatDate($post['created_at']) ?></span>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <div style="text-align:center;margin-top:var(--space-xl);">
            <a href="index.php?page=canal48" class="btn btn--primary btn--small">Ver todo Canal 48</a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- VIDEOS -->
<?php if (!empty($featuredVideos)): ?>
<section class="section section--dark">
    <div class="container">
        <h2 class="section__title">🎥 Videos</h2>
        <div class="cards-grid">
            <?php foreach ($featuredVideos as $video): ?>
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

<!-- SECCIÓN TOP TRAVEL -->
<?php if (!empty($travelPosts)): ?>
<section class="section">
    <div class="container">
        <h2 class="section__title">✈️ Top Travel</h2>
        <div class="cards-grid">
            <?php foreach ($travelPosts as $post): ?>
            <a href="index.php?page=post&id=<?= $post['id'] ?>" class="card">
                <div class="card__image">
                    <img src="<?= sanitize($post['image_url'] ?? '') ?>" alt="<?= sanitize($post['title']) ?>" loading="lazy">
                    <span class="badge badge--toptravel">Top Travel</span>
                </div>
                <div class="card__body">
                    <span class="card__category"><?= sanitize($post['category_name'] ?? '') ?></span>
                    <h3 class="card__title"><?= sanitize($post['title']) ?></h3>
                    <p class="card__excerpt"><?= sanitize($post['excerpt'] ?? '') ?></p>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <div style="text-align:center;margin-top:var(--space-xl);">
            <a href="index.php?page=toptravel" class="btn btn--pink btn--small">Ver Top Travel</a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- CONOCE MÁS -->
<section class="section section--dark">
    <div class="container" style="text-align:center;max-width:700px;">
        <h2 class="section__title" style="justify-content:center;">Conoce más</h2>
        <p style="color:var(--text-secondary);margin-bottom:var(--space-xl);font-size:1.05rem;">
            TV Universo integra lo mejor del periodismo, el entretenimiento y los viajes. Dos marcas, una sola plataforma.
        </p>
        <div style="display:flex;gap:var(--space-md);justify-content:center;flex-wrap:wrap;">
            <a href="index.php?page=nosotros" class="btn btn--outline">Sobre nosotros</a>
            <a href="index.php?page=contacto" class="btn btn--primary">Contáctanos</a>
        </div>
    </div>
</section>
