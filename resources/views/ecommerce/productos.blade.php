@extends('layouts.ecommerce')

@section('content')
<div class="container mx-auto px-4 py-8"> {{-- Centra el contenido y añade padding --}}

    {{-- Encabezado con opciones de vista y filtro --}}
    <div class="flex justify-between items-center mb-6">
        <div class="flex space-x-2">
            {{-- Botones de vista (grid/lista) --}}
            <button class="p-2 rounded-md bg-gray-200 text-gray-700 hover:bg-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                </svg>
            </button>
            <button class="p-2 rounded-md bg-white border border-gray-300 text-gray-500 hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM13 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2h-2zM13 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2h-2z" />
                </svg>
            </button>
        </div>
        <div class="relative">
            <select class="appearance-none bg-white border border-gray-300 py-2 pl-3 pr-8 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option>Últimos</option>
                <option>Precio: más bajo</option>
                <option>Precio: más alto</option>
                <option>Más popular</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 6.757 7.586 5.343 9l4.5 4.5z"/></svg>
            </div>
        </div>
    </div>


    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-6">
        @foreach ($productos as $producto)
            <a href="{{ route('e_details',$producto->id) }}">
            <div class="bg-white rounded cursor-pointer overflow-hidden relative">
                @if($producto->tipo === 1)
                    <span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-semibold px-2 py-1 rounded">Promo</span>
                @endif
                <img src="{{  $producto->images->first()->url ?? 'https://placehold.co/400x300/e0f2fe/0c4a6e?text=Producto' }}" alt="{{ $producto->nombre }}" 
                class="w-full h-48 object-cover rounded-lg">
                <div class="p-4">
                    <p class="text-gray-500 text-sm mb-1">{{ $producto->category->nombre }}</p>
                    <h3 class="text-sm text-gray-800 mb-2">{{ $producto->nombre }}</h3>
                    <div class="flex items-baseline mb-2">
                        <span class="text-md font-semibold text-gray-700 mr-2">Gs.{{ number_format($producto->precio_normal,0,',','.') }}</span>
                    
                    </div>
                    <div class="flex items-center text-sm text-gray-600 mb-2">
                        @for ($i = 0; $i < 5; $i++)
                            @if ($i < floor($producto->estrellas))
                                <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.425 8.214 1.196-5.952 5.792 1.408 8.179L12 18.083l-7.338 3.854 1.408-8.179-5.952-5.792 8.214-1.196L12 .587z"/></svg>
                            @elseif ($i < $producto->estrellas)
                                <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 24 24"><path d="M12 18.083L4.662 21.937l1.408-8.179L.118 8.046l8.214-1.196L12 .587l3.668 7.425 8.214 1.196-5.952 5.792 1.408 8.179L12 18.083zM12 2.766l-3.322 6.71-7.409 1.077 5.35 5.21-.94 5.467L12 19.336l6.921 3.633-.94-5.467 5.35-5.21-7.409-1.077L12 2.766z"/></svg>
                            @else
                                <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.425 8.214 1.196-5.952 5.792 1.408 8.179L12 18.083l-7.338 3.854 1.408-8.179-5.952-5.792 8.214-1.196L12 .587z"/></svg>
                            @endif
                        @endfor
                       
                    </div>
                </div>
            </div>
            </a>
        @endforeach
    </div>
</div>
@endsection