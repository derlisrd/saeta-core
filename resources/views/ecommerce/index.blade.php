@extends('layouts.ecommerce')

@section('content')
    <section class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white py-20 px-6 sm:px-10 rounded-lg shadow-xl mx-4 mt-8 max-w-7xl lg:mx-auto">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight mb-4">
                Descubre Productos Increíbles
            </h1>
            <p class="text-lg sm:text-xl opacity-90 mb-8">
                Encuentra todo lo que necesitas, desde electrónicos hasta moda, con las mejores ofertas.
            </p>
            <a href="#" class="bg-white text-blue-600 hover:bg-gray-100 font-bold py-3 px-8 rounded-full text-lg shadow-lg transform hover:scale-105 transition duration-300 ease-in-out">
                Ver Todos los Productos
            </a>
        </div>
    </section>

    <!-- Products Section -->
    <main class="flex-grow py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <h2 class="text-3xl font-bold text-gray-800 text-center mb-10">Nuestros Productos Destacados</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach ($productos as $producto)
                    <div class="bg-white  rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition duration-300 ease-in-out border border-gray-200">
                        <img src="{{  $producto->images->first()->url ?? 'https://placehold.co/400x300/e0f2fe/0c4a6e?text=Producto' }}"
                             alt="{{ $producto->nombre ?? 'Producto' }}"
                             class="w-full h-48 object-cover">
                        <div class="p-5">
                            <a href="{{ route('details',$producto->id) }}" class="text-xl font-semibold text-gray-900  mb-2 truncate">{{ $producto->nombre ?? 'Nombre del Producto' }}</a>
                            <p class="text-gray-600  text-sm mb-3 line-clamp-2">{{ $producto->description ?? '' }}</p>
                            <div class="flex items-center justify-between flex-col">
                                <span class="text-2xl font-bold text-blue-600 ">${{ number_format($producto->precio_normal ?? 0, 2) }}</span>
                                <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-full shadow-md transition duration-300 ease-in-out">
                                    Añadir al Carrito
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
    </main>
@endsection


