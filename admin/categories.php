<?php
/**
 * TV Universo - Admin: Gestión de Categorías
 */
$adminTitle = '🗂️ Categorías';

$action = $_GET['action'] ?? 'list';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

require_once __DIR__ . '/layout.php';

// --- ELIMINAR ---
if ($action === 'delete' && $id) {
    if (isset($_GET['confirm']) && validateCsrf()) {
        $pdo->prepare("DELETE FROM categories WHERE id = :id")->execute([':id' => $id]);
        setFlash('Categoría eliminada.', 'success');
    }
    header('Location: categories.php');
    exit;
}

// --- GUARDAR ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && validateCsrf()) {
    $name = sanitize($_POST['name'] ?? '');
    $type = in_array($_POST['type'] ?? '', ['noticias', 'revista']) ? $_POST['type'] : 'noticias';

    if ($action === 'edit' && $id) {
        $pdo->prepare("UPDATE categories SET name=:name, type=:type WHERE id=:id")->execute([':name' => $name, ':type' => $type, ':id' => $id]);
        setFlash('Categoría actualizada.', 'success');
    } else {
        $pdo->prepare("INSERT INTO categories (name, type) VALUES (:name, :type)")->execute([':name' => $name, ':type' => $type]);
        setFlash('Categoría creada.', 'success');
    }
    header('Location: categories.php');
    exit;
}

// --- FORMULARIO ---
if ($action === 'create' || ($action === 'edit' && $id)):
    $cat = ($action === 'edit') ? getCategoryById($id) : null;
?>

<div style="margin-bottom:var(--space-lg);">
    <a href="categories.php" class="btn btn--outline btn--small">← Volver</a>
</div>

<div class="admin-form" style="max-width:500px;">
    <form method="POST">
        <?= csrfField() ?>
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="name" class="form-control" value="<?= sanitize($cat['name'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Tipo</label>
            <select name="type" class="form-control">
                <option value="noticias" <?= ($cat['type'] ?? '') === 'noticias' ? 'selected' : '' ?>>📰 Noticias (Canal 48)</option>
                <option value="revista" <?= ($cat['type'] ?? '') === 'revista' ? 'selected' : '' ?>>✈️ Revista (Top Travel)</option>
            </select>
        </div>
        <button type="submit" class="btn btn--primary"><?= $action === 'edit' ? 'Actualizar' : 'Crear categoría' ?></button>
    </form>
</div>

<?php else:
$allCats = getCategories();
?>

<div style="margin-bottom:var(--space-lg);">
    <a href="categories.php?action=create" class="btn btn--primary btn--small">+ Nueva categoría</a>
</div>

<div class="table-wrapper">
    <table class="admin-table">
        <thead>
            <tr><th>ID</th><th>Nombre</th><th>Tipo</th><th>Acciones</th></tr>
        </thead>
        <tbody>
            <?php foreach ($allCats as $c): ?>
            <tr>
                <td><?= $c['id'] ?></td>
                <td><?= sanitize($c['name']) ?></td>
                <td>
                    <span class="section-tag <?= $c['type'] === 'noticias' ? 'section-tag--canal48' : 'section-tag--toptravel' ?>">
                        <?= $c['type'] === 'noticias' ? '📰 Noticias' : '✈️ Revista' ?>
                    </span>
                </td>
                <td class="admin-table__actions">
                    <a href="categories.php?action=edit&id=<?= $c['id'] ?>" class="btn-edit">Editar</a>
                    <a href="categories.php?action=delete&id=<?= $c['id'] ?>&confirm=1&<?= CSRF_TOKEN_NAME ?>=<?= generateCsrfToken() ?>" class="btn-delete" data-confirm="¿Eliminar esta categoría?">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php endif; ?>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
