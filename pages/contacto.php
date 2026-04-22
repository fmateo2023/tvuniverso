<?php
/**
 * TV Universo - Contacto
 * Estilo VOGA: card oscura + formulario blanco (responsive)
 */

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrf()) {
        $error = 'Token de seguridad inválido. Intenta de nuevo.';
    } else {
        $name    = sanitize($_POST['name'] ?? '');
        $email   = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
        $subject = sanitize($_POST['subject'] ?? '');
        $message = sanitize($_POST['message'] ?? '');

        if (!$name || !$email || !$message || mb_strlen($message) < 10) {
            $error = 'Por favor completa todos los campos correctamente.';
        } else {
            try {
                $stmt = $pdo->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (:name, :email, :subject, :message)");
                $stmt->execute([
                    ':name'    => $name,
                    ':email'   => $email,
                    ':subject' => $subject,
                    ':message' => $message,
                ]);
                $success = true;
            } catch (PDOException $e) {
                error_log("Error contacto: " . $e->getMessage());
                $error = 'Error al enviar el mensaje. Intenta más tarde.';
            }
        }
    }
}

$s = $settings ?? getAllSettings();
?>

<div class="page-header">
    <div class="container">
        <span style="color:var(--cafe);font-size:0.8rem;letter-spacing:3px;text-transform:uppercase;font-weight:600;">Hablemos</span>
        <h1 class="page-header__title" style="margin-top:8px;">📩 <span>Contáctanos</span></h1>
        <div style="width:60px;height:3px;background:linear-gradient(90deg,var(--cafe),var(--rosa));margin-top:16px;border-radius:2px;"></div>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="contact-grid">
            <!-- Info Card Oscura -->
            <div class="contact-info-card">
                <div class="contact-info-card__deco contact-info-card__deco--top"></div>
                <div class="contact-info-card__deco contact-info-card__deco--bottom"></div>

                <div style="position:relative;z-index:1;">
                    <h3 style="font-family:var(--font-heading);font-size:1.5rem;font-weight:900;margin-bottom:var(--space-md);letter-spacing:1px;color:#fff;">TV Universo</h3>
                    <p style="color:rgba(255,255,255,0.5);line-height:1.7;margin-bottom:var(--space-2xl);">Estamos aquí para escucharte. Ya sea que desees colaborar, anunciarte o simplemente decir hola.</p>

                    <div class="contact-info-list">
                        <div class="contact-info-row">
                            <div class="contact-info-icon" style="background:rgba(232,76,138,0.15);">📍</div>
                            <div class="contact-info-text">
                                <span class="contact-info-label">Dirección</span>
                                <p><?= sanitize($s['contact_address'] ?? '') ?></p>
                            </div>
                        </div>
                        <div class="contact-info-row">
                            <div class="contact-info-icon" style="background:rgba(242,183,5,0.15);">📞</div>
                            <div class="contact-info-text">
                                <span class="contact-info-label">Teléfono</span>
                                <p><?= sanitize($s['contact_phone'] ?? '') ?></p>
                            </div>
                        </div>
                        <div class="contact-info-row">
                            <div class="contact-info-icon" style="background:rgba(42,127,191,0.15);">📧</div>
                            <div class="contact-info-text">
                                <span class="contact-info-label">Email</span>
                                <p><?= sanitize($s['contact_email'] ?? '') ?></p>
                            </div>
                        </div>
                        <div class="contact-info-row">
                            <div class="contact-info-icon" style="background:rgba(76,175,125,0.15);">🕐</div>
                            <div class="contact-info-text">
                                <span class="contact-info-label">Horario</span>
                                <p>Lun - Vie: 9:00 - 18:00</p>
                            </div>
                        </div>
                    </div>

                    <div class="contact-social">
                        <a href="<?= sanitize($s['facebook'] ?? '#') ?>" target="_blank" rel="noopener">📘</a>
                        <a href="<?= sanitize($s['instagram'] ?? '#') ?>" target="_blank" rel="noopener">📷</a>
                        <a href="<?= sanitize($s['twitter'] ?? '#') ?>" target="_blank" rel="noopener">🐦</a>
                    </div>
                </div>
            </div>

            <!-- Formulario Blanco -->
            <div class="contact-form-card">
                <h3 style="font-family:var(--font-heading);font-size:1.3rem;font-weight:700;margin-bottom:6px;">Envíanos un mensaje</h3>
                <p style="color:var(--text-muted);font-size:0.9rem;margin-bottom:var(--space-xl);">Completa el formulario y te responderemos lo antes posible.</p>

                <?php if ($success): ?>
                <div class="flash flash--success">✅ ¡Mensaje enviado correctamente! Te responderemos pronto.</div>
                <?php endif; ?>

                <?php if ($error): ?>
                <div class="flash flash--error"><?= $error ?></div>
                <?php endif; ?>

                <form method="POST" action="index.php?page=contacto" onsubmit="return validateContactForm(this)">
                    <?= csrfField() ?>

                    <div class="contact-form-row">
                        <div class="form-group" style="margin-bottom:0;">
                            <label for="name">Nombre</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Tu nombre" required>
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="tu@email.com" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="subject">Asunto</label>
                        <input type="text" name="subject" id="subject" class="form-control" placeholder="¿Sobre qué nos escribes?">
                    </div>

                    <div class="form-group">
                        <label for="message">Mensaje</label>
                        <textarea name="message" id="message" class="form-control" placeholder="¿En qué podemos ayudarte?" required></textarea>
                    </div>

                    <button type="submit" class="btn btn--primary" style="width:100%;justify-content:center;">Enviar Mensaje</button>
                </form>
            </div>
        </div>
    </div>
</section>
