<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #2102C7;
            color: #ffffff;
            padding: 10px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            padding: 20px;
        }
        .content p {
            margin: 10px 0;
        }
        .footer {
            background-color: #f4f4f4;
            color: #555555;
            text-align: center;
            padding: 10px;
            border-radius: 0 0 10px 10px;
            font-size: 12px;
        }
        .text{
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img width="128" src="{!! asset('assets/img/logo.png') !!}">
        </div>
        <div class="content">
            <div class="text">
                <hr />
                <h4>Utiliza este código para recuperar tu contraseña de Blupy</h4>
                <hr />
                <h1>{{ $code ?? '' }}</h1>
                <hr />
                <p>Si no solicitaste este código ignora este mensaje.</p>
            </div>
        </div>
        <div class="footer">
            <p>&copy; 2024 BLUPY. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>

