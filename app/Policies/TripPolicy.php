<?php

namespace App\Policies;

use App\Models\Trip;
use App\Models\User;

class TripPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'user';
    }

    public function view(User $user, Trip $trip): bool
    {
        return $user->role === 'user' && $trip->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->role === 'user';
    }

    public function update(User $user, Trip $trip): bool
    {
        return $user->role === 'user' && $trip->user_id === $user->id;
    }

    public function delete(User $user, Trip $trip): bool
    {
        return $user->role === 'user' && $trip->user_id === $user->id;
    }
}
