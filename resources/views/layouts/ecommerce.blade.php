<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('header_title', 'Tienda Online - Inicio')</title>

    <link rel="stylesheet" href="{{ env('APP_URL') }}/build/assets/app.css"> 
    {{--  @vite(['resources/css/app.css'])  --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</head>
<body>
    <header class="fixed top-0 left-0 right-0 z-40 bg-white/30 backdrop-blur-md shadow-md py-4 px-6 md:px-10 rounded-b-lg">
        <nav class="flex justify-between items-center max-w-7xl mx-auto">
            <!-- Logo -->
            <a href="/" class="text-md md:text-xl font-bold text-gray-800">
                @yield('title')
            </a>
    
            <div class="md:hidden">
            <button id="menu-toggle" class=" text-gray-700 focus:outline-none">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-menu-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 6l16 0" /><path d="M4 12l16 0" /><path d="M4 18l16 0" /></svg>
            </button>

                <button>
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-shopping-cart"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M17 17h-11v-14h-2" /><path d="M6 5l14 1l-1 7h-13" /></svg>
                </button>
            </div>
    
            <!-- Menú desktop -->
            <div class="hidden md:flex space-x-6">
                <div class="flex gap-4">
                    <a href="{{ route('e_inicio') }}" class="text-gray-600 hover:text-gray-900 transition text-sm">Inicio</a>
                    <a href="{{ route('e_categorias') }}" class="text-gray-600 hover:text-gray-900 transition text-sm">Categorias</a>
                    <a href="{{ route('e_productos') }}" class="text-gray-600 hover:text-gray-900 transition text-sm">Productos</a>
                    <a href="{{ route('e_contacto') }}" class="text-gray-600 hover:text-gray-900 transition text-sm">Contacto</a>
                </div>
                <button>
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-shopping-cart"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M17 17h-11v-14h-2" /><path d="M6 5l14 1l-1 7h-13" /></svg>
                </button>
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
            <a href="{{ route('e_inicio') }}" class="block text-gray-700 hover:text-blue-60 text-lg uppercase">Inicio</a>
            <a href="{{ route('e_categorias') }}" class="block text-gray-700 hover:text-blue-600 text-lg uppercase">Categorias</a>
            <a href="{{ route('e_productos') }}" class="block text-gray-700 hover:text-blue-600 text-lg uppercase">Productos</a>
            <a href="{{ route('e_contacto') }}" class="block text-gray-700 hover:text-blue-600 text-lg uppercase">Contacto</a>
        </div>
    </div>
    
    <!-- Fondo oscuro  -->
    <div id="menu-backdrop" class="hidden fixed inset-0 bg-black bg-opacity-30 z-40 md:hidden"></div>
    

    <main class="mt-20" >
        @yield('content')
    </main>

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