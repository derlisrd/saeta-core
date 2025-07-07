<footer class="bg-gray-800 dark:bg-gray-900 text-white py-8 mt-12 rounded-t-lg shadow-inner">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
            <!-- Company Info / Logo -->
            <div class="col-span-1">
                <h3 class="text-2xl font-bold mb-4">Saeta Tienda</h3>
                <p class="text-gray-400 text-sm">
                    La plataforma más fácil para crear, gestionar y hacer crecer tu negocio en línea.
                </p>
            </div>

            <!-- Quick Links -->
            <div class="col-span-1">
                <h4 class="text-lg font-semibold mb-4">Enlaces Rápidos</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition duration-300 ease-in-out">Inicio</a></li>
                    <li><a href="{{ route('planes') }}" class="text-gray-400 hover:text-white transition duration-300 ease-in-out">Planes</a></li>
                    <li><a href="{{ route('politicas') }}" class="text-gray-400 hover:text-white transition duration-300 ease-in-out">Políticas de Privacidad</a></li>
                    <li><a href="{{ route('terminos') }}" class="text-gray-400 hover:text-white transition duration-300 ease-in-out">Términos de uso</a></li>
                    <li><a href="{{ route('contacto') }}" class="text-gray-400 hover:text-white transition duration-300 ease-in-out">Contacto</a></li>
                </ul>
            </div>

            <!-- Social Media / Contact -->
            <div class="col-span-1">
                <h4 class="text-lg font-semibold mb-4">Síguenos</h4>
                <div class="flex justify-center md:justify-start space-x-4 mb-4">
                    <a href="#" class="text-gray-400 hover:text-white transition duration-300 ease-in-out">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.505 1.492-3.89 3.776-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33V22C17.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition duration-300 ease-in-out">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.002 3.797.048.843.04 1.15.138 1.504.237.65.188 1.05.374 1.402.73.368.368.553.76.73 1.407.098.354.197.661.237 1.503.046 1.013.048 1.371.048 3.797s-.002 2.784-.048 3.797c-.04.844-.138 1.15-.237 1.504-.188.65-.374 1.05-.73 1.407-.368.368-.76.553-1.407.73-.354.098-.661.197-1.503.237-1.013.046-1.371.048-3.797.048s-2.784-.002-3.797-.048c-.844-.04-1.15-.138-1.504-.237-.65-.188-1.05-.374-1.407-.73-.368-.368-.553-.76-.73-1.407-.098-.354-.197-.661-.237-1.503-.046-1.013-.048-1.371-.048-3.797s.002-2.784.048-3.797c.04-.844.138-1.15.237-1.504.188-.65.374-1.05.73-1.407.368-.368.76-.553 1.407-.73.354-.098.661-.197 1.503-.237C9.514 2.002 9.872 2 12.315 2zm0 0c-2.455 0-2.793.002-3.819.048-.859.04-1.172.14-1.528.239-.7.193-1.134.394-1.54.793-.41.399-.61.844-.793 1.54-.099.356-.199.669-.239 1.527-.046 1.026-.048 1.373-.048 3.821 0 2.447.002 2.794.048 3.82.04.858.14 1.17.239 1.526.193.7.394 1.134.793 1.54.399.41.844.61 1.54.793.356.099.669.199 1.527.239 1.026.046 1.373.048 3.821.048 2.447 0 2.794-.002 3.82-.048.858-.04 1.17-.14 1.526-.239.7-.193 1.134-.394 1.54-.793.41-.399.61-.844.793-1.54.099-.356.199-.669.239-1.527.046-1.026.048-1.373.048-3.821 0-2.447-.002-2.794-.048-3.82-.04-.858-.14-1.17-.239-1.526-.193-.7-.394-1.134-.793-1.54-.399-.41-.844-.61-1.54-.793-.356-.099-.669-.199-.239-1.527C14.71 2.002 14.363 2 12.315 2zM12 7.5c-2.485 0-4.5 2.015-4.5 4.5s2.015 4.5 4.5 4.5 4.5-2.015 4.5-4.5-2.015-4.5-4.5-4.5zm0 1.5c1.657 0 3 1.343 3 3s-1.343 3-3 3-3-1.343-3-3 1.343-3 3-3zm-4.5 9.5a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition duration-300 ease-in-out">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M.057 2.057a11.984 11.984 0 0017.388 15.008l4.492 4.492a1 1 0 001.414-1.414l-4.492-4.492A11.984 11.984 0 00.057 2.057zm1.414 1.414a10 10 0113.882 11.59l-1.414 1.414a10 10 00-13.882-11.59zM12 2a10 10 0110 10 10 10 01-10 10 10 10 01-10-10A10 10 0112 2zm0 2a8 8 018 8 8 8 01-8 8 8 8 01-8-8A8 8 0112 4zm0 2a6 6 016 6 6 6 01-6 6 6 6 01-6-6A6 6 0112 6zm0 2a4 4 014 4 4 4 01-4 4 4 4 01-4-4A4 4 0112 8zm0 2a2 2 012 2 2 2 01-2 2 2 2 01-2-2A2 2 0112 10z" />
                        </svg>
                    </a>
                </div>
                <p class="text-gray-400 text-sm">
                    Email: info@saeta.app
                </p>
            </div>
        </div>

        <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} Saeta Tienda. Todos los derechos reservados.
        </div>
    </div>
</footer>