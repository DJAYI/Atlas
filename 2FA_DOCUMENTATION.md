# Sistema de Autenticación de Doble Factor (2FA)

## Descripción

Este sistema implementa autenticación de doble factor mediante códigos de verificación enviados por correo electrónico.

## Flujo de Autenticación

### 1. Primer Factor - Credenciales

-   El usuario ingresa su email y contraseña
-   Se valida el Turnstile (Cloudflare)
-   Se verifican las credenciales contra la base de datos

### 2. Segundo Factor - Código por Email

-   Si las credenciales son correctas, se genera un código de 6 dígitos
-   El código se envía al email del usuario
-   Se cierra la sesión temporal y se guarda el email en sesión como "pending_2fa_email"
-   El usuario debe ingresar el código en el formulario

### 3. Verificación Final

-   Se valida el código ingresado contra la base de datos
-   Si es correcto, se autentica al usuario completamente
-   Se limpia la sesión temporal

## Características del Sistema

### Seguridad

-   **Códigos únicos**: Cada código se genera aleatoriamente y es único
-   **Sin expiración temporal**: Los códigos no expiran por tiempo
-   **Uso único**: Cada código solo puede usarse una vez y se desactiva automáticamente
-   **Limpieza automática**: Los códigos usados se eliminan cada hora
-   **Rate limiting**: Se mantiene el sistema de limitación de intentos
-   **Invalidación automática**: Al generar un nuevo código, los anteriores se eliminan

### Experiencia de Usuario

-   **Feedback visual**: El formulario muestra claramente cuando se necesita el código
-   **Auto-submit**: El formulario se envía automáticamente cuando se completan los 6 dígitos
-   **Validación en tiempo real**: Solo acepta números en el campo del código
-   **Indicador visual**: El campo se pone verde cuando tiene 6 dígitos

## Archivos Modificados/Creados

### Modelos

-   `app/Models/VerificationCode.php` - Modelo para manejar códigos de verificación

### Migraciones

-   `database/migrations/2024_06_24_000000_create_verification_codes_table.php`

### Mails

-   `app/Mail/VerificationCode.php` - Mailable para enviar códigos por email
-   `resources/views/emails/verification-code.blade.php` - Vista del email

### Request

-   `app/Http/Requests/Auth/LoginRequest.php` - Modificado para incluir lógica 2FA

### Vistas

-   `resources/views/index.blade.php` - Modificado para incluir campo del código

### Comandos

-   `app/Console/Commands/CleanupExpiredVerificationCodes.php` - Limpieza automática
-   `routes/console.php` - Programación del comando

### Idiomas

-   `lang/es/auth.php` - Mensajes de autenticación en español

## Configuración

### Email

Asegúrate de que tu configuración de email esté correcta en `.env`:

```
MAIL_MAILER=smtp
MAIL_HOST=...
MAIL_PORT=...
MAIL_USERNAME=...
MAIL_PASSWORD=...
```

### Cron Jobs

Para que la limpieza automática funcione, agrega esto a tu crontab:

```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## Comandos Artisan

### Limpiar códigos usados manualmente

```bash
php artisan auth:cleanup-verification-codes
```

## Base de Datos

### Tabla: verification_codes

-   `id` - ID único
-   `email` - Email del usuario
-   `code` - Código de 6 dígitos
-   `expires_at` - Timestamp de expiración
-   `used` - Boolean si ya fue usado
-   `created_at` - Timestamp de creación
-   `updated_at` - Timestamp de última actualización

## Personalización

### Tiempo de expiración

Modifica en `VerificationCode::generateCode()`:

```php
'expires_at' => Carbon::now()->addMinutes(5), // Cambiar aquí
```

### Longitud del código

Modifica en `VerificationCode::generateCode()`:

```php
$code = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT); // 6 dígitos
```

### Diseño del email

Modifica `resources/views/emails/verification-code.blade.php`

## Troubleshooting

### El email no se envía

1. Verifica la configuración de email en `.env`
2. Revisa los logs en `storage/logs/laravel.log`
3. Usa `php artisan queue:work` si usas colas

### Los códigos no expiran

1. Verifica que el cron job esté configurado
2. Ejecuta manualmente: `php artisan auth:cleanup-verification-codes`

### El formulario no muestra el campo del código

1. Verifica que la sesión `pending_2fa_email` esté activa
2. Revisa que no haya errores de JavaScript en la consola
