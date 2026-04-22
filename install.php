<?php
/**
 * TV Universo - Script de Instalación
 * Ejecutar UNA VEZ para crear las tablas y el usuario admin
 * ⚠️ ELIMINAR ESTE ARCHIVO DESPUÉS DE LA INSTALACIÓN
 */

// Configuración de conexión (sin base de datos aún)
$host = 'localhost';
$user = 'migue414_admin';       // Cambiar en cPanel
$pass = 'Admin#root2026';            // Cambiar en cPanel
$dbname = 'migue414_tvuniverso_db';

echo "<h1>📺 TV Universo - Instalación</h1>";
echo "<pre>";

try {
    // Conectar sin base de datos
    $pdo = new PDO("mysql:host={$host};charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    // Crear base de datos
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbname}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "✅ Base de datos '{$dbname}' creada.\n";

    $pdo->exec("USE `{$dbname}`");

    // Crear tablas
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            role ENUM('admin', 'editor') NOT NULL DEFAULT 'editor',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB
    ");
    echo "✅ Tabla 'users' creada.\n";

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS categories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            type ENUM('noticias', 'revista') NOT NULL DEFAULT 'noticias',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB
    ");
    echo "✅ Tabla 'categories' creada.\n";

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS posts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            content TEXT NOT NULL,
            excerpt VARCHAR(500) DEFAULT NULL,
            image_url VARCHAR(500) DEFAULT NULL,
            category_id INT DEFAULT NULL,
            type ENUM('canal48', 'toptravel') NOT NULL DEFAULT 'canal48',
            section VARCHAR(50) DEFAULT 'home',
            featured TINYINT(1) DEFAULT 0,
            views INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
        ) ENGINE=InnoDB
    ");
    echo "✅ Tabla 'posts' creada.\n";

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS videos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            url VARCHAR(500) NOT NULL,
            thumbnail VARCHAR(500) DEFAULT NULL,
            category_id INT DEFAULT NULL,
            section VARCHAR(50) DEFAULT 'canal48',
            featured TINYINT(1) DEFAULT 0,
            views INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
        ) ENGINE=InnoDB
    ");
    echo "✅ Tabla 'videos' creada.\n";

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS settings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            setting_key VARCHAR(100) NOT NULL UNIQUE,
            setting_value TEXT DEFAULT NULL
        ) ENGINE=InnoDB
    ");
    echo "✅ Tabla 'settings' creada.\n";

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS contacts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            subject VARCHAR(200) DEFAULT NULL,
            message TEXT NOT NULL,
            read_status TINYINT(1) DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB
    ");
    echo "✅ Tabla 'contacts' creada.\n";

    // --- Usuario admin ---
    $adminPassword = password_hash('Admin123!', PASSWORD_BCRYPT, ['cost' => 12]);
    $stmt = $pdo->prepare("INSERT IGNORE INTO users (username, email, password, role) VALUES (:u, :e, :p, 'admin')");
    $stmt->execute([':u' => 'admin', ':e' => 'admin@tvuniverso.com', ':p' => $adminPassword]);
    echo "✅ Usuario admin creado (user: admin / pass: Admin123!)\n";

    // --- Categorías ---
    $cats = [
        ['Política', 'noticias'], ['Deportes', 'noticias'], ['Entretenimiento', 'noticias'],
        ['Tecnología', 'noticias'], ['Nacional', 'noticias'], ['Internacional', 'noticias'],
        ['Destinos', 'revista'], ['Experiencias', 'revista'], ['Hoteles', 'revista'], ['Gastronomía', 'revista'],
    ];
    $stmt = $pdo->prepare("INSERT IGNORE INTO categories (name, type) VALUES (:name, :type)");
    foreach ($cats as $c) {
        $stmt->execute([':name' => $c[0], ':type' => $c[1]]);
    }
    echo "✅ Categorías iniciales creadas.\n";

    // --- Posts de ejemplo ---
    $posts = [
        ['Últimas noticias del día en Canal 48', 'Contenido completo de la noticia principal del día con todos los detalles relevantes para nuestra audiencia.', 'Las noticias más importantes del día.', 'https://images.unsplash.com/photo-1504711434969-e33886168d6c?w=800', 1, 'canal48', 'home', 1],
        ['Deportes: Resumen de la jornada', 'Todos los resultados y análisis de la jornada deportiva más reciente.', 'Resumen completo de la jornada deportiva.', 'https://images.unsplash.com/photo-1461896836934-bd45ba8fcf9b?w=800', 2, 'canal48', 'home', 1],
        ['Tecnología: Lo nuevo en IA', 'Los avances más recientes en inteligencia artificial y cómo impactan nuestra vida diaria.', 'La IA sigue transformando el mundo.', 'https://images.unsplash.com/photo-1677442136019-21780ecad995?w=800', 4, 'canal48', 'tendencia', 1],
        ['Entretenimiento: Estrenos de la semana', 'Los mejores estrenos de cine y televisión que no te puedes perder esta semana.', 'No te pierdas los estrenos más esperados.', 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?w=800', 3, 'canal48', 'tendencia', 0],
        ['Cancún: El paraíso del Caribe mexicano', 'Descubre las mejores playas, hoteles y experiencias que Cancún tiene para ofrecer.', 'Cancún te espera con sus aguas turquesa.', 'https://images.unsplash.com/photo-1510097467424-192d713fd8b2?w=800', 7, 'toptravel', 'home', 1],
        ['Los mejores hoteles boutique de 2024', 'Una selección curada de los hoteles boutique más exclusivos del año.', 'Hoteles que redefinen el lujo.', 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800', 9, 'toptravel', 'home', 1],
        ['Experiencias gastronómicas en Oaxaca', 'Un recorrido por los sabores más auténticos de la cocina oaxaqueña.', 'Oaxaca: destino gastronómico por excelencia.', 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=800', 10, 'toptravel', 'home', 0],
        ['Noticias internacionales: Cumbre mundial', 'Cobertura completa de la cumbre mundial de líderes internacionales.', 'Líderes mundiales se reúnen.', 'https://images.unsplash.com/photo-1529107386315-e1a2ed48a620?w=800', 6, 'canal48', 'top', 1],
        ['Viral: El video que rompe internet', 'El contenido viral de la semana que todos están compartiendo.', 'Este video está rompiendo todos los récords.', 'https://images.unsplash.com/photo-1611162617474-5b21e879e113?w=800', 3, 'canal48', 'top', 1],
        ['Destinos secretos en Europa', 'Los rincones menos conocidos de Europa que todo viajero debería descubrir.', 'Europa tiene secretos por descubrir.', 'https://images.unsplash.com/photo-1467269204594-9661b134dd2b?w=800', 7, 'toptravel', 'home', 0],
    ];
    $stmt = $pdo->prepare("INSERT INTO posts (title, content, excerpt, image_url, category_id, type, section, featured) VALUES (:t, :c, :e, :i, :cat, :type, :sec, :f)");
    foreach ($posts as $p) {
        $stmt->execute([':t' => $p[0], ':c' => $p[1], ':e' => $p[2], ':i' => $p[3], ':cat' => $p[4], ':type' => $p[5], ':sec' => $p[6], ':f' => $p[7]]);
    }
    echo "✅ Posts de ejemplo creados.\n";

    // --- Videos de ejemplo ---
    $videos = [
        ['Noticiero Canal 48 - Edición Estelar', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'https://images.unsplash.com/photo-1495020689067-958852a7765e?w=400', 1, 'canal48', 1],
        ['Deportes en vivo - Resumen', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'https://images.unsplash.com/photo-1461896836934-bd45ba8fcf9b?w=400', 2, 'canal48', 1],
        ['Top 10 destinos 2024', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=400', 7, 'top', 1],
        ['Video viral de la semana', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'https://images.unsplash.com/photo-1611162617474-5b21e879e113?w=400', 3, 'top', 1],
        ['Especial: Playas del mundo', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=400', 7, 'canal48', 0],
    ];
    $stmt = $pdo->prepare("INSERT INTO videos (title, url, thumbnail, category_id, section, featured) VALUES (:t, :u, :th, :cat, :sec, :f)");
    foreach ($videos as $v) {
        $stmt->execute([':t' => $v[0], ':u' => $v[1], ':th' => $v[2], ':cat' => $v[3], ':sec' => $v[4], ':f' => $v[5]]);
    }
    echo "✅ Videos de ejemplo creados.\n";

    // --- Settings ---
    $settings = [
        ['site_name', 'TV Universo'], ['site_logo', ''],
        ['facebook', 'https://facebook.com/tvuniverso'], ['instagram', 'https://instagram.com/tvuniverso'],
        ['twitter', 'https://twitter.com/tvuniverso'], ['youtube', 'https://youtube.com/tvuniverso'],
        ['contact_email', 'contacto@tvuniverso.com'], ['contact_phone', '+52 999 123 4567'],
        ['contact_address', 'Mérida, Yucatán, México'],
        ['hero_title', 'TV Universo'], ['hero_subtitle', 'Tu ventana al mundo'],
        ['hero_image', 'https://images.unsplash.com/photo-1478720568477-152d9b164e26?w=1200'],
    ];
    $stmt = $pdo->prepare("INSERT IGNORE INTO settings (setting_key, setting_value) VALUES (:k, :v)");
    foreach ($settings as $s) {
        $stmt->execute([':k' => $s[0], ':v' => $s[1]]);
    }
    echo "✅ Configuración inicial creada.\n";

    echo "\n========================================\n";
    echo "🎉 ¡INSTALACIÓN COMPLETADA!\n";
    echo "========================================\n\n";
    echo "🔐 Credenciales de admin:\n";
    echo "   Usuario: admin\n";
    echo "   Contraseña: Admin123!\n\n";
    echo "⚠️  IMPORTANTE: Elimina este archivo (install.php) por seguridad.\n";
    echo "🌐 Accede al sitio: index.php\n";
    echo "🔧 Panel admin: admin/login.php\n";

} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "</pre>";
