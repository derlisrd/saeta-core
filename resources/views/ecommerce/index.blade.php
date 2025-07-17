@extends('layouts.ecommerce')

@section('content')
    <section class="py-20 px-6 sm:px-10 rounded-lg shadow-xl mx-4 mt-8 max-w-7xl lg:mx-auto">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight mb-4">
                Descubre Productos Increíbles 
            </h1>
            <p class="text-lg sm:text-xl opacity-90 mb-8">
                te ayudamos a crear tu amuleto, la joya personalizada perfecta para regalar. Hacemos grabados de dibujos a linea, fotos, fechas, palabras o frases.
            </p>
            <a href="{{ route('e_productos') }}" class="bg-white hover:bg-gray-100 font-bold py-3 px-8 rounded-full text-lg shadow-lg transform hover:scale-105 transition duration-300 ease-in-out">
                Ver Todos los Productos
            </a>
        </div>
    </section>

    <!-- Products Section -->
    <main class="flex-grow py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <h2 class="text-xl font-bold text-gray-700 mb-10">Nuestros Productos Destacados</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($productos as $producto )
                <a href="{{ route('e_details',$producto->id) }}">
                    <div class="flex flex-row gap-2">
                        <div>
                            <img 
                            class="h-24 rounded-xl object-cover w-full"
                            alt="{{ $producto->nombre }}"
                            src="{{ $producto->images->first()->miniatura ?? 'https://placehold.co/100x100.png' }}" />
                        </div>
                        <div>
                            <p class="text-sm text-gray-800">{{$producto->nombre}}</p>
                            <p class="text-sm text-gray-600">Gs.{{ number_format($producto->precio_normal,0,',','.') }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
            
    </main>
@endsection


