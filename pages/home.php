<?php
/**
 * TV Universo - HOME
 * Estilo VOGA: Hero animado + Tendencia + Canal 48 + Top Travel
 */

$heroImage = $settings['hero_image'] ?? 'assets/images/hero_canal48.png';
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
        <div class="fade-up" style="display:flex;align-items:center;gap:12px;margin-bottom:24px;">
            <div style="width:40px;height:2px;background:var(--rosa)"></div>
            <span style="font-size:0.8rem;letter-spacing:3px;text-transform:uppercase;color:var(--cafe);font-weight:500;">Noticias · Entretenimiento · Viajes</span>
            <div style="width:40px;height:2px;background:var(--rosa)"></div>
        </div>
        <h1 class="hero__title fade-up stagger-1">
            TV <span>Universo</span>
        </h1>
        <p class="hero__desc fade-up stagger-2" style="color:#fff;">Tu ventana al mundo. Donde la información cobra vida.</p>
        <div class="hero__actions fade-up stagger-3">
            <a href="index.php?page=canal48" class="btn btn--primary">📺 Canal 48</a>
            <a href="index.php?page=toptravel" class="btn btn--outline-yellow">✈️ Top Travel</a>
        </div>
        <div class="color-dots fade-up stagger-4">
            <span style="background:var(--rosa)"></span>
            <span style="background:var(--amarillo)"></span>
            <span style="background:var(--azul)"></span>
            <span style="background:var(--verde)"></span>
            <span style="background:var(--cafe)"></span>
        </div>
    </div>
</section>

<!-- TENDENCIA -->
<?php if (!empty($trendingPosts)): ?>
<section class="section">
    <div class="container">
        <div style="text-align:center;margin-bottom:var(--space-2xl);">
            <span style="color:var(--rosa);font-size:0.8rem;letter-spacing:3px;text-transform:uppercase;font-weight:600;">Lo último</span>
            <h2 style="font-family:var(--font-heading);font-size:2.5rem;font-weight:900;margin-top:8px;">En Tendencia</h2>
            <div style="width:60px;height:3px;background:linear-gradient(90deg,var(--rosa),var(--amarillo));margin:16px auto 0;border-radius:2px;"></div>
        </div>
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
        <div style="text-align:center;margin-bottom:var(--space-2xl);">
            <span style="color:var(--azul);font-size:0.8rem;letter-spacing:3px;text-transform:uppercase;font-weight:600;">Destacados</span>
            <h2 style="font-family:var(--font-heading);font-size:2.5rem;font-weight:900;margin-top:8px;">Explorar</h2>
            <div style="width:60px;height:3px;background:linear-gradient(90deg,var(--azul),var(--verde));margin:16px auto 0;border-radius:2px;"></div>
        </div>
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
        <div style="text-align:center;margin-bottom:var(--space-2xl);">
            <img src="assets/images/favicon.png" alt="Canal 48" style="width:80px;height:80px;border-radius:var(--radius-lg);object-fit:cover;margin:0 auto var(--space-md);box-shadow:var(--shadow-card);">
            <span style="color:var(--azul);font-size:0.8rem;letter-spacing:3px;text-transform:uppercase;font-weight:600;display:block;">Televisión</span>
            <h2 style="font-family:var(--font-heading);font-size:2.5rem;font-weight:900;margin-top:8px;">Canal 48</h2>
            <div style="width:60px;height:3px;background:linear-gradient(90deg,var(--azul),var(--rosa));margin:16px auto 0;border-radius:2px;"></div>
        </div>
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
        <div style="text-align:center;margin-bottom:var(--space-2xl);">
            <span style="color:var(--amarillo);font-size:0.8rem;letter-spacing:3px;text-transform:uppercase;font-weight:600;">Multimedia</span>
            <h2 style="font-family:var(--font-heading);font-size:2.5rem;font-weight:900;margin-top:8px;">🎥 Videos</h2>
            <div style="width:60px;height:3px;background:linear-gradient(90deg,var(--amarillo),var(--rosa));margin:16px auto 0;border-radius:2px;"></div>
        </div>
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
        <div style="text-align:center;margin-bottom:var(--space-2xl);">
            <img src="assets/images/toptravel_negro.jpg" alt="Top Travel" style="width:80px;height:80px;border-radius:var(--radius-lg);object-fit:cover;margin:0 auto var(--space-md);box-shadow:var(--shadow-card);">
            <span style="color:var(--cafe);font-size:0.8rem;letter-spacing:3px;text-transform:uppercase;font-weight:600;display:block;">Revista Digital</span>
            <h2 style="font-family:var(--font-heading);font-size:2.5rem;font-weight:900;margin-top:8px;">Top Travel</h2>
            <div style="width:60px;height:3px;background:linear-gradient(90deg,var(--cafe),var(--verde));margin:16px auto 0;border-radius:2px;"></div>
        </div>
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
            <a href="index.php?page=toptravel" class="btn btn--outline btn--small">Ver Top Travel</a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- CONOCE MÁS -->
<section class="section section--dark">
    <div class="container" style="text-align:center;max-width:700px;">
        <span style="color:var(--verde);font-size:0.8rem;letter-spacing:3px;text-transform:uppercase;font-weight:600;">Descubre</span>
        <h2 style="font-family:var(--font-heading);font-size:2.5rem;font-weight:900;margin-top:8px;margin-bottom:var(--space-md);">Conoce más</h2>
        <div style="width:60px;height:3px;background:linear-gradient(90deg,var(--verde),var(--azul));margin:0 auto 24px;border-radius:2px;"></div>
        <p style="color:var(--text-secondary);margin-bottom:var(--space-xl);font-size:1.05rem;font-family:var(--font-heading);font-style:italic;">
            TV Universo integra lo mejor del periodismo, el entretenimiento y los viajes. Dos marcas, una sola plataforma.
        </p>
        <div style="display:flex;gap:var(--space-md);justify-content:center;flex-wrap:wrap;">
            <a href="index.php?page=nosotros" class="btn btn--outline">Sobre nosotros</a>
            <a href="index.php?page=contacto" class="btn btn--primary">Contáctanos</a>
        </div>
    </div>
</section>
