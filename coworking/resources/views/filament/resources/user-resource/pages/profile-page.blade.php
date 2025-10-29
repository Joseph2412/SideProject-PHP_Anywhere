<x-filament::page>
    <h2>Profilo utente</h2>
    <p>Nome: {{ $user->name ?? auth()->user()->name }}</p>
    <p>Email: {{ $user->email ?? auth()->user()->email }}</p>
    <p>Ruolo: {{ $user->role ?? auth()->user()->role }}</p>
</x-filament::page>
