@extends('layouts.app')

@include('layouts.mainmenu')

@section('content')
<main class="w-full max-w-md mx-auto p-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 sm:p-10 border border-gray-200 dark:border-gray-700">
        <div class="text-center mb-8">
            <h2 class="mt-6 text-2xl font-bold text-gray-900 dark:text-gray-100">
                Crea tu cuenta
            </h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Empieza a construir tu tienda online en minutos.
            </p>
        </div>

        <form action="{{ route('signup_submit') }}" method="POST" class="space-y-6">
             @csrf 

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre</label>
                <input type="text" id="name" name="name" required autocomplete="name"
                       class="appearance-none block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400
                              focus:ring-blue-500 focus:border-blue-500 sm:text-sm
                              dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-500"
                       placeholder="Tu nombre completo">
                 @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Correo electrónico</label>
                <input type="email" id="email" name="email" required autocomplete="email"
                       class="appearance-none block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400
                              focus:ring-blue-500 focus:border-blue-500 sm:text-sm
                              dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-500"
                       placeholder="ejemplo@dominio.com">
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror 
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contraseña</label>
                <input type="password" id="password" name="password" required autocomplete="new-password"
                       class="appearance-none block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400
                              focus:ring-blue-500 focus:border-blue-500 sm:text-sm
                              dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-500"
                       placeholder="Mínimo 6 caracteres">
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-lg font-semibold text-white
                               bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500
                               transition duration-300 ease-in-out transform hover:scale-105">
                    Registrarse
                </button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                ¿Ya tienes una cuenta?
                <a href="{{ route('signin') }}" class="font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">
                    Inicia sesión
                </a>
            </p>
        </div>
    </div>
</main>
@endsection
