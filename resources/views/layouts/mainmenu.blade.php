<nav class="bg-white dark:bg-gray-800 shadow-sm py-4 px-6 md:px-10 flex justify-between items-center rounded-b-lg">
    <div class="flex items-center">
        <a href="{{ route('home') }}" class="text-2xl font-bold text-gray-800 dark:text-white">
            <span class="text-blue-600">Saeta</span> Tienda
        </a>
    </div>
    <div class="hidden md:flex space-x-6">
      
        <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition duration-300 ease-in-out">Precios</a>
        <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition duration-300 ease-in-out">Contacto</a>
    </div>
    <div class="flex items-center space-x-4">
        <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition duration-300 ease-in-out hidden sm:block">Iniciar Sesión</a>
        <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-5 rounded-full shadow-md transition duration-300 ease-in-out">
            Registrar
        </a>
    </div>
</nav>