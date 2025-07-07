<!DOCTYPE html>
<html>

<head>
    <title>Código de verificación</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .code {
            background-color: #f8f9fa;
            border: 2px solid #007bff;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            font-size: 32px;
            font-weight: bold;
            color: #007bff;
            letter-spacing: 5px;
            margin: 20px 0;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Código de verificación</h1>
            <p>Para completar tu inicio de sesión en Wonderlust, utiliza el siguiente código:</p>
        </div>

        <div class="code">
            {{ $code }}
        </div>

        <p><strong>Importante:</strong> Este código solo puede ser utilizado una vez.</p>
        <p>Si no solicitaste este código, puedes ignorar este mensaje de forma segura.</p>

        <div class="footer">
            <p>Este es un mensaje automático, por favor no respondas a este correo.</p>
        </div>
    </div>
</body>

</html>
