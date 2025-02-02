<div class="p-6 dark:bg-primary dark:text-white">
    <h1 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">Descargador de YouTube</h1>

    <!-- Campo de URL -->
    <div class="mb-4">
        <label for="url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">URL del video:</label>
        <input type="text" id="url" wire:model="url" placeholder="https://www.youtube.com/..."
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
    </div>

    <!-- Selección del tipo de descarga -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tipo de descarga:</label>
        <div class="flex space-x-6">
            <label class="inline-flex items-center cursor-pointer hover:opacity-75 transition-opacity">
                <input type="radio" wire:model="downloadType" value="video"
                    class="form-radio h-5 w-5 text-green-600 dark:bg-gray-700 focus:ring-green-500 dark:focus:ring-green-600 border-gray-300 dark:border-gray-600">
                <span class="ml-2 text-gray-700 dark:text-gray-300 font-medium">
                    <i class="fas fa-video mr-1"></i> Video (MP4)
                </span>
            </label>
            <label class="inline-flex items-center cursor-pointer hover:opacity-75 transition-opacity">
                <input type="radio" wire:model="downloadType" value="audio"
                    class="form-radio h-5 w-5 text-green-600 dark:bg-gray-700 focus:ring-green-500 dark:focus:ring-green-600 border-gray-300 dark:border-gray-600">
                <span class="ml-2 text-gray-700 dark:text-gray-300 font-medium">
                    <i class="fas fa-music mr-1"></i> Audio (MP3)
                </span>
            </label>
        </div>
    </div>

    <!-- Botón de descarga -->
    <div class="flex space-x-4 mb-4">
        <button wire:click="download" wire:loading.attr="disabled"
            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-800 disabled:opacity-50">
            <span wire:loading.remove>Descargar</span>
            <span wire:loading>
                <svg class="animate-spin h-5 w-5 mr-3" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                Descargando...
            </span>
        </button>
    </div>

    <!-- Mensajes -->
    @if(session()->has('message'))
        <div class="p-3 mb-4 text-green-800 bg-green-100 dark:bg-green-200 rounded">
            ✔️ {{ session('message') }}
        </div>
    @endif

    @if(session()->has('error'))
        <div class="p-3 mb-4 text-red-800 bg-red-100 dark:bg-red-200 rounded">
            ❌ {{ session('error') }}
        </div>
    @endif
</div>