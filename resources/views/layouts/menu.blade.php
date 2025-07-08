<nav class="bg-white dark:bg-gray-800 shadow-sm py-4 px-6 md:px-10 flex justify-between items-center rounded-b-lg">
    <div class="flex items-center">
        <a href="{{ route('home') }}" class="text-2xl font-bold text-gray-800 dark:text-white">
            <span class="text-blue-600">Saeta</span> Tienda
        </a>
    </div>

    <div class="flex items-center space-x-4">
        @guest('admin')
        <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition duration-300 ease-in-out ">Iniciar</a>
        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-5 rounded-full shadow-md transition duration-300 ease-in-out">
            Registrar
        </a>
        @endguest
        @auth('admin')
        <a href="{{ route('dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-5 rounded-full shadow-md transition duration-300 ease-in-out">
            Dashboard
        </a>
        <a href="{{ route('logout') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-5 rounded-full shadow-md transition duration-300 ease-in-out">
            Cerrar Sesión
        </a>
        @endauth
    </div>
</nav>