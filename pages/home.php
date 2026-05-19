<?php
/**
 * TV Universo - HOME
 * Estilo VOGA: Hero animado + Tendencia + Canal 48 + Top Travel
 */

$heroImage = $settings['hero_image'] ?? 'https://images.unsplash.com/photo-1478720568477-152d9b164e26?w=1200';
$featuredPosts = getPosts(['featured' => true, 'section' => 'home'], 4);
$trendingPosts = getPosts(['section' => 'tendencia'], 4);
$canal48Posts = getPosts(['type' => 'canal48'], 4);
$travelPosts = getPosts(['type' => 'toptravel'], 4);
$featuredVideos = getVideos(['featured' => true], 4);
?>

<!-- HERO -->
<section class="hero hero--new">
    <div class="hero__bg-new"></div>
    <div class="hero__overlay-new"></div>
    <div class="container">
        <div class="hero__grid">
            <div class="hero__content-new">
                <div class="hero__badge fade-up">
                    <span class="hero__badge-icon">📺</span>
                    <span>EN VIVO · NOTICIAS · ENTRETENIMIENTO</span>
                </div>
                <h1 class="hero__title-new fade-up stagger-1">
                    <span class="hero__title-main">TV</span>
                    <span class="hero__title-accent">Universo</span>
                </h1>
                <p class="hero__subtitle fade-up stagger-2">
                    La plataforma digital que conecta
                    <span class="hero__highlight">Canal 48</span> y 
                    <span class="hero__highlight">Top Travel</span>
                </p>
                <div class="hero__features fade-up stagger-3">
                    <div class="hero__feature">
                        <div class="hero__feature-icon" style="background: linear-gradient(135deg, #FF6B6B, #FF8E8E);">📺</div>
                        <span>Noticias en Vivo</span>
                    </div>
                    <div class="hero__feature">
                        <div class="hero__feature-icon" style="background: linear-gradient(135deg, #4ECDC4, #44A08D);">✈️</div>
                        <span>Turismo Premium</span>
                    </div>
                    <div class="hero__feature">
                        <div class="hero__feature-icon" style="background: linear-gradient(135deg, #FFD93D, #FF6B6B);">🎬</div>
                        <span>Entretenimiento</span>
                    </div>
                </div>
                <div class="hero__actions-new fade-up stagger-4">
                    <a href="index.php?page=canal48" class="btn btn--hero-primary">
                        <span class="btn__icon">📺</span>
                        <span>Canal 48</span>
                        <span class="btn__arrow">→</span>
                    </a>
                    <a href="index.php?page=toptravel" class="btn btn--hero-secondary">
                        <span class="btn__icon">✈️</span>
                        <span>Top Travel</span>
                        <span class="btn__arrow">→</span>
                    </a>
                </div>
                <div class="hero__stats fade-up stagger-5">
                    <div class="hero__stat">
                        <div class="hero__stat-number">24/7</div>
                        <div class="hero__stat-label">En Vivo</div>
                    </div>
                    <div class="hero__stat">
                        <div class="hero__stat-number">100+</div>
                        <div class="hero__stat-label">Destinos</div>
                    </div>
                    <div class="hero__stat">
                        <div class="hero__stat-number">1M+</div>
                        <div class="hero__stat-label">Usuarios</div>
                    </div>
                </div>
            </div>
            <div class="hero__visual fade-up stagger-2">
                <div class="hero__image-container">
                    <div class="hero__image-bg"></div>
                    <div class="hero__floating-elements">
                        <div class="hero__floating-card hero__floating-card--1">
                            <div class="hero__card-icon">📺</div>
                            <div class="hero__card-text">Canal 48</div>
                        </div>
                        <div class="hero__floating-card hero__floating-card--2">
                            <div class="hero__card-icon">✈️</div>
                            <div class="hero__card-text">Top Travel</div>
                        </div>
                        <div class="hero__floating-card hero__floating-card--3">
                            <div class="hero__card-icon">🔴</div>
                            <div class="hero__card-text">EN VIVO</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hero__decoration">
        <div class="hero__decoration-circle hero__decoration-circle--1"></div>
        <div class="hero__decoration-circle hero__decoration-circle--2"></div>
        <div class="hero__decoration-circle hero__decoration-circle--3"></div>
    </div>
</section>

<!-- TENDENCIA -->
<?php if (!empty($trendingPosts)): ?>
<section class="section section--modern">
    <div class="container">
        <div class="section-header">
            <div class="section-header__badge">
                <span class="section-header__icon">🔥</span>
                <span>Lo más popular</span>
            </div>
            <h2 class="section-header__title">
                En <span class="gradient-text">Tendencia</span>
            </h2>
            <p class="section-header__desc">Las noticias y contenido más relevante del momento</p>
        </div>
        <div class="cards-grid cards-grid--modern">
            <?php foreach ($trendingPosts as $post): ?>
            <a href="index.php?page=post&id=<?= $post['id'] ?>" class="card card--modern">
                <div class="card__image">
                    <img src="<?= sanitize($post['image_url'] ?? '') ?>" alt="<?= sanitize($post['title']) ?>" loading="lazy">
                    <div class="card__overlay">
                        <span class="card__badge card__badge--trending">🔥 Tendencia</span>
                    </div>
                </div>
                <div class="card__body">
                    <span class="card__category"><?= sanitize($post['category_name'] ?? '') ?></span>
                    <h3 class="card__title"><?= sanitize($post['title']) ?></h3>
                    <p class="card__excerpt"><?= sanitize($post['excerpt'] ?? '') ?></p>
                    <div class="card__meta">
                        <span class="card__date"><?= formatDate($post['created_at']) ?></span>
                        <span class="card__type"><?= $post['type'] === 'canal48' ? '📺 Canal 48' : '✈️ Top Travel' ?></span>
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
<section class="section section--canal48">
    <div class="container">
        <div class="section-header">
            <div class="section-header__badge section-header__badge--canal48">
                <span class="section-header__icon">📺</span>
                <span>Televisión en Vivo</span>
            </div>
            <h2 class="section-header__title">
                <span class="gradient-text-canal48">Canal 48</span>
            </h2>
            <p class="section-header__desc">Noticias, entretenimiento y programación en vivo las 24 horas</p>
        </div>
        <div class="canal48-showcase">
            <div class="canal48-featured">
                <div class="canal48-live-card">
                    <div class="canal48-live-indicator">
                        <span class="live-dot"></span>
                        <span>EN VIVO</span>
                    </div>
                    <h3>Transmisión en Directo</h3>
                    <p>Mantente informado con nuestras noticias en tiempo real</p>
                    <a href="index.php?page=canal48" class="btn btn--canal48">
                        <span>📺</span>
                        <span>Ver Canal 48</span>
                    </a>
                </div>
            </div>
            <div class="canal48-posts">
                <div class="cards-grid cards-grid--canal48">
                    <?php foreach ($canal48Posts as $post): ?>
                    <a href="index.php?page=post&id=<?= $post['id'] ?>" class="card card--canal48">
                        <div class="card__image">
                            <img src="<?= sanitize($post['image_url'] ?? '') ?>" alt="<?= sanitize($post['title']) ?>" loading="lazy">
                            <div class="card__overlay">
                                <span class="card__badge card__badge--canal48">📺 Canal 48</span>
                            </div>
                        </div>
                        <div class="card__body">
                            <span class="card__category"><?= sanitize($post['category_name'] ?? '') ?></span>
                            <h3 class="card__title"><?= sanitize($post['title']) ?></h3>
                            <p class="card__excerpt"><?= sanitize($post['excerpt'] ?? '') ?></p>
                            <div class="card__meta">
                                <span class="card__date"><?= formatDate($post['created_at']) ?></span>
                            </div>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
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
            <img src="assets/images/toptravel.jpg" alt="Top Travel" style="width:80px;height:80px;border-radius:var(--radius-lg);object-fit:cover;margin:0 auto var(--space-md);box-shadow:var(--shadow-card);">
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
