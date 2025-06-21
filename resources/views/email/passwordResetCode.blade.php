<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código de Recuperación</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .container {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 10px;
        }
        .title {
            font-size: 20px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 20px;
        }
        .code-container {
            background-color: #f3f4f6;
            border: 2px dashed #d1d5db;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            margin: 30px 0;
        }
        .code {
            font-size: 36px;
            font-weight: bold;
            color: #1f2937;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
            background-color: white;
            padding: 15px 25px;
            border-radius: 6px;
            display: inline-block;
            border: 1px solid #e5e7eb;
        }
        .info {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .warning {
            background-color: #fee2e2;
            border-left: 4px solid #ef4444;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            font-size: 14px;
            color: #6b7280;
        }
        .button {
            display: inline-block;
            background-color: #2563eb;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">🔐 Saeta sistemas</div>
            <h1 class="title">Código de Recuperación de Contraseña</h1>
        </div>

        <p>Hola,</p>
        
        <p>Recibiste este correo porque solicitaste restablecer la contraseña de tu cuenta asociada a <strong>{{ $email }}</strong>.</p>

        <div class="code-container">
            <p style="margin: 0 0 15px 0; font-size: 14px; color: #6b7280;">Tu código de verificación es:</p>
            <div class="code">{{ $code }}</div>
        </div>

        <div class="info">
            <strong>⏰ Información importante:</strong>
            <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                <li>Este código expira en <strong>15 minutos</strong></li>
                <li>Solo puedes usar este código una vez</li>
                <li>Ingresa el código exactamente como se muestra</li>
            </ul>
        </div>

        <div class="warning">
            <strong>🔒 Seguridad:</strong>
            <p style="margin: 10px 0 0 0;">Si no solicitaste este código, ignora este correo. Tu cuenta permanece segura y no se realizará ningún cambio.</p>
        </div>

        <p>Si tienes problemas para restablecer tu contraseña, no dudes en contactarnos.</p>

        <div class="footer">
            <p>Este correo fue enviado automáticamente, por favor no respondas a este mensaje.</p>
            <p style="margin: 5px 0 0 0;">© {{ date('Y') }} Mi Aplicación. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>