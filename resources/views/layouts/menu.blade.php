<nav class="bg-white dark:bg-gray-800 shadow-sm py-4 px-6 md:px-10 flex justify-between items-center rounded-b-lg">
    <div class="flex items-center">
        <a href="{{ route('home') }}" class="text-2xl font-bold text-gray-800 dark:text-white">
            <span class="text-blue-600">Saeta</span> Tienda
        </a>
    </div>

    <div class="items-center space-x-4 hidden md:flex">
        @guest('admin')
        <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition duration-300 ease-in-out ">Iniciar</a>
        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-5 rounded-full shadow-md transition duration-300 ease-in-out">
            Registrar
        </a>
        @endguest
        @auth('admin')
        <a href="{{ route('dashboard') }}" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition duration-300 ease-in-out ">Dashboard</a>
       
        <a href="{{ route('logout') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-5 rounded-full shadow-md transition duration-300 ease-in-out">
            Cerrar Sesión
        </a>
        @endauth
    </div>
    <div class="md:hidden">
        <button id="menu-toggle" class=" text-gray-700 dark:text-gray-200 focus:outline-none">
            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-menu-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 6l16 0" /><path d="M4 12l16 0" /><path d="M4 18l16 0" /></svg>
        </button>
    </div>

    <div id="menu-backdrop" class="hidden fixed inset-0 bg-black bg-opacity-30 z-40 md:hidden"></div>
    <div id="mobile-menu"
         class="fixed top-0 right-0 h-full w-64 bg-white dark:bg-gray-700 shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out z-50 md:hidden">
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
            <a href="{{ route('login') }}" class="block text-gray-700 dark:text-gray-200 hover:text-blue-60 text-lg uppercase">Iniciar</a>
            <a href="{{ route('register') }}" class="block text-gray-700 dark:text-gray-200 text-lg uppercase">Registro</a>
        </div>
    </div>

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
</nav>