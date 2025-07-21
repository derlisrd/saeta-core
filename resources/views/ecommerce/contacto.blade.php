@extends('layouts.ecommerce')

@section('title', $options['title']  ?? 'Tienda Online')
@section('header_title', $options['title'] . ' - ' . 'Contacto' ?? 'Tienda Online')

@section('content')
    <section class="py-20 px-6 sm:px-10 rounded-lg shadow-xl mx-4 mt-8 max-w-4xl lg:mx-auto bg-white/80 backdrop-blur-md">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-extrabold text-gray-800 mb-4">Contáctanos</h1>
            <p class="text-lg text-gray-600">Estamos para ayudarte. Podés contactarnos por cualquiera de los siguientes medios:</p>
        </div>

        <div class="space-y-8 text-gray-700 text-md">
            <!-- WhatsApp -->
            <div class="flex items-center space-x-4">
                <div class="text-green-500">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.52 3.48A11.94 11.94 0 0 0 12 0C5.37 0 0 5.37 0 12a11.95 11.95 0 0 0 1.67 6.17L0 24l5.97-1.64A11.95 11.95 0 0 0 12 24c6.63 0 12-5.37 12-12a11.94 11.94 0 0 0-3.48-8.52zM12 22c-1.7 0-3.3-.42-4.71-1.15l-.34-.2-3.54.97.95-3.45-.21-.35A9.95 9.95 0 0 1 2 12c0-5.52 4.48-10 10-10s10 4.48 10 10-4.48 10-10 10zm5.12-7.75c-.28-.14-1.64-.8-1.89-.9-.25-.1-.44-.14-.63.14-.18.28-.72.9-.88 1.09-.16.18-.32.2-.6.07-.28-.14-1.18-.44-2.25-1.4-.83-.74-1.39-1.65-1.56-1.93-.16-.28-.02-.43.12-.57.12-.12.28-.32.42-.48.14-.16.18-.28.28-.46.1-.18.05-.34-.02-.48-.07-.14-.63-1.52-.86-2.07-.22-.52-.44-.44-.63-.44h-.53c-.18 0-.46.07-.7.34s-.92.9-.92 2.2.94 2.56 1.08 2.74c.14.18 1.84 2.8 4.46 3.93.62.27 1.1.43 1.47.55.62.2 1.18.17 1.63.1.5-.07 1.64-.66 1.87-1.29.23-.62.23-1.15.16-1.29-.07-.14-.25-.2-.53-.34z"/>
                    </svg>
                </div>
                <div>
                    <p><strong>WhatsApp:</strong> <a href="https://wa.me/{{ $options['whatsapp'] ?? '+595981123456' }}" class="text-green-600 hover:underline">{{$options['whatsapp'] ?? '+595981123456' }}</a></p>
                </div>
            </div>

            <!-- Teléfono -->
            <div class="flex items-center space-x-4">
                <div class="text-blue-500">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M6.62 10.79a15.053 15.053 0 0 0 6.59 6.59l2.2-2.2a1.004 1.004 0 0 1 1.05-.24c1.12.37 2.33.57 3.54.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1C10.39 21 3 13.61 3 4c0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.21.2 2.42.57 3.54.11.35.03.74-.24 1.01l-2.21 2.24z"/>
                    </svg>
                </div>
                <div>
                    <p><strong>Teléfono:</strong> <a href="tel:{{ $options['telefono'] ?? '+59521456789' }}" class="text-blue-600 hover:underline"> {{ $options['telefono'] ?? '+59521456789' }} </a></p>
                </div>
            </div>

            <!-- Dirección -->
            <div class="flex items-center space-x-4">
                <div class="text-red-500">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C8.14 2 5 5.14 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.86-3.14-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z"/>
                    </svg>
                </div>
                <div>
                    <p><strong>Dirección:</strong> {{ $options['direccion'] ?? 'Calle 123, Ciudad, País' }}</p>
                </div>
            </div>
        </div>
    </section>
@endsection
