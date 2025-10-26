<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Login – Coworking Anywhere</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <form method="POST" action="{{ route('login.perform') }}" class="bg-white p-6 rounded-lg shadow-md w-80">
        @csrf
        <h1 class="text-2xl font-bold text-center mb-4">Coworking Anywhere</h1>
        <input type="email" name="email" placeholder="Email" class="w-full border rounded p-2 mb-3" required autofocus>
        <input type="password" name="password" placeholder="Password" class="w-full border rounded p-2 mb-3" required>
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
            Accedi
        </button>
        @error('email')
            <p class="text-red-600 text-sm mt-2 text-center">{{ $message }}</p>
        @enderror
    </form>
</body>

</html>
