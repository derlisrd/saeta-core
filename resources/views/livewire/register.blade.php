<div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-lg">
    <!-- Indicador de progreso -->
    <div class="mb-4">
        <div class="flex justify-between items-center text-sm text-gray-600 mb-2">
            <span>Paso {{ $currentStep }} de {{ $totalSteps }}</span>
        </div>
    
        <div class="w-full bg-gray-400 h-1">
            <div class="h-1 bg-blue-500 transition-all duration-300" style="width: {{ ($currentStep / $totalSteps) * 100 }}%;">
            </div>
        </div>
    </div>

    <form wire:submit.prevent="submitForm">
        <!-- Paso 1: Datos del usuario -->
        <div class="{{ $currentStep == 1 ? 'block' : 'hidden' }}">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Datos personales</h2>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                    <input type="text" wire:model="name" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Tu nombre">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
                    <input type="email" wire:model="email" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="tu@correo.com">
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                    <input type="password" wire:model="password" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Mínimo 6 caracteres">
                    @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Paso 2: Datos de la tienda -->
        <div class="{{ $currentStep == 2 ? 'block' : 'hidden' }}">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Configura tu tienda</h2>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de la tienda</label>
                    <input type="text" wire:model="store" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Mi Tienda Online">
                    @error('store') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dominio</label>
                    <div class="flex">
                        <input type="text" wire:model="domain" 
                               class="flex-1 px-3 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="mitienda">
                        <span class="px-3 py-2 bg-gray-100 border border-l-0 border-gray-300 rounded-r-md text-gray-500">
                            {{ env('CENTRAL_DOMAIN','.com') }}
                        </span>
                    </div>
                    @error('domain') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Paso 3: Plan de pago -->
        <div class="{{ $currentStep == 3 ? 'block' : 'hidden' }}">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Elige tu plan: {{$plan_seleccionado === 1 ? 'gratuito' : 'de pago' }}</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                
                <div class="border rounded-lg p-2  transition-all cursor-pointer
                    {{ $plan_seleccionado === 1 ? 'border-blue-500 bg-blue-50' : 'border-gray-300 hover:border-gray-400' }}"
                    wire:click="seleccionarPlan(1)" 
                    >
                    <div class="text-center">
                        <h3 class="text-lg font-semibold mb-2">Gratuito</h3>
                        <p class="text-3xl font-bold text-gray-800 mb-2">$0</p>
                        <p class="text-sm text-gray-500 mb-4">por mes</p>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Hasta 10 productos</li>
                            <li>• Soporte básico</li>
                            <li>• Plantillas básicas</li>
                        </ul>
                        
                    </div>
                </div>

                
                <div class="border rounded-lg p-2 cursor-pointer transition-all
                    {{ $plan_seleccionado == 2 ? 'border-blue-500 bg-blue-50' : 'border-gray-300 hover:border-gray-400' }}"
                    wire:click="seleccionarPlan(2)" 
                    >
                    <div class="text-center">
                        <h3 class="text-lg font-semibold mb-2">Pago</h3>
                        <p class="text-3xl font-bold text-gray-800 mb-2"> 80.000 Gs.</p>
                        <p class="text-sm text-gray-500 mb-4">por mes</p>
                        <ul class="text-sm text-gray-600 space-y-1">
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
                    Siguiente
                </button>
            @else
                <button type="submit"
                        class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors">
                    Completar registro
                </button>
            @endif
        </div>
    </form>

    <!-- Mensaje de éxito -->
    @if (session()->has('success'))
        <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif
</div>