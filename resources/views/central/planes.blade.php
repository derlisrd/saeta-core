@extends('layouts.app')

@section('content')

@include('layouts.menu')

<main class="flex-grow flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8">
    <section class="max-w-6xl mx-auto text-center">
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold mb-6 text-gray-800 dark:text-gray-100 leading-tight">
            Nuestros Planes
        </h1>
        <p class="text-lg sm:text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto mb-12">
            Elige el plan perfecto para tu negocio. Empieza gratis o lleva tu tienda al siguiente nivel.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
            <!-- Plan Gratuito -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-8 sm:p-10 flex flex-col justify-between transform hover:scale-105 transition duration-300 ease-in-out">
                <div>
                    <h2 class="text-3xl font-bold text-blue-600 mb-4">Gratuito</h2>
                    <p class="text-gray-600 dark:text-gray-300 text-lg mb-6">
                        Gratis para siempre, sin compromiso.
                    </p>
                    <div class="text-5xl font-extrabold text-gray-900 dark:text-gray-100 mb-8">
                        Gs. 0<span class="text-xl font-medium text-gray-500 dark:text-gray-400">/mes</span>
                    </div>
                    <ul class="text-left text-gray-700 dark:text-gray-200 space-y-3 mb-8">
                        <li class="flex items-center">
                            <svg class="w-6 h-6 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Hasta 10 productos
                        </li>
                        <li class="flex items-center">
                            <svg class="w-6 h-6 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Pedidos ilimitados
                        </li>
                        <li class="flex items-center">
                            <svg class="w-6 h-6 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Personalización de tienda
                        </li>
                        <li class="flex items-center">
                            <svg class="w-6 h-6 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Precios promocionales
                        </li>
                        <li class="flex items-center">
                            <svg class="w-6 h-6 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Captación de datos de clientes
                        </li>
                    </ul>
                </div>
                <a href="{{ route('register') }}" class="mt-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-full text-lg shadow-md transition duration-300 ease-in-out">
                    Empezar Gratis
                </a>
            </div>

            <!-- Plan Emprendedor -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-8 sm:p-10 flex flex-col justify-between transform hover:scale-105 transition duration-300 ease-in-out border-4 border-blue-500">
                <div>
                    <h2 class="text-3xl font-bold text-blue-600 mb-4">Emprendedor</h2>
                    <p class="text-gray-600 dark:text-gray-300 text-lg mb-6">
                        Tu tienda sin límites. Cancela cuando quieras.
                    </p>
                    <div class="text-5xl font-extrabold text-gray-900 dark:text-gray-100 mb-8">
                        Gs. 59.000<span class="text-xl font-medium text-gray-500 dark:text-gray-400">/mes</span>
                    </div>
                    <ul class="text-left text-gray-700 dark:text-gray-200 space-y-3 mb-8">
                        <li class="flex items-center font-semibold text-gray-800 dark:text-gray-100">
                            Todo lo del Plan Gratuito más:
                        </li>
                        <li class="flex items-center">
                            <svg class="w-6 h-6 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Productos ilimitados
                        </li>
                        <li class="flex items-center">
                            <svg class="w-6 h-6 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Control de inventario
                        </li>
                        <li class="flex items-center">
                            <svg class="w-6 h-6 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Créditos de clientes
                        </li>
                        <li class="flex items-center">
                            <svg class="w-6 h-6 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Gestión de pedidos
                        </li>
                        
                        <li class="flex items-center">
                            <svg class="w-6 h-6 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Atención personalizada
                        </li>
                    </ul>
                </div>
                <a href="{{ route('register') }}" class="mt-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-full text-lg shadow-md transition duration-300 ease-in-out">
                    Elegir Plan Emprendedor
                </a>
            </div>
        </div>
    </section>
</main>

@endsection