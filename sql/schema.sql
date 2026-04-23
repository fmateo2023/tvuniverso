-- =============================================
-- TV Universo - Schema de Base de Datos
-- Compatible con MySQL 5.7+ / MariaDB 10.3+
-- =============================================

CREATE DATABASE IF NOT EXISTS tvuniverso_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE tvuniverso_db;

-- -----------------------------------------------
-- Tabla: users
-- -----------------------------------------------
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'editor') NOT NULL DEFAULT 'editor',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- -----------------------------------------------
-- Tabla: categories
-- -----------------------------------------------
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    type ENUM('noticias', 'revista') NOT NULL DEFAULT 'noticias',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- -----------------------------------------------
-- Tabla: posts
-- -----------------------------------------------
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
) ENGINE=InnoDB;

-- -----------------------------------------------
-- Tabla: videos
-- -----------------------------------------------
CREATE TABLE IF NOT EXISTS videos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    url TEXT NOT NULL,
    thumbnail TEXT DEFAULT NULL,
    category_id INT DEFAULT NULL,
    section VARCHAR(50) DEFAULT 'canal48',
    featured TINYINT(1) DEFAULT 0,
    views INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- -----------------------------------------------
-- Tabla: settings (configuración general)
-- -----------------------------------------------
CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT DEFAULT NULL
) ENGINE=InnoDB;

-- -----------------------------------------------
-- Tabla: contacts (mensajes del formulario)
-- -----------------------------------------------
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(200) DEFAULT NULL,
    message TEXT NOT NULL,
    read_status TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =============================================
-- DATOS INICIALES (SEED)
-- =============================================

-- Admin por defecto (password: Admin123!)
-- Hash generado con password_hash('Admin123!', PASSWORD_BCRYPT)
INSERT INTO users (username, email, password, role) VALUES
('admin', 'admin@tvuniverso.com', '$2y$10$8KzQx3B5G5Z5Z5Z5Z5Z5ZeXJxQx3B5G5Z5Z5Z5Z5Z5ZeXJxQx3B', 'admin');

-- Categorías iniciales
INSERT INTO categories (name, type) VALUES
('Política', 'noticias'),
('Deportes', 'noticias'),
('Entretenimiento', 'noticias'),
('Tecnología', 'noticias'),
('Nacional', 'noticias'),
('Internacional', 'noticias'),
('Destinos', 'revista'),
('Experiencias', 'revista'),
('Hoteles', 'revista'),
('Gastronomía', 'revista');

-- Posts de ejemplo
INSERT INTO posts (title, content, excerpt, image_url, category_id, type, section, featured) VALUES
('Últimas noticias del día en Canal 48', 'Contenido completo de la noticia principal del día con todos los detalles relevantes para nuestra audiencia.', 'Las noticias más importantes del día en un solo lugar.', 'https://images.unsplash.com/photo-1504711434969-e33886168d6c?w=800', 1, 'canal48', 'home', 1),
('Deportes: Resumen de la jornada', 'Todos los resultados y análisis de la jornada deportiva más reciente.', 'Resumen completo de la jornada deportiva.', 'https://images.unsplash.com/photo-1461896836934-bd45ba8fcf9b?w=800', 2, 'canal48', 'home', 1),
('Tecnología: Lo nuevo en IA', 'Los avances más recientes en inteligencia artificial y cómo impactan nuestra vida diaria.', 'La IA sigue transformando el mundo.', 'https://images.unsplash.com/photo-1677442136019-21780ecad995?w=800', 4, 'canal48', 'tendencia', 1),
('Entretenimiento: Estrenos de la semana', 'Los mejores estrenos de cine y televisión que no te puedes perder esta semana.', 'No te pierdas los estrenos más esperados.', 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?w=800', 3, 'canal48', 'tendencia', 0),
('Cancún: El paraíso del Caribe mexicano', 'Descubre las mejores playas, hoteles y experiencias que Cancún tiene para ofrecer a los viajeros más exigentes.', 'Cancún te espera con sus aguas turquesa.', 'https://images.unsplash.com/photo-1510097467424-192d713fd8b2?w=800', 7, 'toptravel', 'home', 1),
('Los mejores hoteles boutique de 2024', 'Una selección curada de los hoteles boutique más exclusivos y con mejor servicio del año.', 'Hoteles que redefinen el lujo.', 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800', 9, 'toptravel', 'home', 1),
('Experiencias gastronómicas en Oaxaca', 'Un recorrido por los sabores más auténticos de la cocina oaxaqueña.', 'Oaxaca: destino gastronómico por excelencia.', 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=800', 10, 'toptravel', 'home', 0),
('Noticias internacionales: Cumbre mundial', 'Cobertura completa de la cumbre mundial de líderes internacionales.', 'Líderes mundiales se reúnen para discutir el futuro.', 'https://images.unsplash.com/photo-1529107386315-e1a2ed48a620?w=800', 6, 'canal48', 'top', 1),
('Viral: El video que rompe internet', 'El contenido viral de la semana que todos están compartiendo en redes sociales.', 'Este video está rompiendo todos los récords.', 'https://images.unsplash.com/photo-1611162617474-5b21e879e113?w=800', 3, 'canal48', 'top', 1),
('Destinos secretos en Europa', 'Los rincones menos conocidos de Europa que todo viajero debería descubrir.', 'Europa tiene secretos por descubrir.', 'https://images.unsplash.com/photo-1467269204594-9661b134dd2b?w=800', 7, 'toptravel', 'home', 0);

-- Videos de ejemplo
INSERT INTO videos (title, url, thumbnail, category_id, section, featured) VALUES
('Noticiero Canal 48 - Edición Estelar', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'https://images.unsplash.com/photo-1495020689067-958852a7765e?w=400', 1, 'canal48', 1),
('Deportes en vivo - Resumen', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'https://images.unsplash.com/photo-1461896836934-bd45ba8fcf9b?w=400', 2, 'canal48', 1),
('Top 10 destinos 2024', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=400', 7, 'top', 1),
('Video viral de la semana', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'https://images.unsplash.com/photo-1611162617474-5b21e879e113?w=400', 3, 'top', 1),
('Especial: Playas del mundo', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=400', 7, 'canal48', 0);

-- Configuración inicial
INSERT INTO settings (setting_key, setting_value) VALUES
('site_name', 'TV Universo'),
('site_logo', ''),
('facebook', 'https://facebook.com/tvuniverso'),
('instagram', 'https://instagram.com/tvuniverso'),
('twitter', 'https://twitter.com/tvuniverso'),
('youtube', 'https://youtube.com/tvuniverso'),
('contact_email', 'contacto@tvuniverso.com'),
('contact_phone', '+52 999 123 4567'),
('contact_address', 'Mérida, Yucatán, México'),
('hero_title', 'TV Universo'),
('hero_subtitle', 'Tu ventana al mundo'),
('hero_image', 'https://images.unsplash.com/photo-1478720568477-152d9b164e26?w=1200');
