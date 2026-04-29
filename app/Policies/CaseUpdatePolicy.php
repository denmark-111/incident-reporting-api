<?php

namespace App\Policies;

use App\Models\CaseUpdate;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CaseUpdatePolicy
{
    // Admin can do everything
    public function before(User $user, $ability): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CaseUpdate $caseUpdate): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CaseUpdate $caseUpdate): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CaseUpdate $caseUpdate): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CaseUpdate $caseUpdate): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CaseUpdate $caseUpdate): bool
    {
        return false;
    }
}
