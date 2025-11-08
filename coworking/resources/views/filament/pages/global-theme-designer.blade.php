<x-filament::page>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-white dark:text-white">🎨 Filament Theme Designer</h2>

        <div class="flex gap-2">
            <x-filament::button wire:click="saveStyles" color="success">
                💾 Salva Tema
            </x-filament::button>

            <x-filament::button wire:click="clearStyles" color="danger">
                🗑️ Reset Tema
            </x-filament::button>
        </div>
    </div>

    {{-- Sezione Preset Veloci --}}
    <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-900 rounded-xl">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-3">⚡ Preset Veloci</h3>
        <div class="flex gap-3">
            <x-filament::button wire:click="applyPreset('dark-mode')" color="gray" size="sm">
                🌙 Dark Mode
            </x-filament::button>
            <x-filament::button wire:click="applyPreset('colorful')" color="warning" size="sm">
                🌈 Colorful
            </x-filament::button>
            <x-filament::button wire:click="applyPreset('minimal')" color="info" size="sm">
                ⚪ Minimal
            </x-filament::button>
        </div>
    </div>

    <div class="bg-white/90 dark:bg-gray-800 rounded-xl shadow-md p-6">
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">
                � Personalizzazione Stili Filament
            </h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Personalizza l'aspetto dei componenti seguendo le
                <a href="https://filamentphp.com/docs/3.x/support/style-customization" target="_blank"
                    class="text-primary-600 hover:text-primary-500">
                    linee guida ufficiali di Filament
                </a>.
            </p>
        </div>

        <div class="space-y-6">
            @foreach ($this->componentStyles as $key => $component)
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-5 border border-gray-200 dark:border-gray-600">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h4 class="font-medium text-gray-800 dark:text-gray-100 text-lg">
                                🧩 {{ $component['label'] }}
                            </h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                {{ $component['description'] }}
                            </p>
                        </div>
                        <div class="text-xs text-gray-500 font-mono bg-gray-200 dark:bg-gray-600 px-2 py-1 rounded">
                            {{ count($component['selectors']) }} selettori
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                🎨 Regole CSS
                            </label>
                            <textarea wire:model.defer="componentStyles.{{ $key }}.css" rows="4"
                                placeholder="Es: background-color: #f3f4f6; border: 2px solid #3b82f6; border-radius: 8px; padding: 8px;"
                                class="w-full text-sm rounded-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 p-3 resize-none font-mono">
                            </textarea>
                        </div>

                        <div class="flex justify-between items-start">
                            <div class="text-xs text-gray-500 space-y-1">
                                <div><strong>Selettori CSS utilizzati:</strong></div>
                                @foreach (array_slice($component['selectors'], 0, 3) as $selector)
                                    <div><code>{{ $selector }}</code></div>
                                @endforeach
                                @if (count($component['selectors']) > 3)
                                    <div class="text-gray-400">... e altri {{ count($component['selectors']) - 3 }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
            <h4 class="font-medium text-blue-800 dark:text-blue-200 mb-2">� Best Practices Filament</h4>
            <ul class="text-sm text-blue-700 dark:text-blue-300 space-y-1">
                <li>• Usa le classi CSS ufficiali di Filament come base (fi-*, tw-*)</li>
                <li>• Testa sempre in modalità chiara e scura</li>
                <li>• Mantieni la consistenza con il design system</li>
                <li>• Evita di sovrascrivere completamente gli stili esistenti</li>
                <li>• Riferimento: <a href="https://filamentphp.com/docs/3.x/support/style-customization"
                        class="underline">Documentazione ufficiale</a></li>
            </ul>
        </div>
    </div>
</x-filament::page>

@push('scripts')
    <script>
        console.log('Theme Designer Script caricato');

        // Backup listener per eventi Livewire (se necessario)
        document.addEventListener('livewire:init', () => {
            console.log('Livewire inizializzato per Theme Designer');

            Livewire.on('reload-page', (event) => {
                console.log('Evento reload-page ricevuto!');
                setTimeout(() => {
                    console.log('Ricaricando la pagina...');
                    window.location.reload();
                }, 1000);
            });
        });
    </script>
@endpush
