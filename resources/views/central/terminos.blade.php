@extends('layouts.app')

@section('content')

@include('layouts.menu')

<main class="flex-grow flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8">
    <section class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-xl p-8 sm:p-10 lg:p-12">
        <h1 class="text-4xl sm:text-5xl font-extrabold mb-6 text-gray-800 dark:text-gray-100 text-center">
            Términos y Condiciones de Saeta Tienda
        </h1>
        <p class="text-lg sm:text-xl text-gray-600 dark:text-gray-300 text-center mb-8">
            Bienvenido a Saeta Tienda, una plataforma online proporcionada por Saeta Tienda EAS. Antes de utilizar nuestros servicios, te pedimos que leas detenidamente estos Términos y Condiciones. Estos términos establecen los derechos y responsabilidades tanto para ti como usuario de Saeta Tienda, como para Saeta Tienda EAS como proveedor del servicio.
        </p>

        <div class="space-y-8 text-gray-700 dark:text-gray-300">
            <div>
                <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100">1. Aceptación de los Términos y Condiciones</h2>
                <p>Al acceder y utilizar la plataforma Saeta Tienda (incluyendo la página web y la aplicación web), aceptas quedar vinculado por estos Términos y Condiciones y nuestra <a href="{{ route('politicas') }}" class="text-blue-600 hover:underline">Política de Privacidad</a>. Si no estás de acuerdo con alguno de estos términos, no utilices nuestros servicios.</p>
            </div>

            <div>
                <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100">2. Uso de la Plataforma</h2>
                <p>Saeta Tienda te permite crear y gestionar una tienda online, así como recibir pedidos a través de WhatsApp. Los usuarios pueden navegar por tu tienda, agregar productos al carrito de compras y enviar los pedidos directamente a tu WhatsApp registrado.</p>
            </div>

            <div>
                <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100">3. Registro y Cuenta</h2>
                <p>Para utilizar todas las funcionalidades de Saeta Tienda, es posible que necesites crear una cuenta. Es tu responsabilidad mantener la confidencialidad de tu cuenta y contraseña, y aceptas notificar inmediatamente a Saeta Tienda EAS sobre cualquier uso no autorizado de tu cuenta.</p>
            </div>

            <div>
                <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100">4. Responsabilidades del Usuario</h2>
                <p>Al utilizar Saeta Tienda, aceptas:</p>
                <ul class="list-disc list-inside space-y-2 pl-4">
                    <li>Proporcionar información precisa y actualizada sobre tu tienda y productos.</li>
                    <li>No utilizar Saeta Tienda para actividades ilegales o fraudulentas.</li>
                    <li>No violar los derechos de propiedad intelectual de terceros.</li>
                    <li>Cumplir con todas las leyes y regulaciones aplicables.</li>
                </ul>
            </div>

            <div>
                <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100">5. Propiedad Intelectual</h2>
                <p>Saeta Tienda EAS posee todos los derechos de propiedad intelectual sobre la plataforma Saeta Tienda y su contenido. No se otorga ningún derecho sobre la propiedad intelectual de Saeta Tienda excepto los expresamente concedidos en estos términos.</p>
            </div>

            <div>
                <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100">6. Limitación de Responsabilidad</h2>
                <p>Saeta Tienda EAS no será responsable por ningún daño directo, indirecto, incidental, especial o consecuente que surja del uso o la imposibilidad de uso de la plataforma, incluso si se ha advertido sobre la posibilidad de tales daños.</p>
            </div>

            <div>
                <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100">7. Modificaciones</h2>
                <p>Saeta Tienda EAS se reserva el derecho de modificar o actualizar estos Términos y Condiciones en cualquier momento. Los cambios entrarán en vigencia al ser publicados en la plataforma. Es tu responsabilidad revisar periódicamente los términos actualizados.</p>
            </div>

            <div>
                <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100">8. Contacto</h2>
                <p>Si tienes alguna pregunta o preocupación sobre estos Términos y Condiciones, por favor contáctanos en <a href="mailto:info@saeta.app" class="text-blue-600 hover:underline">info@saeta.app</a></p>
            </div>

            <p class="text-center text-lg font-semibold mt-10">
                Al aceptar estos Términos y Condiciones, reconoces y aceptas todos los términos establecidos aquí.
            </p>
        </div>
    </section>
</main>

@endsection
