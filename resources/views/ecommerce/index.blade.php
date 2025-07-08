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
</head>
<body class="min-h-screen flex flex-col">

    <!-- Header / Navbar -->
    <header class="bg-white  shadow-md py-4 px-6 md:px-10 rounded-b-lg">
        <nav class="flex justify-between items-center max-w-7xl mx-auto">
            <a href="/" class="text-xl font-bold text-gray-800 ">
               {{ $nombreTienda }}
            </a>
            <div class="hidden md:flex space-x-6">
                <a href="#" class="text-gray-600  hover:text-blue-600  transition duration-300 ease-in-out">Inicio</a>
                <a href="#" class="text-gray-600  hover:text-blue-600  transition duration-300 ease-in-out">Categorías</a>
                <a href="#" class="text-gray-600  hover:text-blue-600  transition duration-300 ease-in-out">Ofertas</a>
            </div>
            <div class="flex items-center space-x-4">
                <a href="#" class="text-gray-600  hover:text-blue-600  transition duration-300 ease-in-out">
                    Carrito (0)
                </a>
                <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white  py-2 px-5 rounded-full shadow-md transition duration-300 ease-in-out">
                    Mi Cuenta
                </a>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white py-20 px-6 sm:px-10 rounded-lg shadow-xl mx-4 mt-8 max-w-7xl lg:mx-auto">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight mb-4">
                Descubre Productos Increíbles
            </h1>
            <p class="text-lg sm:text-xl opacity-90 mb-8">
                Encuentra todo lo que necesitas, desde electrónicos hasta moda, con las mejores ofertas.
            </p>
            <a href="#" class="bg-white text-blue-600 hover:bg-gray-100 font-bold py-3 px-8 rounded-full text-lg shadow-lg transform hover:scale-105 transition duration-300 ease-in-out">
                Ver Todos los Productos
            </a>
        </div>
    </section>

    <!-- Products Section -->
    <main class="flex-grow py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <h2 class="text-3xl font-bold text-gray-800 text-center mb-10">Nuestros Productos Destacados</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach ($productos as $producto)
                    <div class="bg-white  rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition duration-300 ease-in-out border border-gray-200">
                        <img src="{{  $producto->images->first()->miniatura ?? 'https://placehold.co/400x300/e0f2fe/0c4a6e?text=Producto' }}"
                             alt="{{ $producto->nombre ?? 'Producto' }}"
                             class="w-full h-48 object-cover">
                        <div class="p-5">
                            <h3 class="text-xl font-semibold text-gray-900  mb-2 truncate">{{ $producto->nombre ?? 'Nombre del Producto' }}</h3>
                            <p class="text-gray-600  text-sm mb-3 line-clamp-2">{{ $producto->description ?? '' }}</p>
                            <div class="flex items-center justify-between flex-col">
                                <span class="text-2xl font-bold text-blue-600 ">${{ number_format($producto->precio_normal ?? 0, 2) }}</span>
                                <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-full shadow-md transition duration-300 ease-in-out">
                                    Añadir al Carrito
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-100  py-6 text-center text-gray-500  text-sm rounded-t-lg mt-auto">
        <p>&copy; 2025 Mi Tienda Online. Todos los derechos reservados.</p>
    </footer>

</body>
</html>
