@extends('layouts.app')

@section('content')
<main class="w-full max-w-md mx-auto p-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 sm:p-10 border border-gray-200 dark:border-gray-700">
        <div class="text-center mb-8">
            <h2 class="mt-6 text-2xl font-bold text-gray-900 dark:text-gray-100">
                Registra el nombre de tu tienda
            </h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                ¡Felicidades por tu registro! Ahora, dale un nombre a tu nueva tienda online.
            </p>
        </div>

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

        <form action="{{ route('guardar_tienda') }}" method="POST" class="space-y-6">
            @csrf

            <div class="flex flex-col">
                <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre de la Tienda</label>
                <input type="text" id="nombre" name="nombre" required autocomplete="off"
                value="{{ old('nombre') }}"
                       class="appearance-none block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400
                              focus:ring-blue-500 focus:border-blue-500 sm:text-sm
                              dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-500"
                       placeholder="Ej: Mi Tienda Online">
            </div>

            <div class="flex flex-col">
                <label for="domain" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Dominio de la Tienda</label>
                <div class="flex items-center">
                    <input type="text" id="domain" name="domain" required autocomplete="off"
                        placeholder="mitienda"
                       class="flex-1 appearance-none block w-full px-4 py-2 border border-gray-300 rounded-l-md shadow-sm placeholder-gray-400
                              focus:ring-blue-500 focus:border-blue-500 sm:text-sm
                              dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-500"
                       >
                       {{-- This span will dynamically show the central domain --}}
                       <span id="central_domain_display"
                             class="inline-flex items-center px-3 py-2 border border-l-0 border-gray-300 bg-gray-50 text-gray-500 text-sm rounded-r-md
                                    dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300">
                           .saeta.app
                       </span>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 mb-4" >Será el link de tu tienda</p>
                @error('domain')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-lg font-semibold text-white
                               bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500
                               transition duration-300 ease-in-out transform hover:scale-105">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</main>


@endsection