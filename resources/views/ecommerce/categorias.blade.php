

@extends('layouts.ecommerce') 

@section('title', $options['title'] ?? 'Categorías')
@section('header_title', $options['title'] ?? 'Nuestras Categorías')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-semibold mb-6">Nuestras Categorías</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($categorias as $categoria)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <a href="#" class="block">
                    

                    <img 
                    src="{{ $categoria->images->miniatura ?? 'https://placehold.co/100x100.png' }}"
                    
                    alt="Portada de la categoría {{ $categoria->nombre }}" class="w-full h-48 object-cover">
                </a>
                <div class="p-4">
                    <h2 class="text-xl mb-2">{{ $categoria->nombre }}</h2>
                    <p class="text-gray-600 text-sm">{{ Str::limit($categoria->descripcion, 70) }}</p> {{-- Muestra una descripción limitada --}}
                    <a href="#" class="mt-4 inline-block text-indigo-600 hover:text-indigo-800 font-medium">Ver productos</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection