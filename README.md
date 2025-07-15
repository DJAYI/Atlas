<p align="center">
<a href="[https://laravel.com](https://laravel.com)" target="_blank">
<img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</a>
</p>

<div align="center">

# Proyecto Hermes (Wonderlust)

### **Fundación Universitaria Tecnológico Comfenalco**

</div>

<p align="center">
<img alt="PHP" src="https://img.shields.io/badge/PHP-8.1%2B-777BB4?style=for-the-badge&logo=php">
<img alt="Laravel" src="https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel">
<img alt="MySQL" src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql">
<img alt="License" src="https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge">
</p>

---

## 🚀 Descripción

**Hermes (Wonderlust)** es una plataforma para la gestión de Internacionalización de Eventos, diseñada para que los usuarios de la **Fundación Universitaria Tecnológico Comfenalco** puedan administrar eventos, convenios y actividades académicas internacionales.

La aplicación está construida con **Laravel 10** y sigue una arquitectura moderna para facilitar su desarrollo y mantenimiento.

---

## ✨ Características Principales

### 🌍 Gestión de Internacionalización

-   **Eventos Internacionales**: Creación, gestión y seguimiento de eventos académicos.
-   **Control de Asistencia**: Sistema automatizado para registrar participantes en tiempo real.
-   **Reportes para SNIES**: Generación automática de reportes de participación.

### 🤝 Gestión de Convenios

-   **Acuerdos Multinstitucionales**: Administración de convenios y alianzas académicas.
-   **Actividades Académicas**: Seguimiento de intercambios y colaboraciones.
-   **Reportes**: Estadísticas y análisis de actividades internacionales.

### 👥 Sistema de Usuarios

-   **Roles y Permisos**: Sistema granular de autorización basado en roles.
-   **Autenticación Segura**: Login con verificación de dos factores (2FA).
-   **Gestión de Perfiles**: Administración centralizada de datos de usuarios.

### 📊 Dashboard Interactivo

-   **Componentes Livewire**: Gráficos y métricas que se actualizan en tiempo real.
-   **Mapas Interactivos**: Visualización geográfica de actividades y convenios.
    -\_ **Estadísticas**: Métricas y KPIs clave del sistema.

### 📧 Sistema de Comunicación

-   **Encuestas por Email**: Envío automatizado de encuestas de satisfacción.
-   **Notificaciones**: Alertas y recordatorios automáticos para eventos y tareas.
-   **Plantillas de Correo**: Templates personalizables para una comunicación consistente.

---

## 🛠️ Tecnologías Utilizadas

<table>
<thead>
<tr>
<th width="120px">Tecnología</th>
<th>Descripción</th>
</tr>
</thead>
<tbody>
<tr>
<td>
<img src="https://laravel.com/img/logomark.min.svg" alt="Laravel" width="80">
</td>
<td>
<b>Laravel Framework</b>
<p>Framework de PHP con una sintaxis elegante y herramientas poderosas para el desarrollo rápido y seguro de aplicaciones web.</p>
</td>
</tr>
<tr>
<td>
<img src="https://getcomposer.org/img/logo-composer-transparent5.png" alt="Composer" width="100">
</td>
<td>
<b>Composer</b>
<p>Gestor de dependencias para PHP, utilizado para administrar las bibliotecas y paquetes del proyecto.</p>
</td>
</tr>
<tr>
<td>
<img src="https://www.mysql.com/common/logos/logo-mysql-170x115.png" alt="MySQL" width="100">
</td>
<td>
<b>MySQL</b>
<p>Sistema de gestión de bases de datos relacional para almacenar y gestionar los datos. También soporta SQLite para desarrollo local.</p>
</td>
</tr>
<tr>
<td>
<img src="https://nodejs.org/static/images/logo.svg" alt="Node.js" width="100">
</td>
<td>
<b>Node.js & Vite</b>
<p>Entorno de ejecución para JavaScript del lado del servidor. Se utiliza para gestionar las dependencias del frontend y compilar assets con Vite.</p>
</td>
</tr>
<tr>
<td>
<img src="https://upload.wikimedia.org/wikipedia/commons/9/95/Tailwind_CSS_logo.svg" alt="Tailwind CSS" width="100">
</td>
<td>
<b>Tailwind CSS</b>
<p>Framework de CSS <i>utility-first</i> para crear interfaces de usuario modernas y responsivas de manera eficiente.</p>
</td>
</tr>
<tr>
<td>
<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b2/Cloudflare_Turnstile_logo.svg/1200px-Cloudflare_Turnstile_logo.svg.png" width="100">
</td>
<td>
<b>Cloudflare Turnstile</b>
<p>Alternativa a los CAPTCHAs tradicionales que distingue entre humanos y bots sin fricción para el usuario, mejorando la seguridad y la experiencia.</p>
</td>
</tr>
<tr>
<td>
<img src="https://choices-js.github.io/Choices/assets/images/logo.svg" alt="Choices.js" width="80">
</td>
<td>
<b>Choices.js</b>
<p>Biblioteca de JavaScript para crear selectores y campos de entrada personalizables y amigables con el usuario.</p>
</td>
</tr>
</tbody>
</table>

---

## 📋 Requisitos Previos

Asegúrate de tener instalados los siguientes requisitos en tu entorno de desarrollo:

-   [PHP](https://www.php.net/downloads) (versión `>=8.1`)
-   [Composer](https://getcomposer.org/download/)
-   [MySQL](https://www.mysql.com/downloads/) o [PostgreSQL](https://www.postgresql.org/download/)
-   [Node.js](https://nodejs.org/) (versión `>=18.0`) y NPM
-   [Credenciales de Cloudflare Turnstile](https://developers.cloudflare.com/turnstile/get-started/)

---

## 🚀 Instalación y Configuración

Sigue estos pasos para configurar el proyecto en tu máquina local.

**1. Clona el repositorio:**

```bash
git clone https://github.com/DJAYI/Atlas
cd Atlas
```

**2. Instala las dependencias de PHP:**

```bash
composer install
```

**3. Configura tu archivo de entorno:**

```bash
cp .env.example .env
```

Abre el archivo `.env` y configura tus variables, especialmente la base de datos, el correo y las claves de Turnstile.

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hermes_db
DB_USERNAME=root
DB_PASSWORD=

# Claves de Cloudflare Turnstile
TURNSTILE_SITE_KEY=tu_site_key
TURNSTILE_SECRET_KEY=tu_secret_key

# Configuración de correo (ej. Mailtrap o SMTP real)
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=tu_usuario_mailtrap
MAIL_PASSWORD=tu_contraseña_mailtrap
MAIL_FROM_ADDRESS="no-reply@tecnologicocomfenalco.edu.co"
MAIL_FROM_NAME="${APP_NAME}"
```

**4. Genera la clave de la aplicación:**

```bash
php artisan key:generate
```

**5. Ejecuta las migraciones y los seeders:**
Esto creará la estructura de la base de datos y la llenará con datos de prueba.

```bash
php artisan migrate --seed
```

**6. Instala las dependencias de Node.js y compila los assets:**

```bash
npm install && npm run build
```

**7. Inicia el servidor de desarrollo:**

```bash
php artisan serve
```

¡Listo! La aplicación estará disponible en `http://127.0.0.1:8000`.

---

### Configuración Adicional: Certificado SSL (`cacert.pem`)

> Necesario para entornos locales en Windows, configurar el archivo php.ini para realizar peticiones externas.

Para evitar errores de SSL/TLS al conectar con APIs externas (especialmente en Windows), configura el certificado raíz de `curl`.

1.  **Descarga `cacert.pem`** en la carpeta `storage`:
    ```bash
    curl https://curl.se/ca/cacert.pem -o storage/cacert.pem
    ```
2.  **Edita tu `php.ini`** y añade las siguientes líneas (asegúrate de usar la ruta absoluta correcta):

    ```ini
    [curl]
    curl.cainfo = "C:/ruta/completa/a/Atlas/storage/cacert.pem"

    [openssl]
    openssl.cafile = "C:/ruta/completa/a/Atlas/storage/cacert.pem"
    ```

---

## 🧪 Testing

El proyecto utiliza Pest para las pruebas automatizadas.

```bash
# Ejecutar todos los tests
php artisan test

# Ejecutar tests con cobertura de código
php artisan test --coverage
```

---

## ⚙️ Comandos Útiles

### Desarrollo

```bash
# Compilar assets en modo desarrollo con hot-reloading
npm run dev

# Limpiar toda la caché de Laravel
php artisan optimize:clear
```

### Generadores de Código

```bash
# Crear un nuevo componente Livewire
php artisan make:livewire ComponentName

# Crear un nuevo modelo con su migración
php artisan make:model ModelName -m

# Crear una nueva clase de correo electrónico
php artisan make:mail MailName
```

---

## 🔧 Solución de Problemas Comunes

-   **Error de permisos en `storage` o `bootstrap/cache`:**

    ```bash
    chmod -R 775 storage bootstrap/cache
    ```

-   **Error `cURL error 60: SSL certificate problem`:**
    Asegúrate de haber configurado correctamente el `cacert.pem` como se indica en la sección de instalación.

-   **Problemas con dependencias (PHP o JS):**

    ```bash
    # Para PHP
    composer dump-autoload

    # Para JS
    rm -rf node_modules package-lock.json
    npm install
    npm run build
    ```

---

## 🌐 Configuración para Producción (Despliegue)

### Apache

1.  Asegúrate de que `mod_rewrite` esté habilitado.

2.  Configura el _Virtual Host_ para que apunte a la carpeta `public`.

3.  Utiliza el siguiente `.htaccess` en la carpeta `public/` (ajusta `RewriteBase` si el proyecto está en un subdirectorio).

    ```apache
    <IfModule mod_rewrite.c>
        RewriteEngine On
        # Si la app está en una subcarpeta (ej. /hermes), descomenta la siguiente línea
        # RewriteBase /hermes/public/
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule ^ index.php [L]
    </IfModule>
    ```

### Nginx

Usa la siguiente configuración de servidor, apuntando la raíz a la carpeta `public/`.

```nginx
server {
    listen 80;
    server_name tu-dominio.com;
    root /var/www/hermes/public; # Ruta a tu proyecto

    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ .php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock; # Ajusta la versión de PHP
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /.ht {
        deny all;
    }
}
```

### Optimización para Producción

Antes de desplegar, ejecuta estos comandos para optimizar el rendimiento:

```bash
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🔄 Configuración de Workers (Systemd)

Para procesar tareas en segundo plano (como el envío de correos) en un servidor Linux, puedes usar `systemd`.

1.  **Crea el archivo de servicio** en `/etc/systemd/system/hermes-worker.service`:

    ```ini
    [Unit]
    Description=Hermes Queue Worker
    After=network.target

    [Service]
    User=apache          # Usuario que ejecuta el servidor web (www-data en Debian/Ubuntu)
    Group=apache         # Grupo del usuario (www-data en Debian/Ubuntu)
    Restart=always
    ExecStart=/usr/bin/php /var/www/hermes/artisan queue:work --sleep=3 --tries=3
    WorkingDirectory=/var/www/hermes

    [Install]
    WantedBy=multi-user.target
    ```

2.  **Activa e inicia el servicio:**

    ```bash
    # Recargar systemd
    sudo systemctl daemon-reload

    # Habilitar el worker para que inicie con el sistema
    sudo systemctl enable hermes-worker.service

    # Iniciar el worker ahora
    sudo systemctl start hermes-worker.service

    # Verificar el estado
    sudo systemctl status hermes-worker.service
    ```

---

## 📁 Estructura del Proyecto

El proyecto sigue la estructura estándar de Laravel, con algunas adiciones clave para organizar la lógica de negocio.

```
hermes/
├── app/
│   ├── Console/
│   ├── Enums/            # Enumeraciones para tipos de datos (Modalidad, Ubicación, etc.)
│   ├── Exports/          # Clases para exportación de datos (Excel, CSV)
│   ├── Http/
│   ├── Jobs/             # Tareas en cola (ej. SendSurveyEmailJob)
│   ├── Livewire/         # Componentes interactivos de Livewire
│   ├── Mail/             # Clases de correo electrónico
│   ├── Models/           # Modelos Eloquent con sus relaciones
│   └── Services/         # Lógica de negocio desacoplada
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── css/
│   ├── js/
│   ├── lang/             # Archivos de traducción (es, en)
│   └── views/            # Vistas Blade y componentes
├── routes/
│   ├── auth.php
│   └── web.php
└── ...
```
