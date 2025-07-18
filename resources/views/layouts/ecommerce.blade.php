<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('header_title', 'Tienda Online - Inicio')</title>

    {{-- <link rel="stylesheet" href="{{ env('APP_URL') }}/build/assets/app.css"> --}}
    @vite(['resources/css/app.css'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</head>
<body>
    <header class="bg-white shadow-md py-4 px-6 md:px-10 rounded-b-lg relative z-30">
        <nav class="flex justify-between items-center max-w-7xl mx-auto">
            <!-- Logo -->
            <a href="/" class="text-xl font-bold text-gray-800">
                @yield('title')
            </a>
    
            <!-- Botón hamburguesa -->
            <button id="menu-toggle" class="md:hidden text-gray-700 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
    
            <!-- Menú desktop -->
            <div class="hidden md:flex space-x-6">
                <a href="{{ route('e_inicio') }}" class="text-gray-600 hover:text-gray-900 transition">Inicio</a>
                <a href="{{ route('e_productos') }}" class="text-gray-600 hover:text-gray-900 transition">Productos</a>
                <a href="{{ route('e_inicio') }}" class="text-gray-600 hover:text-gray-900 transition">Contacto</a>
            </div>
        </nav>
    </header>
    
    <!-- Drawer móvil -->
    <div id="mobile-menu"
         class="fixed top-0 right-0 h-full w-64 bg-white shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out z-50 md:hidden">
        <div class="p-6 space-y-4">
            <!-- Botón cerrar -->
            <button id="menu-close" class="text-gray-700 focus:outline-none absolute top-4 right-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
    
            <!-- Links -->
            <a href="{{ route('e_inicio') }}" class="block text-gray-700 hover:text-blue-600">Inicio</a>
            <a href="{{ route('e_productos') }}" class="block text-gray-700 hover:text-blue-600">Productos</a>
            <a href="{{ route('e_inicio') }}" class="block text-gray-700 hover:text-blue-600">Contacto</a>
        </div>
    </div>
    
    <!-- Fondo oscuro (opcional) -->
    <div id="menu-backdrop" class="hidden fixed inset-0 bg-black bg-opacity-30 z-40 md:hidden"></div>
    

    @yield('content')

    <footer class="bg-gray-100  py-6 text-center text-gray-500  text-xs rounded-t-lg mt-auto">
        <p>&copy; 2025 Tienda creada con <a href="https://saeta.app">Saeta Tienda</a> hecho con ❤️</p>
    </footer>
    <script>
        const toggleBtn = document.getElementById('menu-toggle');
        const closeBtn = document.getElementById('menu-close');
        const menu = document.getElementById('mobile-menu');
        const backdrop = document.getElementById('menu-backdrop');
    
        function openMenu() {
            menu.classList.remove('translate-x-full');
            backdrop.classList.remove('hidden');
        }
    
        function closeMenu() {
            menu.classList.add('translate-x-full');
            backdrop.classList.add('hidden');
        }
    
        toggleBtn.addEventListener('click', openMenu);
        closeBtn.addEventListener('click', closeMenu);
        backdrop.addEventListener('click', closeMenu);
    </script>
</body>
</html>