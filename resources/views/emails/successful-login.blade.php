<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inicio de Sesión Exitoso</title>
    <style>
        body {
            font-family: 'Figtree', Arial, sans-serif;
            background: #f4f8fb;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        .container {
            max-width: 500px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #e1f0ff, #b3d4ff);
            padding: 20px 30px;
            border-left: 5px solid #1c66af;
        }

        .header h2 {
            color: #1c66af;
            margin: 0 0 10px 0;
            font-size: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .header p {
            margin: 0;
            color: #374151;
            font-size: 14px;
        }

        .content {
            padding: 24px 30px;
        }

        .content h3 {
            margin-bottom: 16px;
            color: #374151;
            font-size: 16px;
            font-weight: 600;
        }

        .details-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .details-list li {
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #4b5563;
            font-size: 14px;
        }

        .details-list li strong {
            color: #1f2937;
            font-weight: 600;
        }

        .emoji {
            font-size: 16px;
            width: 20px;
            height: 20px;
            display: inline-block;
        }

        .footer {
            background: #f9fafb;
            padding: 20px 30px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
        }

        .footer p {
            margin: 0;
            color: #6b7280;
            font-size: 12px;
        }

        .logo-section {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .app-name {
            color: #1c66af;
            font-size: 18px;
            font-weight: 700;
        }

        .security-note {
            background: #fef3cd;
            border: 1px solid #f59e0b;
            border-radius: 6px;
            padding: 12px 16px;
            margin-top: 20px;
        }

        .security-note p {
            margin: 0;
            color: #92400e;
            font-size: 13px;
        }

        @media (max-width: 600px) {
            .container {
                margin: 10px;
                max-width: none;
            }

            .header,
            .content {
                padding: 16px 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo-section">
                <span class="app-name">Wonderlust</span>
            </div>
            <h2>
                <span class="emoji">✅</span>
                Inicio de Sesión Exitoso
            </h2>
            <p>Hola <strong>{{ $username }}</strong>, te informamos que se ha iniciado sesión exitosamente en tu
                cuenta de Wonderlust.</p>
        </div>

        <div class="content">
            <h3>Detalles del Acceso:</h3>
            <ul class="details-list">
                <li>
                    <span class="emoji">📅</span>
                    <strong>Fecha y Hora:</strong> {{ $loginTime }}
                </li>
                <li>
                    <span class="emoji">👤</span>
                    <strong>Usuario:</strong> {{ $username }}
                </li>
                <li>
                    <span class="emoji">📧</span>
                    <strong>Correo:</strong> {{ $email }}
                </li>
                <li>
                    <span class="emoji">📍</span>
                    <strong>Dirección IP:</strong> {{ $ipAddress }}
                </li>
                <li>
                    <span class="emoji">💻</span>
                    <strong>Navegador:</strong> {{ $userAgent }}
                </li>
            </ul>

            <div class="security-note">
                <p><strong>🔒 Importante:</strong> Si no reconoces este inicio de sesión, te recomendamos cambiar tu
                    contraseña inmediatamente y contactar al administrador del sistema.</p>
            </div>
        </div>

        <div class="footer">
            <p>Este es un mensaje automático de seguridad. Por favor, no respondas a este correo.</p>
            <p>&copy; {{ date('Y') }} {{ $appName }} - Fundación Universitaria Tecnológico Comfenalco</p>
        </div>
    </div>
</body>

</html>
