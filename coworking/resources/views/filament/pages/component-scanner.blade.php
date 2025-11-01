<x-filament::page class=" bg-white/80 dark:bg-gray-600">
    <div class="flex justify-between items-center mb-6 bg-white/90 dark:bg-gray-800">
        <h2 class="text-xl font-bold text-white dark:text-white">🧩 Component Scanner Progress</h2>

        <x-filament::button wire:click="refreshScan" color="primary">
            🔄 Rigenera scansione
        </x-filament::button>
    </div>

    <div class="p-4 rounded-2xl bg-white/90 dark:bg-gray-800 shadow-md space-y-4">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
            🧩 Component Scanner Report
        </h2>

        @if (empty($this->components))
            <div class="p-4 text-sm text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg">
                Nessun file JSON trovato o nessun componente rilevato.<br>
                Esegui <code>php artisan filament:scan</code> per generarlo.
            </div>
        @else
            <table class="min-w-full text-sm border border-gray-300 dark:border-gray-700 rounded-lg overflow-hidden">
                <thead class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                    <tr>
                        <th class="px-3 py-2 text-left">🧩 Componente</th>
                        <th class="px-3 py-2 text-left">🔖 Campo</th>
                        <th class="px-3 py-2 text-left">📁 File</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-600 bg-gray-50 dark:bg-gray-800">
                    @foreach ($this->components as $component)
                        <tr>
                            <td class="px-3 py-2 text-gray-900 dark:text-gray-100">{{ $component['component'] }}</td>
                            <td class="px-3 py-2 text-gray-900 dark:text-gray-100">{{ $component['field'] }}</td>
                            <td class="px-3 py-2 text-gray-600 dark:text-gray-400">{{ $component['file'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-filament::page>
