<?php
/**
 * TV Universo - Admin: Mensajes de Contacto
 */
$adminTitle = '📩 Mensajes';

require_once __DIR__ . '/layout.php';

// Marcar como leído
if (isset($_GET['read']) && (int)$_GET['read']) {
    $pdo->prepare("UPDATE contacts SET read_status = 1 WHERE id = :id")->execute([':id' => (int)$_GET['read']]);
    header('Location: contacts.php');
    exit;
}

// Eliminar
if (isset($_GET['delete']) && (int)$_GET['delete'] && validateCsrf()) {
    $pdo->prepare("DELETE FROM contacts WHERE id = :id")->execute([':id' => (int)$_GET['delete']]);
    setFlash('Mensaje eliminado.', 'success');
    header('Location: contacts.php');
    exit;
}

$contacts = getContacts(50);
?>

<?php if (empty($contacts)): ?>
<p style="color:var(--text-secondary);text-align:center;padding:var(--space-2xl);">No hay mensajes.</p>
<?php else: ?>
<div class="table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Estado</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Asunto</th>
                <th>Mensaje</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $c): ?>
            <tr style="<?= !$c['read_status'] ? 'background:rgba(47,107,255,0.05);' : '' ?>">
                <td><?= $c['read_status'] ? '✅' : '🔵 Nuevo' ?></td>
                <td><?= sanitize($c['name']) ?></td>
                <td><a href="mailto:<?= sanitize($c['email']) ?>" style="color:var(--blue);"><?= sanitize($c['email']) ?></a></td>
                <td><?= sanitize($c['subject'] ?? '—') ?></td>
                <td><?= sanitize(truncateText($c['message'], 60)) ?></td>
                <td><?= formatDate($c['created_at']) ?></td>
                <td class="admin-table__actions">
                    <?php if (!$c['read_status']): ?>
                    <a href="contacts.php?read=<?= $c['id'] ?>" class="btn-edit">Marcar leído</a>
                    <?php endif; ?>
                    <a href="contacts.php?delete=<?= $c['id'] ?>&<?= CSRF_TOKEN_NAME ?>=<?= generateCsrfToken() ?>" class="btn-delete" data-confirm="¿Eliminar este mensaje?">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
