<?php
/**
 * TV Universo - Admin: Gestión de Usuarios
 * Solo accesible por admin
 */
$adminTitle = '👤 Usuarios';

$action = $_GET['action'] ?? 'list';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

require_once __DIR__ . '/layout.php';
requireAdmin(); // Solo admin puede gestionar usuarios

// --- ELIMINAR ---
if ($action === 'delete' && $id) {
    if ($id === (int)$_SESSION['user_id']) {
        setFlash('No puedes eliminar tu propio usuario.', 'error');
    } elseif (isset($_GET['confirm']) && validateCsrf()) {
        $pdo->prepare("DELETE FROM users WHERE id = :id")->execute([':id' => $id]);
        setFlash('Usuario eliminado.', 'success');
    }
    header('Location: users.php');
    exit;
}

// --- GUARDAR ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && validateCsrf()) {
    $username = sanitize($_POST['username'] ?? '');
    $email    = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $role     = in_array($_POST['role'] ?? '', ['admin', 'editor']) ? $_POST['role'] : 'editor';
    $password = $_POST['password'] ?? '';

    if (!$username || !$email) {
        setFlash('Completa todos los campos obligatorios.', 'error');
    } else {
        if ($action === 'edit' && $id) {
            if ($password) {
                $pdo->prepare("UPDATE users SET username=:username, email=:email, role=:role, password=:password WHERE id=:id")
                    ->execute([':username' => $username, ':email' => $email, ':role' => $role, ':password' => hashPassword($password), ':id' => $id]);
            } else {
                $pdo->prepare("UPDATE users SET username=:username, email=:email, role=:role WHERE id=:id")
                    ->execute([':username' => $username, ':email' => $email, ':role' => $role, ':id' => $id]);
            }
            setFlash('Usuario actualizado.', 'success');
        } else {
            if (!$password) {
                setFlash('La contraseña es obligatoria para nuevos usuarios.', 'error');
            } else {
                $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)")
                    ->execute([':username' => $username, ':email' => $email, ':password' => hashPassword($password), ':role' => $role]);
                setFlash('Usuario creado.', 'success');
            }
        }
    }
    header('Location: users.php');
    exit;
}

// --- FORMULARIO ---
if ($action === 'create' || ($action === 'edit' && $id)):
    $editUser = null;
    if ($action === 'edit') {
        $stmt = $pdo->prepare("SELECT id, username, email, role FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $editUser = $stmt->fetch();
    }
?>

<div style="margin-bottom:var(--space-lg);">
    <a href="users.php" class="btn btn--outline btn--small">← Volver</a>
</div>

<div class="admin-form" style="max-width:500px;">
    <form method="POST">
        <?= csrfField() ?>
        <div class="form-group">
            <label>Usuario</label>
            <input type="text" name="username" class="form-control" value="<?= sanitize($editUser['username'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= sanitize($editUser['email'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Contraseña <?= $action === 'edit' ? '(dejar vacío para no cambiar)' : '' ?></label>
            <input type="password" name="password" class="form-control" <?= $action === 'create' ? 'required' : '' ?>>
        </div>
        <div class="form-group">
            <label>Rol</label>
            <select name="role" class="form-control">
                <option value="editor" <?= ($editUser['role'] ?? '') === 'editor' ? 'selected' : '' ?>>Editor</option>
                <option value="admin" <?= ($editUser['role'] ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn--primary"><?= $action === 'edit' ? 'Actualizar' : 'Crear usuario' ?></button>
    </form>
</div>

<?php else:
$stmt = $pdo->query("SELECT id, username, email, role, created_at FROM users ORDER BY id");
$allUsers = $stmt->fetchAll();
?>

<div style="margin-bottom:var(--space-lg);">
    <a href="users.php?action=create" class="btn btn--primary btn--small">+ Nuevo usuario</a>
</div>

<div class="table-wrapper">
    <table class="admin-table">
        <thead>
            <tr><th>ID</th><th>Usuario</th><th>Email</th><th>Rol</th><th>Fecha</th><th>Acciones</th></tr>
        </thead>
        <tbody>
            <?php foreach ($allUsers as $u): ?>
            <tr>
                <td><?= $u['id'] ?></td>
                <td><?= sanitize($u['username']) ?></td>
                <td><?= sanitize($u['email']) ?></td>
                <td><span class="badge <?= $u['role'] === 'admin' ? 'badge--canal48' : 'badge--toptravel' ?>"><?= $u['role'] ?></span></td>
                <td><?= formatDate($u['created_at']) ?></td>
                <td class="admin-table__actions">
                    <a href="users.php?action=edit&id=<?= $u['id'] ?>" class="btn-edit">Editar</a>
                    <?php if ($u['id'] !== (int)$_SESSION['user_id']): ?>
                    <a href="users.php?action=delete&id=<?= $u['id'] ?>&confirm=1&<?= CSRF_TOKEN_NAME ?>=<?= generateCsrfToken() ?>" class="btn-delete" data-confirm="¿Eliminar este usuario?">Eliminar</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php endif; ?>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
