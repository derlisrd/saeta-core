<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saeta tienda</title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite(['resources/css/app.css'])
</head>
<body class='bg-gray-100 dark:bg-dark flex flex-col min-h-screen'>

    @yield('content')

    @include('layouts.footer')

</body>
</html>