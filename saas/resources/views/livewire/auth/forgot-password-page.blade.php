<div class="flex items-center justify-center min-h-screen bg-gray-50">
    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4 text-center">Recupera Password</h2>

        @if (session('success'))
            <div class="mb-4 text-sm text-green-700 bg-green-100 border border-green-200 rounded-md p-3">
                {{ session('success') }}
            </div>
        @endif

        <form wire:submit.prevent="sendResetLink">
            <div class="mb-3">
                <label for="email" class="block mb-1 text-sm font-medium text-gray-700">Email</label>
                <input wire:model="email" id="email" type="email"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('email')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit"
                class="w-full px-4 py-2 mt-2 text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                Invia link di reset
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline">
                Torna al login
            </a>
        </div>
    </div>
</div>
