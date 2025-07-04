<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saeta tienda</title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    


    @yield('content')
    

    <footer>
        <p>&copy; {{ date('Y') }} Mi Sitio Laravel. Todos los derechos reservados.</p>
    </footer>
</body>
</html>