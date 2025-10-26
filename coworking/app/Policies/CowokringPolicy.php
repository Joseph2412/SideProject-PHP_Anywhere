<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Coworking;

class CoworkingPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'host']);
    }

    public function view(User $user, Coworking $coworking): bool
    {
        return $user->role === 'admin' || $coworking->host_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->role === 'host';
    }

    public function update(User $user, Coworking $coworking): bool
    {
        return $user->role === 'host' && $coworking->host_id === $user->id;
    }

    public function delete(User $user, Coworking $coworking): bool
    {
        return $user->role === 'host' && $coworking->host_id === $user->id;
    }
}
