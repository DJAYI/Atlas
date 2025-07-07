# Configuración de Resend para 2FA

## Estado Actual

✅ **El sistema de 2FA está funcionando correctamente con Resend**

### Configuración Actual

```env
MAIL_MAILER=resend
RESEND_API_KEY=re_h7wY79xT_Jf2s3qZ47Rof6txyjJmCeVYo
MAIL_FROM_ADDRESS="onboarding@resend.dev"
MAIL_FROM_NAME="Wonderlust - Tecnológico Comfenalco"
```

## Limitaciones en Modo Desarrollo

🔸 **Emails de Prueba**: En modo desarrollo, Resend solo permite enviar emails a la dirección registrada en tu cuenta: `danilo.arenasyi@gmail.com`

🔸 **Para Producción**: Necesitas verificar un dominio en [resend.com/domains](https://resend.com/domains) para enviar emails a cualquier dirección.

## Pasos para Producción

### 1. Verificar Dominio

1. Ve a [resend.com/domains](https://resend.com/domains)
2. Agrega tu dominio (ej: `tecnologicocomfenalco.edu.co`)
3. Configura los registros DNS según las instrucciones
4. Espera la verificación

### 2. Actualizar Configuración

```env
MAIL_FROM_ADDRESS="noreply@tecnologicocomfenalco.edu.co"
MAIL_FROM_NAME="Wonderlust - Tecnológico Comfenalco"
```

### 3. Probar en Producción

```bash
php artisan test:verification-email cualquier@email.com
```

## Comandos de Prueba

### Probar Email (Solo funciona con email registrado en desarrollo)

```bash
php artisan test:verification-email danilo.arenasyi@gmail.com
```

### Limpiar Códigos Usados

```bash
php artisan auth:cleanup-verification-codes
```

## Características del Email

-   ✅ Asunto personalizado
-   ✅ Tags para organización (`verification`, `2fa`)
-   ✅ Diseño responsive
-   ✅ Código destacado visualmente
-   ✅ Información de uso único
-   ✅ Branding de la institución

## Estadísticas en Resend

Puedes ver las estadísticas de emails enviados en tu dashboard de Resend:

-   Emails enviados
-   Tasa de entrega
-   Rebotes
-   Quejas

## Troubleshooting

### Error: "You can only send testing emails to your own email"

**Causa**: Estás en modo desarrollo y intentas enviar a un email diferente al registrado.  
**Solución**: Usa `danilo.arenasyi@gmail.com` para pruebas o verifica un dominio.

### Error: "Argument #1 ($contents) must be of type array"

**Causa**: Error en versiones anteriores del Mailable.  
**Solución**: Ya está corregido en la versión actual.

## Próximos Pasos

1. **Para desarrollo**: El sistema funciona perfectamente con el email registrado
2. **Para producción**: Verificar dominio institucional
3. **Opcional**: Configurar webhooks para recibir notificaciones de estado de emails
