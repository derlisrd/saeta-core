@extends('layouts.ecommerce') {{-- Solo si usás un layout base --}}
@section('title', $options['title'] ?? 'Tienda Online')
@section('header_title', $options['title'] ?? 'Tienda Online')
@section('content')


<div class="max-w-6xl mx-auto px-4 py-10 grid grid-cols-1 md:grid-cols-2 gap-10"
     x-data="{
        imageActual: '{{ $producto->images->first() ? url('/') . $producto->images->first()->url :  'https://placehold.co/600x400?text=Producto' }}',
        cargando: false,
        cambiarImagen(nuevaUrl) {
            this.cargando = true
            const img = new Image()
            img.src = nuevaUrl
            img.onload = () => {
                this.imageActual = nuevaUrl
                this.cargando = false
            }
        }
     }"
>

    <!-- Galería de imágenes -->
    <div class="space-y-4">
        <!-- Imagen principal con loader -->
        <div class="relative w-full h-[400px] rounded-lg overflow-hidden shadow-md">
            <!-- Imagen principal -->
            <img
                :src="imageActual"
                alt="{{ $producto->nombre }}"
                class="w-full h-full object-cover transition duration-300"
            />

            <!-- Loader -->
            <div
                x-show="cargando"
                class="absolute inset-0 bg-white/60 flex items-center justify-center"
            >
                <svg class="animate-spin h-10 w-10 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10"
                            stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                          d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
            </div>
        </div>

        <!-- Miniaturas -->
        <div class="flex space-x-2 overflow-x-auto">
            @foreach($producto->images as $imagen)
                <img
                    src="{{ $imagen->miniatura }}"
                    alt="Miniatura"
                    class="w-20 h-20 rounded-md object-cover border hover:ring-2 ring-gray-500 cursor-pointer"
                    @click="cambiarImagen('{{ $imagen->url }}')"
                />
            @endforeach
        </div>
    </div>

    <!-- Información del producto -->
    <div class="space-y-6">
        <h1 class="text-3xl font-bold text-gray-900">{{ $producto->nombre }}</h1>

        

        <div class="flex items-center space-x-3">
            <span class="text-xl font-bold text-zinc-800">Gs.{{ number_format($producto->precio_normal,0,'','.') }}</span>
            <span class="text-lg text-gray-400 line-through">Gs.{{ number_format($producto->precio_normal * 1.15, 0, '', '.') }}</span>
        </div>


        <p class="text-gray-600">
            {{ $producto->descripcion ?? 'Sin descripción disponible.' }}
        </p>

        <button class="bg-gray-600 hover:bg-slate-700 text-white font-bold py-3 px-6 rounded-lg shadow-md mt-6">
            Hacer pedido
        </button>
    </div>
</div>
@endsection
