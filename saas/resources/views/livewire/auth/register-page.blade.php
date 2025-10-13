<div class="flex items-center justify-center min-h-screen bg-gray-50">
    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4 text-center">Registrati</h2>
        <form wire:submit.prevent="register">
            <div class="mb-3">
                <label for="name" class="block mb-1 text-sm font-medium text-gray-700">Nome completo</label>
                <input wire:model="name" id="name" type="text"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('name')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="block mb-1 text-sm font-medium text-gray-700">Email</label>
                <input wire:model="email" id="email" type="email"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('email')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="block mb-1 text-sm font-medium text-gray-700">Password</label>
                <input wire:model="password" id="password" type="password"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('password')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="block mb-1 text-sm font-medium text-gray-700">Conferma
                    Password</label>
                <input wire:model="password_confirmation" id="password_confirmation" type="password"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('password_confirmation')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit"
                class="w-full px-4 py-2 mt-2 text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                Registrati
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline">
                Hai già un account? Accedi
            </a>
        </div>
    </div>
</div>
