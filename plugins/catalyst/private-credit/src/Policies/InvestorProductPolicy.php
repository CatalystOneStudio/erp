<?php

namespace Catalyst\PrivateCredit\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Catalyst\PrivateCredit\Models\InvestorProduct;
use App\Models\User; // Assuming User model is in App\Models

class InvestorProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_investor::product');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, InvestorProduct $investorProduct): bool
    {
        return $user->can('view_investor::product');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_investor::product');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, InvestorProduct $investorProduct): bool
    {
        return $user->can('update_investor::product');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, InvestorProduct $investorProduct): bool
    {
        return $user->can('delete_investor::product');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, InvestorProduct $investorProduct): bool
    {
        return $user->can('restore_investor::product');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, InvestorProduct $investorProduct): bool
    {
        return $user->can('force_delete_investor::product');
    }
}
