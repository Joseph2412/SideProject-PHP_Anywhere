<x-filament::page>
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">🧩 Component Scanner Report</h2>

        <x-filament::button wire:click="refreshScan" color="primary">
            🔄 Rigenera scansione
        </x-filament::button>
    </div>
    <div class="space-y-4">
        <h2 class="text-xl font-bold">🧩 Component Scanner Report</h2>

        @if (empty($this->components))
            <div class="p-4 text-sm text-gray-500 bg-gray-100 rounded-lg">
                Nessun file JSON trovato o nessun componente rilevato.<br>
                Esegui <code>php artisan filament:scan</code> per generarlo.
            </div>
        @else
            <table class="min-w-full text-sm border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-left">🧩 Componente</th>
                        <th class="px-3 py-2 text-left">🔖 Campo</th>
                        <th class="px-3 py-2 text-left">📁 File</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($this->components as $component)
                        <tr>
                            <td class="px-3 py-2">{{ $component['component'] }}</td>
                            <td class="px-3 py-2">{{ $component['field'] }}</td>
                            <td class="px-3 py-2 text-gray-500">{{ $component['file'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</x-filament::page>
