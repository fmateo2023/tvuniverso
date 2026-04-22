<?php
/**
 * TV Universo - Admin: Gestión de Noticias (Posts)
 * CRUD completo con indicador de sección
 */
$adminTitle = '📰 Gestión de Noticias';

$action = $_GET['action'] ?? 'list';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

require_once __DIR__ . '/layout.php';

$categories = getCategories();

// --- ELIMINAR ---
if ($action === 'delete' && $id) {
    if (isset($_GET['confirm']) && validateCsrf()) {
        $pdo->prepare("DELETE FROM posts WHERE id = :id")->execute([':id' => $id]);
        setFlash('Noticia eliminada correctamente.', 'success');
    }
    header('Location: posts.php');
    exit;
}

// --- GUARDAR (crear/editar) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && validateCsrf()) {
    $data = [
        ':title'       => sanitize($_POST['title'] ?? ''),
        ':content'     => sanitize($_POST['content'] ?? ''),
        ':excerpt'     => sanitize($_POST['excerpt'] ?? ''),
        ':image_url'   => sanitize($_POST['image_url'] ?? ''),
        ':category_id' => (int)($_POST['category_id'] ?? 0) ?: null,
        ':type'        => in_array($_POST['type'] ?? '', ['canal48', 'toptravel']) ? $_POST['type'] : 'canal48',
        ':section'     => sanitize($_POST['section'] ?? 'home'),
        ':featured'    => isset($_POST['featured']) ? 1 : 0,
    ];

    if ($action === 'edit' && $id) {
        $data[':id'] = $id;
        $pdo->prepare("UPDATE posts SET title=:title, content=:content, excerpt=:excerpt, image_url=:image_url, category_id=:category_id, type=:type, section=:section, featured=:featured WHERE id=:id")->execute($data);
        setFlash('Noticia actualizada correctamente.', 'success');
    } else {
        $pdo->prepare("INSERT INTO posts (title, content, excerpt, image_url, category_id, type, section, featured) VALUES (:title, :content, :excerpt, :image_url, :category_id, :type, :section, :featured)")->execute($data);
        setFlash('Noticia creada correctamente.', 'success');
    }
    header('Location: posts.php');
    exit;
}

// --- FORMULARIO (crear/editar) ---
if ($action === 'create' || ($action === 'edit' && $id)):
    $post = ($action === 'edit') ? getPostById($id) : null;
?>

<div style="margin-bottom:var(--space-lg);">
    <a href="posts.php" class="btn btn--outline btn--small">← Volver al listado</a>
</div>

<div class="admin-form">
    <form method="POST">
        <?= csrfField() ?>

        <div class="admin-form__row">
            <div class="form-group">
                <label>Título</label>
                <input type="text" name="title" class="form-control" value="<?= sanitize($post['title'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label>Extracto</label>
                <input type="text" name="excerpt" class="form-control" value="<?= sanitize($post['excerpt'] ?? '') ?>" placeholder="Resumen corto">
            </div>
        </div>

        <div class="form-group">
            <label>Contenido</label>
            <textarea name="content" class="form-control" style="min-height:200px;" required><?= sanitize($post['content'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
            <label>URL de imagen</label>
            <input type="url" name="image_url" class="form-control" value="<?= sanitize($post['image_url'] ?? '') ?>" placeholder="https://...">
            <span class="admin-form__hint">Pega la URL de una imagen o sube a /uploads</span>
        </div>

        <div class="admin-form__row">
            <div class="form-group">
                <label>Categoría</label>
                <select name="category_id" class="form-control">
                    <option value="">Sin categoría</option>
                    <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= ($post['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                        <?= sanitize($cat['name']) ?> (<?= $cat['type'] ?>)
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Marca / Tipo</label>
                <select name="type" class="form-control">
                    <option value="canal48" <?= ($post['type'] ?? '') === 'canal48' ? 'selected' : '' ?>>📺 Canal 48</option>
                    <option value="toptravel" <?= ($post['type'] ?? '') === 'toptravel' ? 'selected' : '' ?>>✈️ Top Travel</option>
                </select>
            </div>
        </div>

        <div class="admin-form__row">
            <div class="form-group">
                <label>Sección de visualización</label>
                <select name="section" class="form-control">
                    <option value="home" <?= ($post['section'] ?? '') === 'home' ? 'selected' : '' ?>>🏠 Home</option>
                    <option value="tendencia" <?= ($post['section'] ?? '') === 'tendencia' ? 'selected' : '' ?>>🔥 Tendencia</option>
                    <option value="top" <?= ($post['section'] ?? '') === 'top' ? 'selected' : '' ?>>⭐ Lo Más Top</option>
                    <option value="canal48" <?= ($post['section'] ?? '') === 'canal48' ? 'selected' : '' ?>>📺 Canal 48</option>
                    <option value="toptravel" <?= ($post['section'] ?? '') === 'toptravel' ? 'selected' : '' ?>>✈️ Top Travel</option>
                </select>
            </div>
            <div class="form-group">
                <label>&nbsp;</label>
                <div class="form-check">
                    <input type="checkbox" name="featured" id="featured" <?= !empty($post['featured']) ? 'checked' : '' ?>>
                    <label for="featured">⭐ Contenido destacado</label>
                </div>
            </div>
        </div>

        <!-- Preview de sección -->
        <div class="admin-form__section-preview">
            👉 Selecciona sección y tipo para ver dónde aparecerá
        </div>

        <div style="margin-top:var(--space-xl);">
            <button type="submit" class="btn btn--primary"><?= $action === 'edit' ? 'Actualizar noticia' : 'Crear noticia' ?></button>
        </div>
    </form>
</div>

<?php else:
// --- LISTADO ---
$allPosts = getPosts([], 50);
?>

<div style="margin-bottom:var(--space-lg);">
    <a href="posts.php?action=create" class="btn btn--primary btn--small">+ Nueva noticia</a>
</div>

<div class="table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Tipo</th>
                <th>Sección</th>
                <th>Destacado</th>
                <th>Vistas</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($allPosts as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= sanitize(truncateText($p['title'], 40)) ?></td>
                <td>
                    <span class="section-tag section-tag--<?= $p['type'] ?>">
                        <?= $p['type'] === 'canal48' ? '📺 Canal 48' : '✈️ Top Travel' ?>
                    </span>
                </td>
                <td>
                    <span class="section-tag section-tag--<?= $p['section'] ?>">
                        <?= ucfirst($p['section']) ?>
                    </span>
                </td>
                <td><?= $p['featured'] ? '⭐' : '—' ?></td>
                <td><?= $p['views'] ?></td>
                <td><?= formatDate($p['created_at']) ?></td>
                <td class="admin-table__actions">
                    <a href="posts.php?action=edit&id=<?= $p['id'] ?>" class="btn-edit">Editar</a>
                    <a href="posts.php?action=delete&id=<?= $p['id'] ?>&confirm=1&<?= CSRF_TOKEN_NAME ?>=<?= generateCsrfToken() ?>" class="btn-delete" data-confirm="¿Eliminar esta noticia?">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php endif; ?>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
