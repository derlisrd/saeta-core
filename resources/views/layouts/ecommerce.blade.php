<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Online - Inicio</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Font: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc; /* Light background */
            color: #374151; /* Dark gray text */
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body>
    <header class="bg-white  shadow-md py-4 px-6 md:px-10 rounded-b-lg">
        <nav class="flex justify-between items-center max-w-7xl mx-auto">
            <a href="/" class="text-xl font-bold text-gray-800 ">
               Tienda
            </a>
            <div class="hidden md:flex space-x-6">
                <a href="{{ route('e_inicio') }}" class="text-gray-600  hover:text-gray-200  transition duration-300 ease-in-out">Inicio</a>
                <a href="{{ route('e_productos') }}" class="text-gray-600  hover:text-gray-200  transition duration-100 ease-in-out">Productos</a>
                <a href="#" class="text-gray-600  hover:text-gray-200 transition duration-300 ease-in-out">Ofertas</a>
            </div>
            <div class="flex items-center space-x-4">
               
               
            </div>
        </nav>
    </header>

    @yield('content')

    <footer class="bg-gray-100  py-6 text-center text-gray-500  text-sm rounded-t-lg mt-auto">
        <p>&copy; 2025 Tienda creada con <a href="https://saeta.app">Saeta Tienda</a> hecho con ❤️</p>
    </footer>
</body>


</html>