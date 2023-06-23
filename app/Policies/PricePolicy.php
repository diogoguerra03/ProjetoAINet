<?php

namespace App\Policies;

use App\Models\Price;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PricePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Price $price): bool
    {
        return true;
    }


    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Price $price): bool
    {
        return $user->user_type === 'A';
    }

}