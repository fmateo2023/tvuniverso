<?php
/**
 * TV Universo - Contacto
 * Estilo VOGA: card oscura + formulario blanco
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
            <div style="background:var(--oscuro);border-radius:var(--radius-xl);padding:2.5rem;color:#fff;position:relative;overflow:hidden;">
                <div style="position:absolute;top:0;right:0;width:150px;height:150px;background:radial-gradient(circle,rgba(232,76,138,0.15),transparent 70%);border-radius:0 0 0 100%;"></div>
                <div style="position:absolute;bottom:0;left:0;width:120px;height:120px;background:radial-gradient(circle,rgba(42,127,191,0.15),transparent 70%);border-radius:0 100% 0 0;"></div>

                <div style="position:relative;z-index:1;">
                    <h3 style="font-family:var(--font-heading);font-size:1.5rem;font-weight:900;margin-bottom:var(--space-md);letter-spacing:1px;">TV Universo</h3>
                    <p style="color:rgba(255,255,255,0.5);line-height:1.7;margin-bottom:var(--space-2xl);">Estamos aquí para escucharte. Ya sea que desees colaborar, anunciarte o simplemente decir hola.</p>

                    <div style="display:flex;flex-direction:column;gap:var(--space-lg);">
                        <div style="display:flex;align-items:flex-start;gap:var(--space-md);">
                            <div style="width:40px;height:40px;border-radius:var(--radius-md);background:rgba(232,76,138,0.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;">📍</div>
                            <div>
                                <p style="color:rgba(255,255,255,0.35);font-size:0.7rem;text-transform:uppercase;letter-spacing:1px;margin-bottom:4px;">Dirección</p>
                                <p style="font-weight:500;"><?= sanitize($s['contact_address'] ?? '') ?></p>
                            </div>
                        </div>
                        <div style="display:flex;align-items:flex-start;gap:var(--space-md);">
                            <div style="width:40px;height:40px;border-radius:var(--radius-md);background:rgba(242,183,5,0.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;">📞</div>
                            <div>
                                <p style="color:rgba(255,255,255,0.35);font-size:0.7rem;text-transform:uppercase;letter-spacing:1px;margin-bottom:4px;">Teléfono</p>
                                <p style="font-weight:500;"><?= sanitize($s['contact_phone'] ?? '') ?></p>
                            </div>
                        </div>
                        <div style="display:flex;align-items:flex-start;gap:var(--space-md);">
                            <div style="width:40px;height:40px;border-radius:var(--radius-md);background:rgba(42,127,191,0.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;">📧</div>
                            <div>
                                <p style="color:rgba(255,255,255,0.35);font-size:0.7rem;text-transform:uppercase;letter-spacing:1px;margin-bottom:4px;">Email</p>
                                <p style="font-weight:500;"><?= sanitize($s['contact_email'] ?? '') ?></p>
                            </div>
                        </div>
                        <div style="display:flex;align-items:flex-start;gap:var(--space-md);">
                            <div style="width:40px;height:40px;border-radius:var(--radius-md);background:rgba(76,175,125,0.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;">🕐</div>
                            <div>
                                <p style="color:rgba(255,255,255,0.35);font-size:0.7rem;text-transform:uppercase;letter-spacing:1px;margin-bottom:4px;">Horario</p>
                                <p style="font-weight:500;">Lun - Vie: 9:00 - 18:00</p>
                            </div>
                        </div>
                    </div>

                    <div style="display:flex;gap:10px;margin-top:var(--space-2xl);">
                        <a href="<?= sanitize($s['facebook'] ?? '#') ?>" target="_blank" rel="noopener" style="width:40px;height:40px;border-radius:50%;border:1px solid rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;transition:all 0.3s;">📘</a>
                        <a href="<?= sanitize($s['instagram'] ?? '#') ?>" target="_blank" rel="noopener" style="width:40px;height:40px;border-radius:50%;border:1px solid rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;transition:all 0.3s;">📷</a>
                        <a href="<?= sanitize($s['twitter'] ?? '#') ?>" target="_blank" rel="noopener" style="width:40px;height:40px;border-radius:50%;border:1px solid rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;transition:all 0.3s;">🐦</a>
                    </div>
                </div>
            </div>

            <!-- Formulario Blanco -->
            <div style="background:var(--bg-card);border-radius:var(--radius-xl);padding:2.5rem;box-shadow:var(--shadow-card);">
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

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--space-md);margin-bottom:var(--space-md);">
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
