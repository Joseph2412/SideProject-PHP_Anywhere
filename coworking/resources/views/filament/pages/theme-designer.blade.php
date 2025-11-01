<x-filament::page>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-white dark:text-white">🎨 Theme Designer</h2>

        <div class="flex gap-2">
            {{-- ⚡ Pulsante opzionale "Applica ora" (prossimo step) --}}
            {{-- <x-filament::button wire:click="applyStyles" color="warning">
                ⚡ Applica ora
            </x-filament::button> --}}

            <x-filament::button wire:click="saveStyles" color="success">
                💾 Salva modifiche
            </x-filament::button>
        </div>
    </div>

    @if (empty($this->groupedComponents))
        <div class="p-4 bg-gray-100 dark:bg-gray-800 rounded-lg text-gray-700 dark:text-gray-300">
            Nessun componente trovato. Esegui prima <code>php artisan filament:scan</code>.
        </div>
    @else
        {{-- Struttura migliorata e compatibile Windows/Linux --}}
        <div x-data="{
            selected: '{{ array_key_first($this->groupedComponents) }}',
            groups: @js(
    collect($this->groupedComponents)
        ->map(
            fn($components, $file) => [
                'file' => basename($file),
                'path' => $file,
                'components' => $components,
            ],
        )
        ->values(),
)
        }" class="flex gap-4">
            {{-- Sidebar sinistra --}}
            <div class="w-64 bg-gray-100 dark:bg-gray-900 rounded-xl p-3 overflow-y-auto h-[80vh] shadow-inner">
                <h3 class="font-semibold mb-3 text-gray-800 dark:text-gray-200">📁 Risorse</h3>

                <template x-for="group in groups" :key="group.path">
                    <button x-on:click="selected = group.path"
                        :class="selected === group.path ?
                            'bg-primary-600 text-white' :
                            'bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-700'"
                        class="w-full text-left px-3 py-2 rounded-lg transition-colors text-sm truncate mb-2"
                        x-text="group.file"></button>
                </template>
            </div>

            {{-- Pannello destro --}}
            <div class="flex-1 p-4 bg-white/90 dark:bg-gray-800 rounded-xl shadow-md overflow-y-auto h-[80vh]">
                <template x-for="group in groups" :key="group.path">
                    <div x-show="selected === group.path" x-transition>
                        <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100 mb-3">
                            📘 <span x-text="group.file"></span>
                        </h3>

                        <table class="w-full text-sm border border-gray-300 dark:border-gray-700 rounded-lg mb-4">
                            <thead class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                                <tr>
                                    <th class="px-3 py-2 text-left">🧩 Componente</th>
                                    <th class="px-3 py-2 text-left">🔖 Campo</th>
                                    <th class="px-3 py-2 text-left w-2/3">🎨 CSS Personalizzato</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-600 bg-gray-50 dark:bg-gray-800">
                                @foreach ($this->groupedComponents as $file => $components)
                                    @if ($selected ?? false)
                                        {{-- filtraggio lato Alpine, lo gestiamo dopo --}}
                                    @endif

                                    @foreach ($components as $component)
                                        @php
                                            $key = md5(
                                                $file .
                                                    '_' .
                                                    ($component['component'] ?? '') .
                                                    '_' .
                                                    ($component['field'] ?? ''),
                                            );
                                        @endphp
                                        <tr>
                                            <td class="px-3 py-2 text-gray-900 dark:text-gray-100">
                                                {{ $component['component'] }}</td>
                                            <td class="px-3 py-2 text-gray-900 dark:text-gray-100">
                                                {{ $component['field'] }}</td>
                                            <td class="px-3 py-2">
                                                <textarea wire:model.defer="styles.{{ $key }}" rows="2"
                                                    placeholder="Esempio: background-color: red; font-size: 14px;"
                                                    class="w-full text-sm rounded-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 p-2"></textarea>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </template>
            </div>
        </div>
    @endif
</x-filament::page>
