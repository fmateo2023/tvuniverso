<?php
/**
 * TV Universo - Contacto
 * Formulario validado con PHP + JS
 */

$success = false;
$error = '';

// Procesar formulario
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
        <h1 class="page-header__title">📩 <span>Contacto</span></h1>
        <p class="page-header__desc">¿Tienes algo que decirnos? Estamos aquí para escucharte.</p>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="contact-grid">
            <!-- Formulario -->
            <div>
                <?php if ($success): ?>
                <div class="flash flash--success">✅ ¡Mensaje enviado correctamente! Te responderemos pronto.</div>
                <?php endif; ?>

                <?php if ($error): ?>
                <div class="flash flash--error"><?= $error ?></div>
                <?php endif; ?>

                <form method="POST" action="index.php?page=contacto" onsubmit="return validateContactForm(this)">
                    <?= csrfField() ?>

                    <div class="form-group">
                        <label for="name">Nombre completo</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Tu nombre" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Correo electrónico</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="tu@email.com" required>
                    </div>

                    <div class="form-group">
                        <label for="subject">Asunto</label>
                        <input type="text" name="subject" id="subject" class="form-control" placeholder="¿Sobre qué nos escribes?">
                    </div>

                    <div class="form-group">
                        <label for="message">Mensaje</label>
                        <textarea name="message" id="message" class="form-control" placeholder="Escribe tu mensaje aquí..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn--primary">Enviar mensaje</button>
                </form>
            </div>

            <!-- Info de contacto -->
            <div>
                <div class="contact-info__item">
                    <div class="contact-info__icon">📧</div>
                    <div>
                        <strong>Email</strong>
                        <p style="color:var(--text-secondary);font-size:0.9rem;"><?= sanitize($s['contact_email'] ?? '') ?></p>
                    </div>
                </div>

                <div class="contact-info__item">
                    <div class="contact-info__icon">📞</div>
                    <div>
                        <strong>Teléfono</strong>
                        <p style="color:var(--text-secondary);font-size:0.9rem;"><?= sanitize($s['contact_phone'] ?? '') ?></p>
                    </div>
                </div>

                <div class="contact-info__item">
                    <div class="contact-info__icon">📍</div>
                    <div>
                        <strong>Dirección</strong>
                        <p style="color:var(--text-secondary);font-size:0.9rem;"><?= sanitize($s['contact_address'] ?? '') ?></p>
                    </div>
                </div>

                <div class="contact-info__item">
                    <div class="contact-info__icon">🕐</div>
                    <div>
                        <strong>Horario</strong>
                        <p style="color:var(--text-secondary);font-size:0.9rem;">Lunes a Viernes: 9:00 - 18:00</p>
                    </div>
                </div>

                <div style="margin-top:var(--space-xl);">
                    <h4 style="margin-bottom:var(--space-md);font-size:0.9rem;">Síguenos</h4>
                    <div class="footer__social">
                        <a href="<?= sanitize($s['facebook'] ?? '#') ?>" target="_blank" rel="noopener">📘</a>
                        <a href="<?= sanitize($s['instagram'] ?? '#') ?>" target="_blank" rel="noopener">📷</a>
                        <a href="<?= sanitize($s['twitter'] ?? '#') ?>" target="_blank" rel="noopener">🐦</a>
                        <a href="<?= sanitize($s['youtube'] ?? '#') ?>" target="_blank" rel="noopener">▶️</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
