# 📺 TV Universo - Plataforma de Medios

Plataforma web profesional para **Canal 48** (noticias/TV) y **Top Travel** (revista digital).

## 🛠️ Stack Tecnológico

- **Backend:** PHP 8+ nativo con PDO
- **Base de datos:** MySQL 5.7+ / MariaDB 10.3+
- **Frontend:** HTML5, CSS3, JavaScript Vanilla
- **Servidor:** Apache (compatible con cPanel)

---

## 🚀 Instalación Local (XAMPP/WAMP/Laragon)

### 1. Clonar o copiar el proyecto
Copia la carpeta `public_html` dentro de tu directorio web:
- **XAMPP:** `C:\xampp\htdocs\tvuniverso\`
- **WAMP:** `C:\wamp64\www\tvuniverso\`
- **Laragon:** `C:\laragon\www\tvuniverso\`

### 2. Configurar la base de datos
Edita `config.php` con tus credenciales:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'tvuniverso_db');
define('BASE_URL', 'http://localhost/tvuniverso');
```

### 3. Ejecutar el instalador
Abre en tu navegador:
```
http://localhost/tvuniverso/install.php
```
Esto creará las tablas, datos de ejemplo y el usuario admin.

### 4. Acceder
- **Sitio:** `http://localhost/tvuniverso/`
- **Admin:** `http://localhost/tvuniverso/admin/login.php`
- **Credenciales:** `admin` / `Admin123!`

### 5. ⚠️ Eliminar install.php
Por seguridad, elimina el archivo `install.php` después de la instalación.

---

## 🌐 Despliegue en cPanel (Hosting Compartido)

### 1. Subir archivos
- Accede a **cPanel → Administrador de archivos**
- Sube todo el contenido de `public_html/` a tu directorio `public_html/` del hosting
- O usa **FTP** (FileZilla) para subir los archivos

### 2. Crear base de datos en cPanel
1. Ve a **cPanel → Bases de datos MySQL**
2. Crea una nueva base de datos: `tvuniverso_db`
3. Crea un usuario de base de datos
4. Asigna el usuario a la base de datos con **TODOS los privilegios**

### 3. Configurar config.php
Edita `config.php` con los datos de cPanel:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'tucuenta_usuario');  // usuario de cPanel
define('DB_PASS', 'tu_password_seguro');
define('DB_NAME', 'tucuenta_tvuniverso_db');
define('BASE_URL', 'https://tudominio.com');
```

### 4. Ejecutar instalador
Visita: `https://tudominio.com/install.php`

### 5. Eliminar install.php
**¡OBLIGATORIO!** Elimina `install.php` del servidor.

---

## 📁 Estructura del Proyecto

```
public_html/
├── index.php              # Router principal
├── config.php             # Configuración y conexión BD
├── install.php            # Instalador (eliminar después)
├── .htaccess              # Seguridad y configuración Apache
├── assets/
│   ├── css/
│   │   ├── styles.css     # Estilos del sitio público
│   │   └── admin.css      # Estilos del panel admin
│   ├── js/
│   │   ├── main.js        # JavaScript público
│   │   └── admin.js       # JavaScript admin
│   └── images/
├── includes/
│   ├── functions.php      # Funciones auxiliares
│   ├── auth.php           # Sistema de autenticación
│   ├── navbar.php         # Componente navbar
│   └── footer.php         # Componente footer
├── pages/
│   ├── home.php           # Página principal
│   ├── canal48.php        # Canal 48
│   ├── top.php            # Lo Más Top
│   ├── toptravel.php      # Revista Digital
│   ├── nosotros.php       # Nosotros
│   ├── contacto.php       # Contacto
│   ├── post.php           # Detalle de noticia
│   └── video.php          # Detalle de video
├── admin/
│   ├── login.php          # Login admin
│   ├── logout.php         # Logout
│   ├── layout.php         # Layout compartido (sidebar)
│   ├── layout_footer.php  # Cierre del layout
│   ├── index.php          # Dashboard
│   ├── posts.php          # CRUD Noticias
│   ├── videos.php         # CRUD Videos
│   ├── categories.php     # CRUD Categorías
│   ├── users.php          # Gestión de usuarios
│   ├── settings.php       # Configuración general
│   ├── contacts.php       # Mensajes de contacto
│   ├── home.php           # Config del Home
│   ├── canal48.php        # Config Canal 48
│   ├── toptravel.php      # Config Top Travel
│   └── top.php            # Config Lo Más Top
├── uploads/               # Directorio para uploads
└── sql/
    └── schema.sql         # Schema SQL de referencia
```

---

## 🔐 Seguridad Implementada

- ✅ Contraseñas hasheadas con `password_hash()` (bcrypt, cost 12)
- ✅ Consultas preparadas con PDO (prevención SQL injection)
- ✅ Sanitización de inputs con `htmlspecialchars()` (prevención XSS)
- ✅ Tokens CSRF en todos los formularios
- ✅ Sesiones seguras (httponly, strict mode, regeneración de ID)
- ✅ Expiración de sesión configurable
- ✅ Protección de archivos sensibles vía `.htaccess`
- ✅ Headers de seguridad (X-Content-Type-Options, X-Frame-Options, X-XSS-Protection)
- ✅ Restricción de acceso a `/admin` por autenticación
- ✅ Protección contra eliminación del propio usuario admin

---

## 🎨 Sistema de Diseño

| Elemento | Color |
|----------|-------|
| Fondo principal | `#0A0A0A` |
| Secciones | `#1C1C1C` |
| Bloques | `#2A2A2A` |
| Azul (Canal 48) | `#2F6BFF` |
| Rosa | `#FF2D8D` |
| Amarillo | `#FFC300` |
| Verde | `#2ECC71` |
| Morado (Top Travel) | `#8E44AD` |
| Dorado | `#C8A27A` |
| Texto principal | `#FFFFFF` |
| Texto secundario | `#B3B3B3` |

**Tipografía:** Montserrat (headings) + Open Sans (body)

---

## 📋 Panel Admin - Módulos

| Módulo | Ruta | Función |
|--------|------|---------|
| Dashboard | `/admin/` | Resumen general |
| Noticias | `/admin/posts.php` | CRUD completo |
| Videos | `/admin/videos.php` | CRUD completo |
| Categorías | `/admin/categories.php` | CRUD completo |
| Home | `/admin/home.php` | Config página principal |
| Canal 48 | `/admin/canal48.php` | Contenido del canal |
| Top Travel | `/admin/toptravel.php` | Artículos de revista |
| Lo Más Top | `/admin/top.php` | Contenido trending |
| Usuarios | `/admin/users.php` | Gestión de usuarios |
| Configuración | `/admin/settings.php` | Datos generales |
| Mensajes | `/admin/contacts.php` | Formulario de contacto |

Cada módulo muestra etiquetas visuales indicando dónde se muestra el contenido:
- 🟢 Visible en HOME
- 🔵 Visible en Canal 48
- 🟣 Visible en Top Travel
- 🔴 Visible en Lo Más Top
