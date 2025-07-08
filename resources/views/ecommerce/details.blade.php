@extends('layouts.ecommerce')

@section('content')

<div class="max-w-6xl mx-auto px-4 py-10 grid grid-cols-1 md:grid-cols-2 gap-10"
     x-data="{ imageActual: '{{ $producto->images->first()->url ?? 'https://placehold.co/600x400?text=Producto' }}' }"
>
    <!-- Imagen principal -->
    <div class="space-y-4">
        <div class="rounded-lg overflow-hidden shadow-md">
            <img :src="imageActual"
                 alt="{{ $producto->nombre }}"
                 class="w-full h-[400px] object-cover transition duration-300"
            />
        </div>

        <!-- Miniaturas -->
        <div class="flex space-x-2 overflow-x-auto">
            @foreach($producto->images as $imagen)
                <img
                    src="{{ $imagen->miniatura }}"
                    alt="Miniatura"
                    class="w-20 h-20 rounded-md object-cover border hover:ring-2 ring-blue-500 cursor-pointer"
                    @click="imageActual = '{{ $imagen->url }}'"
                />
            @endforeach
        </div>
    </div>

    <!-- Info del producto -->
    <div class="space-y-6">
        <h1 class="text-3xl font-bold text-gray-900">{{ $producto->nombre }}</h1>
        <div class="text-2xl text-blue-600 font-bold">${{ number_format($producto->precio_normal, 2) }}</div>
        <p class="text-gray-600">{{ $producto->descripcion ?? 'Sin descripción.' }}</p>

        <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-md mt-6">
            Añadir al carrito
        </button>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

@endsection
