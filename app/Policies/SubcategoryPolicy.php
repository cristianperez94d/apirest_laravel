<?php

namespace App\Policies;

use App\User;
use App\Subcategory;
use App\Traits\AdminActions;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubcategoryPolicy
{
    use HandlesAuthorization, AdminActions;

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function storeSubcategory(User $user)
    {
        return $user->admin === User::USER_ADMIN;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Subcategory  $subcategory
     * @return mixed
     */
    public function updateSubcategory(User $user, Subcategory $subcategory)
    {
        return $user->admin === User::USER_ADMIN;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Subcategory  $subcategory
     * @return mixed
     */
    public function destroySubcategory(User $user, Subcategory $subcategory)
    {
        return $user->admin === User::USER_ADMIN;
    }

}
