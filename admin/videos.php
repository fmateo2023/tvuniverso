<?php
/**
 * TV Universo - Admin: Gestión de Videos
 * CRUD completo
 */
$adminTitle = '🎥 Gestión de Videos';

$action = $_GET['action'] ?? 'list';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

require_once __DIR__ . '/layout.php';

$categories = getCategories();

// --- ELIMINAR ---
if ($action === 'delete' && $id) {
    if (isset($_GET['confirm']) && validateCsrf()) {
        $pdo->prepare("DELETE FROM videos WHERE id = :id")->execute([':id' => $id]);
        setFlash('Video eliminado correctamente.', 'success');
    }
    header('Location: videos.php');
    exit;
}

// --- GUARDAR ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && validateCsrf()) {
    $data = [
        ':title'       => sanitize($_POST['title'] ?? ''),
        ':url'         => filter_var(trim($_POST['url'] ?? ''), FILTER_SANITIZE_URL),
        ':thumbnail'   => filter_var(trim($_POST['thumbnail'] ?? ''), FILTER_SANITIZE_URL),
        ':category_id' => (int)($_POST['category_id'] ?? 0) ?: null,
        ':section'     => sanitize($_POST['section'] ?? 'canal48'),
        ':featured'    => isset($_POST['featured']) ? 1 : 0,
    ];

    if ($action === 'edit' && $id) {
        $data[':id'] = $id;
        $pdo->prepare("UPDATE videos SET title=:title, url=:url, thumbnail=:thumbnail, category_id=:category_id, section=:section, featured=:featured WHERE id=:id")->execute($data);
        setFlash('Video actualizado correctamente.', 'success');
    } else {
        $pdo->prepare("INSERT INTO videos (title, url, thumbnail, category_id, section, featured) VALUES (:title, :url, :thumbnail, :category_id, :section, :featured)")->execute($data);
        setFlash('Video agregado correctamente.', 'success');
    }
    header('Location: videos.php');
    exit;
}

// --- FORMULARIO ---
if ($action === 'create' || ($action === 'edit' && $id)):
    $video = ($action === 'edit') ? getVideoById($id) : null;
?>

<div style="margin-bottom:var(--space-lg);">
    <a href="videos.php" class="btn btn--outline btn--small">← Volver al listado</a>
</div>

<div class="admin-form">
    <form method="POST">
        <?= csrfField() ?>

        <div class="form-group">
            <label>Título</label>
            <input type="text" name="title" class="form-control" value="<?= sanitize($video['title'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>URL del video (embed)</label>
            <input type="url" name="url" class="form-control" value="<?= htmlspecialchars($video['url'] ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="https://www.youtube.com/embed/..." required>
            <span class="admin-form__hint">Usa la URL de embed de YouTube o Facebook</span>
        </div>

        <div class="form-group">
            <label>URL de thumbnail</label>
            <input type="url" name="thumbnail" class="form-control" value="<?= htmlspecialchars($video['thumbnail'] ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="https://...">
        </div>

        <div class="admin-form__row">
            <div class="form-group">
                <label>Categoría</label>
                <select name="category_id" class="form-control">
                    <option value="">Sin categoría</option>
                    <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= ($video['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                        <?= sanitize($cat['name']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Sección</label>
                <select name="section" class="form-control">
                    <option value="canal48" <?= ($video['section'] ?? '') === 'canal48' ? 'selected' : '' ?>>📺 Canal 48</option>
                    <option value="top" <?= ($video['section'] ?? '') === 'top' ? 'selected' : '' ?>>⭐ Lo Más Top</option>
                </select>
            </div>
        </div>

        <div class="form-check" style="margin-bottom:var(--space-lg);">
            <input type="checkbox" name="featured" id="featured" <?= !empty($video['featured']) ? 'checked' : '' ?>>
            <label for="featured">⭐ Video destacado</label>
        </div>

        <div class="admin-form__section-preview">
            👉 Selecciona sección para ver dónde aparecerá
        </div>

        <div style="margin-top:var(--space-xl);">
            <button type="submit" class="btn btn--primary"><?= $action === 'edit' ? 'Actualizar video' : 'Agregar video' ?></button>
        </div>
    </form>
</div>

<?php else:
// --- LISTADO ---
$allVideos = getVideos([], 50);
?>

<div style="margin-bottom:var(--space-lg);">
    <a href="videos.php?action=create" class="btn btn--primary btn--small">+ Nuevo video</a>
</div>

<div class="table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Sección</th>
                <th>Destacado</th>
                <th>Vistas</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($allVideos as $v): ?>
            <tr>
                <td><?= $v['id'] ?></td>
                <td><?= sanitize(truncateText($v['title'], 40)) ?></td>
                <td>
                    <span class="section-tag section-tag--<?= $v['section'] ?>">
                        <?= ucfirst($v['section']) ?>
                    </span>
                </td>
                <td><?= $v['featured'] ? '⭐' : '—' ?></td>
                <td><?= $v['views'] ?></td>
                <td><?= formatDate($v['created_at']) ?></td>
                <td class="admin-table__actions">
                    <a href="videos.php?action=edit&id=<?= $v['id'] ?>" class="btn-edit">Editar</a>
                    <a href="videos.php?action=delete&id=<?= $v['id'] ?>&confirm=1&<?= CSRF_TOKEN_NAME ?>=<?= generateCsrfToken() ?>" class="btn-delete" data-confirm="¿Eliminar este video?">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php endif; ?>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
