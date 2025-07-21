@extends('layouts.ecommerce')

@section('title', $options['title'] ?? 'Tienda Online')
@section('header_title', $options['title'] ?? 'Tienda Online')

@section('content')
<div class="container mx-auto px-4 py-8"> 

  
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


    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($productos as $producto)
            <a href="{{ route('e_details',$producto->id) }}">
            <div class="bg-white rounded cursor-pointer overflow-hidden relative">
                @if($producto->descuento_activo === 1)
                    <span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-semibold px-2 py-1 rounded">Promo</span>
                @endif
                <img src="{{  $producto->images->first()->url ?? 'https://placehold.co/400x300/e0f2fe/0c4a6e?text=Producto' }}" alt="{{ $producto->nombre }}" 
                class="w-full h-48 object-cover rounded-lg">
                <div class="p-4">
                    <p class="text-gray-500 text-sm mb-1">{{ $producto->category->nombre }}</p>
                    <h3 class="text-xs text-gray-800 mb-2">{{ $producto->nombre }}</h3>
                    <div class="flex flex-col items-baseline mb-2">
                        
                        @if($producto->descuento_activo === 1)
                            <p class="text-sm text-gray-600 line-through mr-2">{{ number_format($producto->precio_normal,0,',','.') }}Gs.</p>
                            <p class="text-sm  font-semibold text-red-600">{{ number_format($producto->precio_descuento,0,',','.') }}Gs.</p>
                        @else
                            <span class="text-sm text-gray-600">{{ number_format($producto->precio_normal,0,',','.')}} Gs.</span> 
                        @endif
                        
                    </div>
                   
                </div>
            </div>
            </a>
        @endforeach
    </div>
</div>
@endsection