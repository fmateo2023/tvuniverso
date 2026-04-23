<?php
/**
 * TV Universo - Funciones auxiliares
 * Helpers para consultas, sanitización y utilidades generales
 */

require_once __DIR__ . '/../config.php';

// =============================================
// SANITIZACIÓN Y SEGURIDAD
// =============================================

/** Sanitiza una cadena para prevenir XSS */
function sanitize(string $input): string {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/** Genera un token CSRF y lo almacena en sesión */
function generateCsrfToken(): string {
    if (empty($_SESSION[CSRF_TOKEN_NAME])) {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }
    return $_SESSION[CSRF_TOKEN_NAME];
}

/** Devuelve un input hidden con el token CSRF */
function csrfField(): string {
    return '<input type="hidden" name="' . CSRF_TOKEN_NAME . '" value="' . generateCsrfToken() . '">';
}

/** Valida el token CSRF del formulario */
function validateCsrf(): bool {
    $token = $_POST[CSRF_TOKEN_NAME] ?? '';
    if (empty($token) || !hash_equals($_SESSION[CSRF_TOKEN_NAME] ?? '', $token)) {
        return false;
    }
    unset($_SESSION[CSRF_TOKEN_NAME]); // Token de un solo uso
    return true;
}

// =============================================
// CONSULTAS A BASE DE DATOS
// =============================================

/** Obtiene posts con filtros opcionales */
function getPosts(array $filters = [], int $limit = 20): array {
    global $pdo;
    $sql = "SELECT p.*, c.name AS category_name FROM posts p LEFT JOIN categories c ON p.category_id = c.id WHERE 1=1";
    $params = [];

    if (!empty($filters['type'])) {
        $sql .= " AND p.type = :type";
        $params[':type'] = $filters['type'];
    }
    if (!empty($filters['section'])) {
        $sql .= " AND p.section = :section";
        $params[':section'] = $filters['section'];
    }
    if (!empty($filters['featured'])) {
        $sql .= " AND p.featured = 1";
    }
    if (!empty($filters['category_id'])) {
        $sql .= " AND p.category_id = :category_id";
        $params[':category_id'] = $filters['category_id'];
    }

    $sql .= " ORDER BY p.created_at DESC LIMIT :limit";

    $stmt = $pdo->prepare($sql);
    foreach ($params as $key => $val) {
        $stmt->bindValue($key, $val);
    }
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

/** Obtiene un post por ID */
function getPostById(int $id): ?array {
    global $pdo;
    $stmt = $pdo->prepare("SELECT p.*, c.name AS category_name FROM posts p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch() ?: null;
}

/** Obtiene videos con filtros opcionales */
function getVideos(array $filters = [], int $limit = 10): array {
    global $pdo;
    $sql = "SELECT v.*, c.name AS category_name FROM videos v LEFT JOIN categories c ON v.category_id = c.id WHERE 1=1";
    $params = [];

    if (!empty($filters['section'])) {
        $sql .= " AND v.section = :section";
        $params[':section'] = $filters['section'];
    }
    if (!empty($filters['featured'])) {
        $sql .= " AND v.featured = 1";
    }

    $sql .= " ORDER BY v.created_at DESC LIMIT :limit";

    $stmt = $pdo->prepare($sql);
    foreach ($params as $key => $val) {
        $stmt->bindValue($key, $val);
    }
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

/** Obtiene un video por ID */
function getVideoById(int $id): ?array {
    global $pdo;
    $stmt = $pdo->prepare("SELECT v.*, c.name AS category_name FROM videos v LEFT JOIN categories c ON v.category_id = c.id WHERE v.id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch() ?: null;
}

/** Obtiene todas las categorías */
function getCategories(string $type = ''): array {
    global $pdo;
    if ($type) {
        $stmt = $pdo->prepare("SELECT * FROM categories WHERE type = :type ORDER BY name");
        $stmt->execute([':type' => $type]);
    } else {
        $stmt = $pdo->query("SELECT * FROM categories ORDER BY type, name");
    }
    return $stmt->fetchAll();
}

/** Obtiene una categoría por ID */
function getCategoryById(int $id): ?array {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch() ?: null;
}

/** Obtiene un setting por clave */
function getSetting(string $key): string {
    global $pdo;
    $stmt = $pdo->prepare("SELECT setting_value FROM settings WHERE setting_key = :key");
    $stmt->execute([':key' => $key]);
    $row = $stmt->fetch();
    return $row ? ($row['setting_value'] ?? '') : '';
}

/** Obtiene todos los settings como array asociativo */
function getAllSettings(): array {
    global $pdo;
    $stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
    $settings = [];
    while ($row = $stmt->fetch()) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
    return $settings;
}

/** Cuenta registros de una tabla con filtro opcional */
function countRecords(string $table, array $filters = []): int {
    global $pdo;
    $allowed = ['posts', 'videos', 'categories', 'users', 'contacts'];
    if (!in_array($table, $allowed)) return 0;

    $sql = "SELECT COUNT(*) FROM {$table} WHERE 1=1";
    $params = [];

    foreach ($filters as $col => $val) {
        $key = ':' . $col;
        $sql .= " AND {$col} = {$key}";
        $params[$key] = $val;
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return (int) $stmt->fetchColumn();
}

/** Incrementa las vistas de un post o video */
function incrementViews(string $table, int $id): void {
    global $pdo;
    $allowed = ['posts', 'videos'];
    if (!in_array($table, $allowed)) return;
    $pdo->prepare("UPDATE {$table} SET views = views + 1 WHERE id = :id")->execute([':id' => $id]);
}

/** Obtiene mensajes de contacto */
function getContacts(int $limit = 50): array {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM contacts ORDER BY created_at DESC LIMIT :limit");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

/** Formatea fecha en español */
function formatDate(string $date): string {
    $months = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
    $ts = strtotime($date);
    $day = date('d', $ts);
    $month = $months[(int)date('m', $ts) - 1];
    $year = date('Y', $ts);
    return "{$day} {$month} {$year}";
}

/** Trunca texto a un número de caracteres */
function truncateText(string $text, int $length = 150): string {
    if (mb_strlen($text) <= $length) return $text;
    return mb_substr($text, 0, $length) . '...';
}

/** Genera URL amigable */
function url(string $path = ''): string {
    return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
}

/** Muestra mensaje flash de sesión */
function flashMessage(): string {
    if (!empty($_SESSION['flash'])) {
        $type = $_SESSION['flash']['type'] ?? 'info';
        $msg = sanitize($_SESSION['flash']['message'] ?? '');
        unset($_SESSION['flash']);
        return "<div class='flash flash--{$type}'>{$msg}</div>";
    }
    return '';
}

/** Establece un mensaje flash */
function setFlash(string $message, string $type = 'success'): void {
    $_SESSION['flash'] = ['message' => $message, 'type' => $type];
}

/** Sube una imagen al servidor y devuelve la ruta relativa o false */
function uploadImage(array $file, string $subfolder = ''): string|false {
    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $maxSize = 5 * 1024 * 1024; // 5MB

    if ($file['error'] !== UPLOAD_ERR_OK || !in_array($file['type'], $allowed) || $file['size'] > $maxSize) {
        return false;
    }

    $uploadDir = __DIR__ . '/../uploads/' . ($subfolder ? trim($subfolder, '/') . '/' : '');
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid('img_') . '.' . strtolower($ext);
    $dest = $uploadDir . $filename;

    if (move_uploaded_file($file['tmp_name'], $dest)) {
        return 'uploads/' . ($subfolder ? trim($subfolder, '/') . '/' : '') . $filename;
    }
    return false;
}

/** Sube una imagen, la redimensiona y comprime para optimizar peso sin perder calidad visible */
function uploadAndOptimizeImage(array $file, string $subfolder = '', int $maxWidth = 1200, int $quality = 82): string|false {
    $allowed = ['image/jpeg', 'image/png', 'image/webp'];
    $maxSize = 10 * 1024 * 1024; // 10MB original permitido

    if ($file['error'] !== UPLOAD_ERR_OK || !in_array($file['type'], $allowed) || $file['size'] > $maxSize) {
        return false;
    }

    $uploadDir = __DIR__ . '/../uploads/' . ($subfolder ? trim($subfolder, '/') . '/' : '');
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Crear imagen desde el archivo original
    $srcImage = match ($file['type']) {
        'image/jpeg' => imagecreatefromjpeg($file['tmp_name']),
        'image/png'  => imagecreatefrompng($file['tmp_name']),
        'image/webp' => imagecreatefromwebp($file['tmp_name']),
        default      => false,
    };
    if (!$srcImage) return false;

    $origW = imagesx($srcImage);
    $origH = imagesy($srcImage);

    // Redimensionar solo si excede el ancho máximo
    if ($origW > $maxWidth) {
        $newW = $maxWidth;
        $newH = (int) round($origH * ($maxWidth / $origW));
        $resized = imagecreatetruecolor($newW, $newH);

        // Preservar transparencia en PNG/WebP
        if ($file['type'] !== 'image/jpeg') {
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
        }

        imagecopyresampled($resized, $srcImage, 0, 0, 0, 0, $newW, $newH, $origW, $origH);
        imagedestroy($srcImage);
        $srcImage = $resized;
    }

    // Guardar siempre como WebP para máxima compresión
    $filename = uniqid('img_') . '.webp';
    $dest = $uploadDir . $filename;

    $success = imagewebp($srcImage, $dest, $quality);
    imagedestroy($srcImage);

    if ($success) {
        return 'uploads/' . ($subfolder ? trim($subfolder, '/') . '/' : '') . $filename;
    }
    return false;
}

/** Guarda o actualiza un setting */
function saveSetting(string $key, string $value): void {
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM settings WHERE setting_key = :key");
    $stmt->execute([':key' => $key]);
    if ($stmt->fetchColumn() > 0) {
        $pdo->prepare("UPDATE settings SET setting_value = :val WHERE setting_key = :key")
            ->execute([':val' => $value, ':key' => $key]);
    } else {
        $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (:key, :val)")
            ->execute([':key' => $key, ':val' => $value]);
    }
}
