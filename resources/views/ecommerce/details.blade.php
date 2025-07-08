@extends('layouts.ecommerce')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-1 md:grid-cols-2 gap-10">
    <!-- Galería de imágenes -->
    <div class="space-y-4">
        <div class="rounded-lg overflow-hidden shadow-md">
            <img
                src="{{ $producto->images->first()->url ?? 'https://placehold.co/600x400?text=Producto' }}"
                alt="{{ $producto->nombre }}"
                class="w-full h-[400px] object-cover"
            />
        </div>
        <div class="flex space-x-2 overflow-x-auto">
            @foreach($producto->images as $imagen)
                <img
                    src="{{ $imagen->miniatura }}"
                    alt="Miniatura"
                    class="w-20 h-20 rounded-md object-cover border hover:ring-2 ring-blue-500 cursor-pointer"
                />
            @endforeach
        </div>
    </div>

    <!-- Información del producto -->
    <div class="space-y-6">
        <span class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">En stock</span>

        <h1 class="text-3xl font-bold text-gray-900">{{ $producto->nombre }}</h1>

        <div class="flex items-center space-x-2">
            <div class="flex text-yellow-400">
                @for ($i = 0; $i < 4; $i++)
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.122-6.545L.488 6.91l6.561-.955L10 0l2.951 5.955 6.561.955-4.756 4.635 1.122 6.545z"/></svg>
                @endfor
            </div>
            <span class="text-sm text-gray-500">(9911 reviews)</span>
        </div>

        <div class="flex items-center space-x-3">
            <span class="text-3xl font-bold text-blue-600">${{ number_format($producto->precio_normal, 2) }}</span>
            <span class="text-lg text-gray-400 line-through">${{ number_format($producto->precio_normal * 1.15, 2) }}</span>
        </div>

        <p class="text-gray-600 leading-relaxed">
            {{ $producto->description ?? 'Sin descripción disponible.' }}
        </p>

        <div class="space-y-3">
            <!-- Colores simulados -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                <div class="flex space-x-2">
                    <button class="w-6 h-6 rounded-full bg-orange-500 border-2 border-white ring-2 ring-orange-500"></button>
                    <button class="w-6 h-6 rounded-full bg-purple-600 hover:ring-2 ring-purple-500"></button>
                    <button class="w-6 h-6 rounded-full bg-blue-500 hover:ring-2 ring-blue-400"></button>
                    <button class="w-6 h-6 rounded-full bg-green-400 hover:ring-2 ring-green-500"></button>
                </div>
            </div>

            <!-- Memorias simuladas -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Memoria</label>
                <div class="flex flex-wrap gap-2">
                    @foreach(['128GB', '256GB', '512GB', '1TB'] as $memory)
                        <button class="px-4 py-2 border rounded-full text-sm font-semibold hover:bg-gray-100">
                            {{ $memory }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="flex space-x-4 mt-6">
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-md">
                Añadir al carrito
            </button>
            <button class="border border-gray-300 hover:border-gray-400 text-gray-700 font-semibold py-3 px-6 rounded-lg">
                Comprar ahora
            </button>
        </div>
    </div>
</div>
@endsection
