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
<body class='bg-gray-100 dark:bg-dark flex flex-col min-h-screen'>

    @yield('content')

    <footer class="bg-gray-100 dark:bg-gray-900 py-6 text-center text-gray-500 dark:text-gray-400 text-sm rounded-t-lg mt-auto">
        <p>&copy; 2025 Saeta Tienda. Todos los derechos reservados.</p>
    </footer>

</body>
</html>