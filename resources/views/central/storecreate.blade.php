@extends('layouts.app')

@section('content')
<main class="w-full max-w-md mx-auto p-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 sm:p-10 border border-gray-200 dark:border-gray-700">
        <div class="text-center mb-8">
            <h2 class="mt-6 text-2xl font-bold text-gray-900 dark:text-gray-100">
                Registra el nombre de tu tienda
            </h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                ¡Felicidades por tu registro! Ahora, dale un nombre a tu nueva tienda online.
            </p>
        </div>

        <!-- Mensajes de éxito o error (Laravel session messages) -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <form action="{{ route('store.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="domain" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre de la Tienda</label>
                <input type="text" id="domain" name="domain" required autocomplete="organization"
                       class="appearance-none block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400
                              focus:ring-blue-500 focus:border-blue-500 sm:text-sm
                              dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-500"
                       placeholder="Ej: Mi Tienda Genial">
                <!-- Dynamic domain preview -->
                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                    Tu tienda estará en: <span id="domain_preview" class="font-semibold text-blue-600 dark:text-blue-400"></span>
                </p>
                @error('domain')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-lg font-semibold text-white
                               bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500
                               transition duration-300 ease-in-out transform hover:scale-105">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</main>


<script>
    // Get references to the input and the preview span
    const storeNameInput = document.getElementById('domain');
    const domainPreviewSpan = document.getElementById('domain_preview');

    // Get the CENTRAL_DOMAIN from a Blade variable (assuming it's passed from the controller)
    // Example: return view('store.create', ['centralDomain' => env('CENTRAL_DOMAIN')]);
    const centralDomain = "{{ $centralDomain ?? 'tudominio.com' }}"; // Fallback if not passed

    // Function to slugify text (mimics Laravel's Str::slug but without hyphens for spaces)
    function slugify(text) {
        return text
            .toString()
            .normalize('NFD') // Normalize diacritics
            .replace(/[\u0300-\u036f]/g, '') // Remove diacritics
            .toLowerCase()
            .trim()
            .replace(/\s+/g, '') // Reemplaza espacios con nada (los elimina)
            .replace(/[^\w-]+/g, '') // Remove all non-word chars (except hyphens if they are already there)
            .replace(/--+/g, '-'); // Replace multiple - with single - (less likely now, but good to keep)
    }

    // Update the preview on input
    storeNameInput.addEventListener('input', function() {
        const inputValue = this.value;
        const slugifiedValue = slugify(inputValue);
        domainPreviewSpan.textContent = `${slugifiedValue}.${centralDomain}`;
    });

    // Initialize the preview in case there's old input
    document.addEventListener('DOMContentLoaded', function() {
        const initialValue = storeNameInput.value;
        if (initialValue) {
            const slugifiedValue = slugify(initialValue);
            domainPreviewSpan.textContent = `${slugifiedValue}.${centralDomain}`;
        } else {
            // Display only the central domain if no input yet
            domainPreviewSpan.textContent = `.${centralDomain}`;
        }
    });
</script>

@endsection