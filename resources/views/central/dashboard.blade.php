@extends('layouts.app')

@section('content')

@include('layouts.menu')

<main class="flex-grow flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8">
    <section class="max-w-4xl mx-auto text-center bg-white dark:bg-gray-800 p-8 rounded-lg shadow-xl">
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold my-6 text-gray-800 dark:text-gray-100 leading-tight">
            Bienvenido a tu Dashboard, {{ $userName }}!
        </h1>
        <p class="text-lg sm:text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto mb-8">
            Aquí puedes gestionar tu tienda y acceder a todas las herramientas.
        </p>

        <div class="mt-8 space-y-4">
            <a href="{{ $adminUrl }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-full text-lg shadow-md transform hover:scale-105 transition duration-300 ease-in-out">
                Gestionar Productos
            </a>
            <a href="{{ $storeUrl }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-full text-lg shadow-md transform hover:scale-105 transition duration-300 ease-in-out ml-4">
                Ver tienda
            </a>
        </div>

        <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100">Información de tu Cuenta y Tienda</h2>
            <div class="text-left max-w-md mx-auto space-y-3 text-gray-700 dark:text-gray-300">
                <p><strong>Correo Electrónico:</strong> {{ $userEmail }}</p>
                <p><strong>Dominio de tu Tienda:</strong> <a href="{{ $storeUrl }}" target="_blank" class="text-blue-600 hover:underline">{{ $storeUrl }}</a></p>
                <p><strong>Panel de Administración:</strong> <a href="{{ $adminUrl }}" target="_blank" class="text-blue-600 hover:underline">{{ $adminUrl }}</a></p>
            </div>
        </div>
    </section>
</main>

@endsection