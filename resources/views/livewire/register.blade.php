<div class="max-w-2xl mx-auto p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg sm:p-10 border border-gray-200 dark:border-gray-700">
    <!-- Indicador de progreso -->
    <div class="mb-4">
        <div class="flex justify-between items-center text-sm text-gray-600 mb-2">
            <span class="text-gray-400">Paso {{ $currentStep }} de {{ $totalSteps }}</span>
        </div>
    
        <div class="w-full bg-gray-400 h-1">
            <div class="h-1 bg-blue-500 transition-all duration-300" style="width: {{ ($currentStep / $totalSteps) * 100 }}%;"></div>
        </div>
    </div>

    <div wire:loading class="w-full flex justify-center items-center">
        <div role="status">
            <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <div>

        <form wire:submit.prevent="submitForm">
            <!-- Paso 1: Datos del usuario -->
            <div class="{{ $currentStep == 1 ? 'block' : 'hidden' }}">
                <h2 class="mt-6 text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">Datos personales</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre</label>
                        <input type="text" wire:model="name" 
                        class="appearance-none block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400
                        focus:ring-blue-500 focus:border-blue-500 sm:text-sm
                        dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-500" placeholder="Tu nombre">
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Correo electrónico</label>
                        <input type="email" wire:model="email" 
                        class="appearance-none block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400
                        focus:ring-blue-500 focus:border-blue-500 sm:text-sm
                        dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-500" 
                               placeholder="tu@correo.com">
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contraseña</label>
                        <input type="password" wire:model="password" 
                        class="appearance-none block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400
                        focus:ring-blue-500 focus:border-blue-500 sm:text-sm
                        dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-500" 
                               placeholder="Mínimo 6 caracteres">
                        @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
    
            <!-- Paso 2: Datos de la tienda -->
            <div class="{{ $currentStep == 2 ? 'block' : 'hidden' }}">
                <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-300">Configura tu tienda</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Nombre de la tienda</label>
                        <input type="text" wire:model="store" 
                        class="appearance-none block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400
                        focus:ring-blue-500 focus:border-blue-500 sm:text-sm
                        dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-500"
                               placeholder="Mi Tienda Online">
                        @error('store') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
    
                    <div>
                        <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Dominio: será el link de tu tienda.</label>
                        <div class="flex">
                            <input type="text" wire:model="domain" 
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                    dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-500
                                   "
                                   placeholder="mitienda">
                            <span class="px-3 py-2 bg-gray-100 border border-l-0 border-gray-300 rounded-r-md text-gray-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-500">
                                {{ env('CENTRAL_DOMAIN','.com') }}
                            </span>
                        </div>
                        @error('domain') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
    
            <!-- Paso 3: Plan de pago -->
            <div class="{{ $currentStep == 3 ? 'block' : 'hidden' }}">
                <h2 class="text-2xl font-bold mb-6 text-gray-700 dark:text-gray-300">Elige tu plan: {{$plan_seleccionado === 1 ? 'gratuito' : 'de pago' }}</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    <div class="border rounded-lg p-2  transition-all cursor-pointer
                        {{ $plan_seleccionado === 1 ? 'border-blue-500' : 'border-gray-300 hover:border-gray-400' }}"
                        wire:click="seleccionarPlan(1)" 
                        >
                        <div class="text-center">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2 dark:text-gray-100">Gratuito</h3>
                            <p class="text-3xl font-bold text-gray-800 mb-2 dark:text-gray-100">$0</p>
                            <p class="text-sm text-gray-500 mb-4 invisible">por mes</p>
                            <ul class="text-sm text-gray-600 space-y-1 dark:text-gray-100">
                                <li>• Hasta 10 productos</li>
                                <li>• Soporte básico</li>
                                <li>• Plantillas básicas</li>
                            </ul>
                            
                        </div>
                    </div>
    
                    
                    <div class="border rounded-lg p-2 cursor-pointer transition-all
                        {{ $plan_seleccionado == 2 ? 'border-blue-500' : 'border-gray-300 hover:border-gray-400' }}"
                        wire:click="seleccionarPlan(2)" 
                        >
                        <div class="text-center">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2 dark:text-gray-100">Pago</h3>
                            <p class="text-3xl font-bold text-gray-800 mb-2 dark:text-gray-100"> 80.000 Gs.</p>
                            <p class="text-sm text-gray-500 mb-4 dark:text-gray-100">por mes</p>
                            <ul class="text-sm text-gray-600 space-y-1 dark:text-gray-100">
                                <li>• Lo gratuito más...</li>
                                <li>• Sin límites de productos</li>
                                <li>• Control de stock</li>
                                <li>• Control de ventas</li>
                                <li>• Informes de ventas</li>
                                <li>• Personalizar la tienda virtual</li>
                            </ul>
                            
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Botones de navegación -->
            <div class="flex justify-between mt-8">
                <button type="button" wire:click="previousStep" {{ $currentStep == 1 ? 'disabled' : '' }}
                        class="px-4 py-2 text-gray-600 bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors
                        {{ $currentStep == 1 ? 'invisible' : '' }}">
                    Anterior
                </button>
    
                @if ($currentStep < $totalSteps)
                    <button type="button" wire:click="nextStep"
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                        <span wire:loading.remove>Siguiente</span>
                        <span wire:loading wire:target="nextStep">Cargando...</span>
                    </button>
                @else
                <button wire:loading.remove type="submit" class="p-4 border border-transparent rounded-md shadow-sm text-lg font-semibold text-white
                bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-0 focus:ring-blue-500">
                Finalizar</button>
                @endif
            </div>
        </form>
    </div>


</div>