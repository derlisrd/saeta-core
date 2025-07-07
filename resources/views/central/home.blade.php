@extends('layouts.app') 


@section('content') 

@include('layouts.menu')

<main class="flex-grow flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8">
    <section class="max-w-4xl mx-auto text-center">
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold my-6 text-gray-800 dark:text-gray-100 leading-tight">
            Tu propia tienda en línea, <br class="hidden sm:inline"> fácil y rápido.
        </h1>
        <p class="text-lg sm:text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto mb-8">
            Crea tu tienda online, mejora cómo compran tus clientes y maneja todo de forma fácil y segura.
        </p>
        <div class="flex justify-center my-5">
            <!-- The original route('signup') is preserved here -->
            <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-8 rounded-full text-lg shadow-xl transform hover:scale-105 transition duration-300 ease-in-out">
                Empezar gratis ahora
            </a>
        </div>
        <div class="mt-12">
            <img src="{{ asset('images/tienda-ejemplo.webp') }}" alt="Mockup de tienda online" class="rounded-lg shadow-lg mx-auto max-w-full h-auto">
        </div>
    </section>
</main>

@include('central.preguntas')

@endsection