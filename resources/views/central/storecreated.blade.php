<main class="w-full max-w-md mx-auto p-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 sm:p-10 border border-gray-200 dark:border-gray-700">
        <div class="text-center mb-8">
            <a href="/" class="text-3xl font-extrabold text-gray-800 dark:text-white">
                <span class="text-blue-600">Tienda</span>Fácil
            </a>
            <h2 class="mt-6 text-2xl font-bold text-gray-900 dark:text-gray-100">
                Registra el nombre de tu tienda
            </h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                ¡Felicidades por tu registro! Ahora, dale un nombre a tu nueva tienda online.
            </p>
        </div>

        <!-- Mensajes de éxito o error (Laravel session messages) -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <form action="{{ route('store.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="store_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre de la Tienda</label>
                <input type="text" id="store_name" name="store_name" required autocomplete="organization"
                       class="appearance-none block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400
                              focus:ring-blue-500 focus:border-blue-500 sm:text-sm
                              dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-500"
                       placeholder="Ej: Mi Tienda Genial">
                @error('store_name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-lg font-semibold text-white
                               bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500
                               transition duration-300 ease-in-out transform hover:scale-105">
                    Guardar Nombre de Tienda
                </button>
            </div>
        </form>
    </div>
</main>