<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            {{ $this->getUserData()['greeting'] }}, {{ $this->getUserData()['name'] }}! 👋
        </x-slot>

        <div class="space-y-2">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Benvenuto nella tua dashboard Host
            </p>
            <p class="text-xs text-gray-500 dark:text-gray-500">
                {{ $this->getUserData()['current_time'] }}
            </p>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
