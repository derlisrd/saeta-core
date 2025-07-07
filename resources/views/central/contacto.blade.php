@extends('layouts.app')

@section('content')

@include('layouts.menu')

<main class="flex-grow flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8">
    <section class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-xl p-8 sm:p-10 lg:p-12">
        <h1 class="text-4xl sm:text-5xl font-extrabold mb-6 text-gray-800 dark:text-gray-100 text-center">
            Contáctanos
        </h1>
        <p class="text-lg sm:text-xl text-gray-600 dark:text-gray-300 text-center mb-8">
            ¿Tienes alguna pregunta o necesitas ayuda? Rellena el formulario a continuación o utiliza nuestros datos de contacto.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- Contact Form -->
            <div>
                <h2 class="text-2xl font-bold mb-5 text-gray-800 dark:text-gray-100">Envíanos un Mensaje</h2>
                <form action="#" method="POST" class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre Completo</label>
                        <input type="text" name="name" id="name" autocomplete="name" required
                               class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Correo Electrónico</label>
                        <input type="email" name="email" id="email" autocomplete="email" required
                               class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400">
                    </div>
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Asunto</label>
                        <input type="text" name="subject" id="subject" required
                               class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400">
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mensaje</label>
                        <textarea id="message" name="message" rows="5" required
                                  class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400"></textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit"
                                class="inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300 ease-in-out transform hover:scale-105">
                            Enviar Mensaje
                        </button>
                    </div>
                </form>
            </div>

            <!-- Contact Information -->
            <div>
                <h2 class="text-2xl font-bold mb-5 text-gray-800 dark:text-gray-100">Nuestra Información de Contacto</h2>
                <div class="space-y-4 text-gray-600 dark:text-gray-300">
                    <p class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884zM18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" clip-rule="evenodd" />
                        </svg>
                        info@saeta.app
                    </p>
                    <p class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7 2a2 2 0 00-2 2v12a2 2 0 002 2h6a2 2 0 002-2V4a2 2 0 00-2-2H7zm3 14a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                        </svg>
                        +595 (985) 404-009
                    </p>
                    <p class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                        Calle Joel Eulogio Estigarribia Ciudad del Este Paraguay
                    </p>
                </div>
                <div class="mt-8">
                    <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-gray-100">Horario de Atención</h3>
                    <ul class="text-gray-600 dark:text-gray-300 space-y-1">
                        <li>Lunes - Viernes: 9:00 AM - 5:00 PM</li>
                        <li>Sábado: Cerrado</li>
                        <li>Domingo: Cerrado</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection
