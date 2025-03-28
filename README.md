<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">

<h3>Estructura del Proyecto</h3>
<code type=text/plain>
Directory structure:
└── djayi-atlas/
    ├── README.md
    ├── artisan
    ├── composer.json
    ├── composer.lock
    ├── package.json
    ├── phpunit.xml
    ├── postcss.config.js
    ├── tailwind.config.js
    ├── vite.config.js
    ├── .editorconfig
    ├── .env.example
    ├── app/
    │   ├── Casts/
    │   │   ├── HasAgreement.php
    │   │   ├── InternalizationAtHome.php
    │   │   ├── Location.php
    │   │   └── Modality.php
    │   ├── Enums/
    │   │   ├── AgreementActivityEnum.php
    │   │   ├── AgreementTypeEnum.php
    │   │   ├── HasAgreementEnum.php
    │   │   ├── InternationalizationAtHomeEnum.php
    │   │   ├── LocationEnum.php
    │   │   └── ModalityEnum.php
    │   ├── Http/
    │   │   ├── Controllers/
    │   │   │   ├── ActivityController.php
    │   │   │   ├── AgreementController.php
    │   │   │   ├── AssistanceController.php
    │   │   │   ├── CareerController.php
    │   │   │   ├── CertificateController.php
    │   │   │   ├── CityController.php
    │   │   │   ├── Controller.php
    │   │   │   ├── CountryController.php
    │   │   │   ├── EventController.php
    │   │   │   ├── FacultyController.php
    │   │   │   ├── FinancialEntityController.php
    │   │   │   ├── MovilityController.php
    │   │   │   ├── PersonController.php
    │   │   │   ├── ProfileController.php
    │   │   │   ├── StateController.php
    │   │   │   ├── UniversityController.php
    │   │   │   └── Auth/
    │   │   │       ├── AuthenticatedSessionController.php
    │   │   │       ├── ConfirmablePasswordController.php
    │   │   │       ├── EmailVerificationNotificationController.php
    │   │   │       ├── EmailVerificationPromptController.php
    │   │   │       ├── NewPasswordController.php
    │   │   │       ├── PasswordController.php
    │   │   │       ├── PasswordResetLinkController.php
    │   │   │       ├── RegisteredUserController.php
    │   │   │       └── VerifyEmailController.php
    │   │   └── Requests/
    │   │       ├── ProfileUpdateRequest.php
    │   │       └── Auth/
    │   │           └── LoginRequest.php
    │   ├── Jobs/
    │   │   └── SendCertificateEmailJob.php
    │   ├── Models/
    │   │   ├── Activity.php
    │   │   ├── Agreement.php
    │   │   ├── Assistance.php
    │   │   ├── Career.php
    │   │   ├── City.php
    │   │   ├── Country.php
    │   │   ├── Event.php
    │   │   ├── Faculty.php
    │   │   ├── FinancialEntity.php
    │   │   ├── Movility.php
    │   │   ├── Person.php
    │   │   ├── State.php
    │   │   ├── University.php
    │   │   └── User.php
    │   ├── Providers/
    │   │   ├── AppServiceProvider.php
    │   │   ├── CareerManagementServiceProvider.php
    │   │   ├── EventManagementServiceProvider.php
    │   │   └── UniversityManagementServiceProvider.php
    │   └── View/
    │       └── Components/
    │           ├── AppLayout.php
    │           └── GuestLayout.php
    ├── bootstrap/
    │   ├── app.php
    │   ├── providers.php
    │   └── cache/
    │       └── .gitignore
    ├── config/
    │   ├── app.php
    │   ├── auth.php
    │   ├── cache.php
    │   ├── database.php
    │   ├── filesystems.php
    │   ├── logging.php
    │   ├── mail.php
    │   ├── permission.php
    │   ├── queue.php
    │   ├── services.php
    │   └── session.php
    ├── database/
    │   ├── .gitignore
    │   ├── factories/
    │   │   └── UserFactory.php
    │   ├── migrations/
    │   │   ├── 0000_00_00_000000_create_countries_table.php
    │   │   ├── 0000_00_00_000001_create_states_table.php
    │   │   ├── 0000_00_00_000002_create_cities_table.php
    │   │   ├── 0000_00_00_000003_create_universities_table.php
    │   │   ├── 0000_00_00_000004_create_faculties_table.php
    │   │   ├── 0000_00_00_000005_create_careers_table.php
    │   │   ├── 0001_01_01_000000_create_cache_table.php
    │   │   ├── 0001_01_01_000001_create_permission_tables.php
    │   │   ├── 0001_01_01_000002_create_users_table.php
    │   │   ├── 0001_01_01_000003_create_jobs_table.php
    │   │   ├── 0002_02_00_000000_create_financial_entities_table.php
    │   │   ├── 0002_02_00_000001_create_agreements_table.php
    │   │   ├── 0002_02_00_000002_create_activities_table.php
    │   │   ├── 0002_02_00_000003_create_events_table.php
    │   │   ├── 0002_02_00_000004_create_mobilities_table.php
    │   │   ├── 0002_02_00_000005_create_people_table.php
    │   │   ├── 0002_02_00_000006_create_assistances_table.php
    │   │   └── 0002_02_00_000007_create_event_university_table.php
    │   └── seeders/
    │       └── DatabaseSeeder.php
    ├── lang/
    │   └── en/
    │       ├── auth.php
    │       ├── pagination.php
    │       ├── passwords.php
    │       └── validation.php
    ├── public/
    │   ├── index.php
    │   ├── robots.txt
    │   ├── .htaccess
    │   └── icons/
    ├── resources/
    │   ├── css/
    │   │   └── app.css
    │   ├── js/
    │   │   ├── app.js
    │   │   ├── bootstrap.js
    │   │   └── modules/
    │   │       └── utils/
    │   │           ├── conditionalSelect.js
    │   │           ├── dateValidation.js
    │   │           ├── filterSearch.js
    │   │           └── multiSelectUtil.js
    │   ├── lang/
    │   │   ├── en.json
    │   │   └── es.json
    │   └── views/
    │       ├── assistance.blade.php
    │       ├── index.blade.php
    │       ├── auth/
    │       │   ├── confirm-password.blade.php
    │       │   ├── forgot-password.blade.php
    │       │   ├── login.blade.php
    │       │   ├── register.blade.php
    │       │   ├── reset-password.blade.php
    │       │   └── verify-email.blade.php
    │       ├── components/
    │       │   ├── layouts/
    │       │   │   └── dashboard-layout.blade.php
    │       │   ├── modals/
    │       │   │   ├── create-activity-modal.blade.php
    │       │   │   ├── create-agreement-modal.blade.php
    │       │   │   ├── create-career-modal.blade.php
    │       │   │   ├── create-event-modal.blade.php
    │       │   │   └── create-university-modal.blade.php
    │       │   └── utils/
    │       │       └── language-selector.blade.php
    │       ├── dashboard/
    │       │   ├── index.blade.php
    │       │   └── pages/
    │       │       ├── activities/
    │       │       │   ├── edit.blade.php
    │       │       │   └── index.blade.php
    │       │       ├── agreements/
    │       │       │   ├── edit.blade.php
    │       │       │   └── index.blade.php
    │       │       ├── careers/
    │       │       │   ├── edit.blade.php
    │       │       │   └── index.blade.php
    │       │       ├── events/
    │       │       │   ├── edit.blade.php
    │       │       │   └── index.blade.php
    │       │       └── universities/
    │       │           ├── edit.blade.php
    │       │           └── index.blade.php
    │       ├── layouts/
    │       │   ├── app.blade.php
    │       │   ├── guest.blade.php
    │       │   └── navigation.blade.php
    │       ├── profile/
    │       │   ├── edit.blade.php
    │       │   └── partials/
    │       │       ├── delete-user-form.blade.php
    │       │       ├── update-password-form.blade.php
    │       │       └── update-profile-information-form.blade.php
    │       └── vendor/
    │           └── pagination/
    │               ├── bootstrap-4.blade.php
    │               ├── bootstrap-5.blade.php
    │               ├── default.blade.php
    │               ├── semantic-ui.blade.php
    │               ├── simple-bootstrap-4.blade.php
    │               ├── simple-bootstrap-5.blade.php
    │               ├── simple-default.blade.php
    │               ├── simple-tailwind.blade.php
    │               └── tailwind.blade.php
    ├── routes/
    │   ├── auth.php
    │   ├── console.php
    │   └── web.php
    ├── storage/
    │   ├── cacert.pem
    │   ├── app/
    │   │   ├── .gitignore
    │   │   ├── private/
    │   │   │   └── .gitignore
    │   │   └── public/
    │   │       └── .gitignore
    │   ├── framework/
    │   │   ├── .gitignore
    │   │   ├── cache/
    │   │   │   ├── .gitignore
    │   │   │   └── data/
    │   │   │       └── .gitignore
    │   │   ├── sessions/
    │   │   │   └── .gitignore
    │   │   ├── testing/
    │   │   │   └── .gitignore
    │   │   └── views/
    │   │       └── .gitignore
    │   └── logs/
    │       └── .gitignore
    └── tests/
        ├── Pest.php
        ├── TestCase.php
        ├── Feature/
        │   ├── ExampleTest.php
        │   ├── ProfileTest.php
        │   └── Auth/
        │       ├── AuthenticationTest.php
        │       ├── EmailVerificationTest.php
        │       ├── PasswordConfirmationTest.php
        │       ├── PasswordResetTest.php
        │       ├── PasswordUpdateTest.php
        │       └── RegistrationTest.php
        └── Unit/
            └── ExampleTest.php
</code>

> Hermes es un Proyecto para Internacionalización de Eventos

<h2>Fundación Universitaria Tecnológico Comfenalco</h2>

# Proyecto Hermes

<table>
    <thead>
        <tr>
            <th>Tecnología</th>
            <th>Descripción</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <img style="width: 100%;" src="https://laravel.com/img/logomark.min.svg" alt="Laravel">
            </td>
            <td>
                <b>Laravel Framework</b>
                <p>Laravel es un framework de PHP para el desarrollo de aplicaciones web. Proporciona una sintaxis elegante y herramientas poderosas para facilitar el desarrollo.</p>
            </td>
        </tr>
        <tr>
            <td>
                <img src="https://getcomposer.org/img/logo-composer-transparent5.png" alt="Composer">
            </td>
            <td>
                <b>Composer</b>
                <p>Composer es un gestor de dependencias para PHP. Permite gestionar las bibliotecas y paquetes necesarios para el proyecto.</p>
            </td>
        </tr>
        <tr>
            <td>
                <img style="width: 100%;object-fit: cover;" src="https://www.mysql.com/common/logos/logo-mysql-170x115.png" alt="MySQL">
            </td>
            <td>
                <b>MySQL</b>
                <p>MySQL es un sistema de gestión de bases de datos relacional. Se utiliza para almacenar y gestionar los datos de la aplicación.</p>
            </td>
        </tr>
        <tr>
            <td>
                <img src="https://nodejs.org/static/images/logo.svg" alt="Node.js">
            </td>
            <td>
                <b>Node.js</b>
                <p>Node.js es un entorno de ejecución para JavaScript en el lado del servidor. Se utiliza para gestionar las dependencias del frontend y ejecutar scripts.</p>
            </td>
        </tr>
        <tr>
            <td>
                <img src="https://upload.wikimedia.org/wikipedia/commons/9/95/Tailwind_CSS_logo.svg" alt="Tailwind CSS">
            </td>
            <td>
                <b>Tailwind CSS</b>
                <p>Tailwind CSS es un framework de CSS para crear interfaces de usuario personalizables y responsivas.</p>
            </td>
        </tr>
        <tr>
            <td>
                <!-- Logo de Resend API -->
                <img src="https://resend.com/static/brand/resend-wordmark-white.svg">
            </td>
            <td>
                <b>Resend API</b>
                <p>Resend es una API para enviar correos electrónicos. Se utiliza para enviar notificaciones y correos electrónicos desde la aplicación.</p>
            </td>
        </tr>
        <tr>
            <td>
                <img src="https://choices-js.github.io/Choices/assets/images/logo.svg" alt="Choices.js">
            </td>
            <td>
                <b>Choices.js</b>
                <p>Choices.js es una biblioteca de JavaScript para crear selectores personalizados. Se utiliza para mejorar la experiencia del usuario al seleccionar opciones en formularios.</p>
            </td>
    </tbody>
</table>

## Descripción

Este proyecto es una plataforma de Internacionalización de Eventos, la cual permite a los usuarios de la Fundación Universitaria Tecnológico Comfenalco gestionar eventos internacionales, acuerdos y actividades académicas. La aplicación está construida con Laravel y utiliza una arquitectura moderna para facilitar el desarrollo y mantenimiento.
La aplicación incluye funcionalidades como:

-   Gestión de Eventos y control de asistencia.
-   Gestión de Convenios y Actividades Académicas multinstitucionales.
-   Gestión de Universidades, Facultades y Carreras.
-   Gestión de reportes y estadísticas.
-   Autenticación y autorización de usuarios.
-   Envío de certificados por medio de correo electrónico.
-   Soporte para múltiples idiomas.
-   Interfaz de usuario responsiva y moderna.

## Requisitos previos

Antes de comenzar, asegúrate de tener instalados los siguientes requisitos:

-   [PHP](https://www.php.net/downloads) (>=8.1)
-   [Composer](https://getcomposer.org/download/)
-   [MySQL](https://www.mysql.com/downloads/) o [PostgreSQL](https://www.postgresql.org/download/)
-   [Node.js](https://nodejs.org/) y NPM/Yarn (si se usan assets frontend)
-   [Cacert.pem](https://curl.se/docs/caextract.html) (para conexiones seguras y certificados SSL, util para el uso de Resend API)
-   [Resend API](https://resend.com/) (para el envío de correos electrónicos)

## Instalación

Clona el repositorio en tu máquina local:

```bash
git clone https://github.com/DJAYI/Atlas
cd Atlas
```

Instala las dependencias del backend con Composer:

```bash
composer install
```

Configura el archivo de entorno:

```bash
cp .env.example .env # Es indispensable cambiar la variable de entorno RESEND_API_KEY y la configuración de email si el servidor no es local
```

Genera la clave de la aplicación:

```bash
php artisan key:generate
```

Configura las variables de entorno en `.env`:

```env
DB_CONNECTION=mysql # o pgsql
DB_HOST=127.0.0.1
DB_PORT=3306 # o 5432
DB_DATABASE=nombre_bd
DB_USERNAME=usuario
DB_PASSWORD=contraseña

RESEND_API_KEY= tu_api_key_de_resend

MAIL_MAILER=resend
MAIL_SCHEME=null
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="onboarding@resend.dev"
MAIL_FROM_NAME="Acme"
```

Ejecuta las migraciones y sembradores:

```bash
php artisan migrate --seed
```

Instala las dependencias del frontend (si aplica):

```bash
npm install && npm run dev
```

## Uso

Inicia el servidor de desarrollo de Laravel:

```bash
php artisan serve
```

El proyecto estará disponible en `http://127.0.0.1:8000`.

## Despliegue

Para desplegar en producción:

1. Configura correctamente el entorno de producción en `.env`
2. Ejecuta migraciones y optimiza la aplicación:
    ```bash
    php artisan migrate --force
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    ```

## Contribución

> Abre un Pull Request

## Licencia

Este proyecto está bajo la licencia MIT. Consulta el archivo [LICENSE](LICENSE) para más detalles.
