@extends('layouts.app')

@section('content')

@include('layouts.menu')

<main class="flex-grow flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8">
    <section class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-xl p-8 sm:p-10 lg:p-12">
        <h1 class="text-4xl sm:text-5xl font-extrabold mb-6 text-gray-800 dark:text-gray-100 text-center">
            Políticas de Privacidad
        </h1>
        <p class="text-lg sm:text-xl text-gray-600 dark:text-gray-300 text-center mb-8">
            En Saeta Tienda, la privacidad de su información personal y del contenido que almacena en nuestros servidores al utilizar nuestros servicios es de suma importancia. Esta Política de Privacidad forma parte de los términos y condiciones de los servicios de Saeta Tienda y tiene como objetivo explicar qué información recopilamos acerca de usted al usar la plataforma de Saeta Tienda (que incluye la página web y nuestra web App), cómo utilizamos esa información y cómo gestionamos su contenido.
        </p>

        <div class="space-y-8 text-gray-700 dark:text-gray-300">
            <div>
                <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100">¿Qué información personal recopilamos de las personas que utilizan Saeta Tienda?</h2>
                <ul class="list-disc list-inside space-y-3 pl-4">
                    <li>
                        <span class="font-semibold">Su nombre, apellido y dirección de correo electrónico:</span>
                        Utilizamos esta información para crear y dar soporte a su cuenta de Saeta Tienda y para ponernos en contacto con usted y ofrecerle una mejor experiencia en cuanto a productos y servicios.
                    </li>
                    <li>
                        <span class="font-semibold">Fotografía de perfil:</span>
                        La fotografía de perfil es opcional y se utiliza para personalizar su cuenta de Saeta Tienda.
                    </li>
                    <li>
                        <span class="font-semibold">Información de la tienda:</span>
                        Si usted es propietario de una tienda, recopilamos información sobre su tienda, como el nombre, la descripción, la dirección y la información de contacto. Esta información se utiliza para mostrar en su tienda en línea y para que los clientes puedan contactarlo.
                    </li>
                    <li>
                        <span class="font-semibold">Alguna otra información:</span>
                        Información básica sobre su dispositivo móvil, incluyendo la marca, modelo y un identificador único del mismo. Ello nos permite proporcionarle el contenido más personalizado y brindar el servicio y el soporte más personalizado para su tipo de dispositivo. Con cada interacción recibimos y almacenamos ciertos tipos de información como ser fecha y hora de acceso a la Plataforma de Saeta Tienda, las secciones consultadas o búsquedas realizadas. Utilizamos cookies para recabar información cuando mediante la aplicación móvil o su navegador de Internet accede a https://saetatienda.com (ejemplo); a publicidad allí expuesta u otros tipos de contenidos que le son ofrecidos en esta misma web o por hipervínculos incluidos en ella que le dirijan a otras páginas web de terceros.
                    </li>
                </ul>
            </div>

            <div>
                <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100">¿Cuál es la postura de Saeta Tienda respecto a la información recopilada de niños?</h2>
                <p>Saeta Tienda es un servicio orientado a mayores de edad y el uso de la misma por menores de edad es responsabilidad exclusiva de los padres y/o tutores. Saeta Tienda no recopila conscientemente información personal de menores. Si nos percatamos de que involuntariamente hemos obtenido información violando las leyes aplicables que prohíban la recogida de información de menores sin dicho consentimiento, procederemos a eliminarla lo antes posible. Lo invitamos a notificarnos de cualquier evento del que Usted tomare conocimiento antes que nosotros.</p>
            </div>

            <div>
                <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100">¿Saeta Tienda me enviará mensajes por correo electrónico?</h2>
                <p>Ocasionalmente podríamos querer comunicarle información sobre anuncios de productos, actualizaciones de software y ofertas especiales. También querremos comunicarle información sobre productos y servicios de nuestros socios comerciales. Consideramos su aceptación de esta Política de Privacidad como su expreso consentimiento a nuestro ofrecimiento para enviarle estos avisos, mensajes y correos electrónicos. Para permitir que los correos que remitimos le sean más útiles e interesantes, habitualmente recibimos una confirmación cuando usted abre un correo electrónico que se le ha enviado, en el caso de que su ordenador soporte este tipo de tareas. Puede cancelar estas modalidades de comunicaciones en cualquier momento desactivando esta opción siguiendo el vínculo que se encuentra en el correo electrónico. Continuará recibiendo información esencial relacionada con la cuenta y el Servicio, incluso si cancela su suscripción a los correos electrónicos promocionales.</p>
            </div>

            <div>
                <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100">¿Saeta Tienda comparte mi Información Personal o mi Contenido?</h2>
                <p>Saeta Tienda no se dedica a vender ni alquilar la información de sus miembros. Solo compartimos información en las siguientes circunstancias:</p>
                <ul class="list-disc list-inside space-y-3 pl-4">
                    <li>
                        <span class="font-semibold">Con su consentimiento explícito:</span> Compartimos información solo cuando usted nos da su consentimiento explícito para hacerlo.
                    </li>
                    <li>
                        <span class="font-semibold">Para hacer cumplir nuestros Términos del Servicio:</span> Revelamos información cuando creemos que es necesario investigar posibles violaciones de nuestros Términos del Servicio, para hacerlos cumplir.
                    </li>
                    <li>
                        <span class="font-semibold">Para cumplir con la ley:</span> Podemos acceder, conservar y revelar información cuando consideremos que es necesario para proteger los derechos, la propiedad o la seguridad personal de Saeta Tienda, de nuestros usuarios, o para cumplir con las leyes aplicables, como órdenes judiciales o procesos legales.
                    </li>
                    <li>
                        <span class="font-semibold">En caso de venta o reorganización:</span> En el caso de venta, fusión o reorganización de todo o parte de nuestro negocio, podemos transferir información según lo permita la ley aplicable.
                    </li>
                    <li>
                        <span class="font-semibold">Aplicaciones y servicios de terceros:</span> Algunas aplicaciones y servicios de terceros que trabajan con nuestro Servicio pueden solicitar acceso a su Contenido u otra información de su cuenta bajo su consentimiento expreso y la responsabilidad de los locales proveedores adheridos al Servicio Saeta Tienda.
                    </li>
                </ul>
            </div>

            <div>
                <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100">¿Podría Saeta Tienda alguna vez hacer pública mi información o contenido personal?</h2>
                <p>No</p>
            </div>

            <div>
                <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100">¿Dónde se almacena mi Información?</h2>
                <p>Cuando usted ingresa su información en la Plataforma de Saeta Tienda a través de su dispositivo móvil u otros dispositivos inteligentes, el Contenido que usted ingrese se almacenará localmente en ese dispositivo. Dicho Contenido será replicado en nuestros servidores, ubicados en un centro de datos en São Paulo, Brasil. Al crear su cuenta en Saeta Tienda, usted acepta esta Política de Privacidad y otorga su consentimiento para que su información, incluyendo la Información Personal y el Contenido personal, sea transmitida, alojada y accesible para Saeta Tienda en Brasil. Esta jurisdicción ofrece niveles adecuados de protección para su información.</p>
            </div>

            <div>
                <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100">¿Cómo puedo corregir o acceder a la Información que Saeta Tienda tiene sobre mí?</h2>
                <p>Si desea acceder a cualquier Información Personal que tengamos sobre usted; solicitar que corrijamos o eliminemos la Información Personal que tenemos sobre usted; o solicitar que no usemos o dejemos de usar su Información Personal para fines publicitarios, puede ponerse en contacto con nosotros en nuestro sitio web en <a href="#" class="text-blue-600 hover:underline">saeta.app</a> o enviando un correo electrónico a <a href="mailto:info@saeta.app" class="text-blue-600 hover:underline">info@saeta.app</a> con el asunto "Acceso a mi información de cuenta". Cumpliremos con tales solicitudes en la medida requerida por la ley o por nuestras políticas y sujetos a las limitaciones de nuestros sistemas.</p>
            </div>

            <div>
                <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100">¿Qué tan segura se encuentra mi información?</h2>
                <p>Saeta Tienda se compromete a proteger la seguridad de su información y toma precauciones razonables para protegerla. Utilizamos tecnologías de codificación criptográfica estándar de la industria para proteger sus datos en tránsito, como la seguridad de la capa de transporte (TLS/SSL). Sin embargo, aunque implementamos medidas de seguridad robustas, no podemos garantizar la seguridad absoluta de la transmisión de datos a través de Internet. Por lo tanto, cualquier transmisión de datos la realiza bajo su propio riesgo. Cuando recibimos sus datos, los protegemos en nuestros servidores utilizando una combinación de medidas de seguridad administrativas, físicas y lógicas. La seguridad de la información almacenada localmente en la aplicación Saeta Tienda instalada en su dispositivo móvil depende del uso que usted haga de las funciones de seguridad de su dispositivo. En caso de detectar una violación a la seguridad de nuestros sistemas, nos comprometemos a intentar notificarle y proporcionarle información sobre las medidas de protección disponibles, ya sea a través del correo electrónico proporcionado por usted o mediante un aviso publicado en nuestro sitio web.</p>
            </div>

            <div>
                <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100">¿Qué pasa si Saeta Tienda cierra mi cuenta?</h2>
                <p>Si Saeta Tienda desactiva su cuenta del Servicio debido a la violación de los Términos del Servicio, usted puede contactarnos para solicitar la eliminación de sus datos, y evaluaremos dicha solicitud caso por caso, cumpliendo con nuestras obligaciones legales.</p>
                <p class="mt-4">Nos reservamos el derecho de revisar, explorar o analizar las comunicaciones que usted realice en la Plataforma de Saeta Tienda para prevenir actividades fraudulentas, evaluar riesgos, cumplir con normativas, realizar investigaciones, analizar y mejorar nuestros servicios de soporte al cliente. En algunos casos, podemos utilizar métodos automatizados dentro del alcance permitido por la ley y la lógica aplicable. Sin embargo, en ocasiones también podemos realizar revisiones manuales de las comunicaciones, especialmente para investigar actividades fraudulentas, proporcionar soporte al cliente o mejorar la funcionalidad de nuestras herramientas automatizadas.</p>
                <p class="mt-4">Saeta Tienda reconoce su derecho a acceder, actualizar, rectificar y, en su caso, eliminar sus datos personales, previa verificación de identidad y conforme a lo establecido por la ley aplicable. Al aceptar nuestros Términos y esta Política de Privacidad, usted acepta todas las actividades y condiciones descritas aquí, así como el suministro voluntario de los datos mencionados en este documento. Nos reservamos el derecho de modificar esta Política de Privacidad en cualquier momento conforme a las disposiciones correspondientes, y le notificaremos con anticipación sobre los cambios futuros.</p>
            </div>
        </div>
    </section>
</main>

@endsection
