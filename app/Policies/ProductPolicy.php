<?php

namespace App\Policies;

use App\User;
use App\Product;
use App\Traits\AdminActions;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization, AdminActions;

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function storeProduct(User $user)
    {
        return $user->admin === User::USER_ADMIN;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Product  $product
     * @return mixed
     */
    public function updateProduct(User $user, Product $product)
    {
        return $user->admin === User::USER_ADMIN;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Product  $product
     * @return mixed
     */
    public function destroyProduct(User $user, Product $product)
    {
        return $user->admin === User::USER_ADMIN; 
    }

}
