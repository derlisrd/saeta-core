<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear una cuenta</title>
    @vite(['resources/css/app.css'])
    @livewireStyles
</head>
<body class='bg-gray-100 dark:bg-dark flex flex-col min-h-screen'>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-300">
                    Crea tu tienda online
                </h1>
                <p class="mt-2 text-gray-600 dark:text-gray-200">
                    Sigue estos simples pasos para configurar tu tienda
                </p>
            </div>

            <livewire:register /> 
        </div>
    </div>

    @livewireScripts
</body>
</html>