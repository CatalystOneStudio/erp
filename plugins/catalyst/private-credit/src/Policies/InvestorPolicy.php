<?php

namespace Catalyst\PrivateCredit\Policies;

use App\Models\User; // Assuming User model is in App\Models
use Catalyst\PrivateCredit\Models\Investor;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvestorPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_investor');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Investor $investor): bool
    {
        return $user->can('view_investor');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_investor');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Investor $investor): bool
    {
        return $user->can('update_investor');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Investor $investor): bool
    {
        return $user->can('delete_investor');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Investor $investor): bool
    {
        return $user->can('restore_investor');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Investor $investor): bool
    {
        return $user->can('force_delete_investor');
    }
}
