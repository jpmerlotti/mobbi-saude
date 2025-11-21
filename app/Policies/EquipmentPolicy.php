<?php

namespace App\Policies;

use App\Models\Equipment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EquipmentPolicy
{

    public function before(User $user): null|bool
    {
        return $user->isAdmin() ? true : null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Equipment $equipment): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasCompletedProfile();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Equipment $equipment): bool
    {
        return $user->id === $equipment->owner_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Equipment $equipment): bool
    {
        return $user->id === $equipment->owner_id;
    }
}
