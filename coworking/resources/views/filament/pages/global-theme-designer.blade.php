<x-filament::page>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-white dark:text-white">🎨 Filament Advanced Theme Designer</h2>

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

    <div class="bg-white/95 dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-600">
        <div class="mb-8">
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-3 flex items-center">
                <span class="text-2xl mr-3">🎨</span>
                Personalizzazione Stili Filament v4
            </h3>
            <div class="bg-blue-50 dark:bg-blue-900/30 rounded-lg p-4 border border-blue-200 dark:border-blue-700">
                <p class="text-sm text-blue-800 dark:text-blue-200 leading-relaxed">
                    <span class="font-semibold">🎯 Come funziona:</span> Ogni componente ha una lista completa di
                    selettori CSS che verranno tutti stilizzati con le tue regole.
                    Gli stili vengono applicati globalmente con alta priorità (!important) per sovrascrivere i temi
                    predefiniti di Filament.
                </p>
                {{-- <p class="text-xs text-blue-700 dark:text-blue-300 mt-2">
                    📚 Documentazione ufficiale:
                    <a href="https://filamentphp.com/docs/4.x/styling/css-hooks" target="_blank"
                        class="underline hover:no-underline">
                        CSS Hooks Filament v4
                    </a>
                </p> --}}
            </div>
        </div>

        {{-- Statistiche rapide
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            @php
                $totalComponents = count($this->componentStyles);
                $customizedComponents = collect($this->componentStyles)
                    ->filter(function ($comp) {
                        return !empty(trim($comp['css']));
                    })
                    ->count();
                $totalSelectors = collect($this->componentStyles)->sum(function ($comp) {
                    return count($comp['selectors']);
                });
                $averageSelectors = round($totalSelectors / $totalComponents, 1);
            @endphp

            <div
                class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/50 dark:to-blue-800/50 rounded-lg p-4 border border-blue-200 dark:border-blue-700">
                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $totalComponents }}</div>
                <div class="text-sm text-blue-800 dark:text-blue-300">Componenti totali</div>
            </div>

            <div
                class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/50 dark:to-green-800/50 rounded-lg p-4 border border-green-200 dark:border-green-700">
                <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $customizedComponents }}</div>
                <div class="text-sm text-green-800 dark:text-green-300">Personalizzati</div>
            </div>

            <div
                class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/50 dark:to-purple-800/50 rounded-lg p-4 border border-purple-200 dark:border-purple-700">
                <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $totalSelectors }}</div>
                <div class="text-sm text-purple-800 dark:text-purple-300">Selettori totali</div>
            </div>

            <div
                class="bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/50 dark:to-orange-800/50 rounded-lg p-4 border border-orange-200 dark:border-orange-700">
                <div class="text-2xl font-bold text-orange-600 dark:text-orange-400">{{ $averageSelectors }}</div>
                <div class="text-sm text-orange-800 dark:text-orange-300">Media per componente</div>
            </div>
        </div> --}}

        {{-- Filtro di ricerca --}}
        <div class="mb-6">
            <div class="relative">
                <input type="text" id="component-search"
                    placeholder="🔍 Cerca componenti per nome, descrizione o selettore CSS..."
                    class="w-full px-4 py-3 pl-10 pr-4 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="space-y-8" id="components-list">
            @foreach ($this->componentStyles as $key => $component)
                <div class="component-item bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-600 overflow-hidden"
                    data-component-name="{{ strtolower($component['label']) }}"
                    data-component-description="{{ strtolower($component['description']) }}"
                    data-component-selectors="{{ strtolower(implode(' ', $component['selectors'])) }}">
                    {{-- Header della sezione --}}
                    <div
                        class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-600 px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-bold text-gray-800 dark:text-gray-100 text-lg flex items-center">
                                    <span class="text-2xl mr-3">🧩</span>
                                    {{ $component['label'] }}
                                </h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 ml-10">
                                    {{ $component['description'] }}
                                </p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div
                                    class="text-xs text-gray-500 font-mono bg-blue-100 dark:bg-blue-900/50 px-3 py-1 rounded-full">
                                    {{ count($component['selectors']) }} selettori
                                </div>
                                @if (!empty(trim($component['css'])))
                                    <div
                                        class="text-xs text-green-600 font-semibold bg-green-100 dark:bg-green-900/50 px-3 py-1 rounded-full">
                                        ✅ Personalizzato
                                    </div>
                                @else
                                    <div
                                        class="text-xs text-gray-400 font-semibold bg-gray-100 dark:bg-gray-900/50 px-3 py-1 rounded-full">
                                        📝 Non personalizzato
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Contenuto della sezione --}}
                    <div class="p-6 space-y-6">
                        {{-- Editor CSS --}}
                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                                <span class="text-lg mr-2">🎨</span>
                                Regole CSS personalizzate
                            </label>
                            <textarea wire:model.defer="componentStyles.{{ $key }}.css" rows="5"
                                placeholder="Esempio: background-color: #f3f4f6; border: 2px solid #3b82f6; border-radius: 8px; padding: 8px; color: #1f2937;"
                                class="w-full text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 p-4 resize-none font-mono shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                            </textarea>
                            <div class="mt-2 text-xs text-gray-500 flex items-center">
                                <span class="mr-2">💡</span>
                                <span>Usa proprietà CSS standard. Gli stili verranno applicati con alta priorità
                                    (!important) a tutti i selettori.</span>
                            </div>
                        </div>

                        {{-- Lista selettori --}}
                        <div class="mt-6">
                            <div class="text-sm text-gray-700 dark:text-gray-300 space-y-3">
                                <div class="font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                                    <span class="text-lg mr-2">📋</span>
                                    Selettori CSS utilizzati ({{ count($component['selectors']) }} totali):
                                </div>
                                <div
                                    class="bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 p-4 max-h-48 overflow-y-auto">
                                    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-2">
                                        @foreach ($component['selectors'] as $index => $selector)
                                            <div
                                                class="bg-white dark:bg-gray-800 px-3 py-2 rounded border border-gray-200 dark:border-gray-600 shadow-sm hover:shadow-md transition-shadow duration-200">
                                                <div class="flex items-center justify-between">
                                                    <code
                                                        class="text-xs font-mono text-blue-600 dark:text-blue-400 break-all flex-1">
                                                        {{ $selector }}
                                                    </code>
                                                    <span class="text-xs text-gray-400 ml-2 font-sans">
                                                        #{{ $index + 1 }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
            <h4 class="font-medium text-blue-800 dark:text-blue-200 mb-2">💡 Hook Classes Filament v4</h4>
            <ul class="text-sm text-blue-700 dark:text-blue-300 space-y-1">
                <li>• <strong>fi-ac</strong> = Actions package (pulsanti, container, wrapper)</li>
                <li>• <strong>fi-fo</strong> = Forms package (input, textarea, checkbox, radio, toggle)</li>
                <li>• <strong>fi-in</strong> = Infolists package (contenitori, entries)</li>
                <li>• <strong>fi-no</strong> = Notifications package (toast, buttons)</li>
                <li>• <strong>fi-sc</strong> = Schema/Components package (contenitori, wrapper)</li>
                <li>• <strong>fi-ta</strong> = Tables package (table, row, cell, column)</li>
                <li>• <strong>fi-wi</strong> = Widgets package (container, wrapper)</li>
                <li>• <strong>btn, col, ctn, wrp</strong> = abbreviazioni per button, column, container, wrapper</li>
                <li>• Riferimento: <a href="https://filamentphp.com/docs/4.x/styling/css-hooks"
                        class="underline">Documentazione Hook Classes v4</a></li>
            </ul>
        </div>
    </div>
</x-filament::page>

@push('scripts')
    <script>
        console.log('Advanced Theme Designer Script caricato');

        // Funzione di ricerca componenti
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('component-search');
            const componentItems = document.querySelectorAll('.component-item');
            let searchTimeout;

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        const searchTerm = this.value.toLowerCase().trim();

                        componentItems.forEach(item => {
                            const name = item.getAttribute('data-component-name') || '';
                            const description = item.getAttribute(
                                'data-component-description') || '';
                            const selectors = item.getAttribute(
                                'data-component-selectors') || '';

                            const isVisible = searchTerm === '' ||
                                name.includes(searchTerm) ||
                                description.includes(searchTerm) ||
                                selectors.includes(searchTerm);

                            if (isVisible) {
                                item.style.display = 'block';
                                item.style.opacity = '1';
                                item.style.transform = 'translateY(0)';
                            } else {
                                item.style.display = 'none';
                                item.style.opacity = '0';
                                item.style.transform = 'translateY(-10px)';
                            }
                        });

                        // Mostra messaggio se nessun risultato
                        const visibleItems = Array.from(componentItems).filter(item =>
                            item.style.display !== 'none'
                        );

                        let noResultsMsg = document.getElementById('no-results-message');
                        if (visibleItems.length === 0 && searchTerm !== '') {
                            if (!noResultsMsg) {
                                noResultsMsg = document.createElement('div');
                                noResultsMsg.id = 'no-results-message';
                                noResultsMsg.className =
                                    'text-center py-12 text-gray-500 dark:text-gray-400';
                                noResultsMsg.innerHTML = `
                                    <div class="text-6xl mb-4">🔍</div>
                                    <div class="text-lg font-semibold mb-2">Nessun componente trovato</div>
                                    <div class="text-sm">Prova con termini di ricerca diversi</div>
                                `;
                                document.getElementById('components-list').appendChild(
                                    noResultsMsg);
                            }
                            noResultsMsg.style.display = 'block';
                        } else if (noResultsMsg) {
                            noResultsMsg.style.display = 'none';
                        }
                    }, 300);
                });
            }
        });

        // Listener per aggiornamento preview in tempo reale
        document.addEventListener('input', function(e) {
            if (e.target.matches('textarea[wire\\:model\\.defer*="componentStyles"]')) {
                const key = e.target.getAttribute('wire:model.defer').match(/componentStyles\.(.+?)\.css/)[1];
                const css = e.target.value;

                // Applica il CSS alla preview se esiste
                const previewContainer = document.querySelector(`.preview-${key}`);
                if (previewContainer) {
                    // Rimuovi style precedente se esiste
                    const existingStyle = document.getElementById(`preview-style-${key}`);
                    if (existingStyle) {
                        existingStyle.remove();
                    }

                    // Crea nuovo style
                    const style = document.createElement('style');
                    style.id = `preview-style-${key}`;
                    style.innerHTML = `.preview-${key} * { ${css} }`;
                    document.head.appendChild(style);
                }
            }
        });

        // Backup listener per eventi Livewire
        document.addEventListener('livewire:init', () => {
            console.log('Livewire inizializzato per Advanced Theme Designer');

            Livewire.on('reload-page', (event) => {
                console.log('Evento reload-page ricevuto:', event);
                setTimeout(() => {
                    console.log('Ricaricamento pagina...');
                    window.location.reload();
                }, 500);
            });
        });
    </script>
@endpush
