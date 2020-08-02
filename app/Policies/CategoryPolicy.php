<?php

namespace App\Policies;

use App\User;
use App\Category;
use App\Traits\AdminActions;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization, AdminActions;


    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function storeCategory(User $user)
    {
        return $user->admin === User::USER_ADMIN;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Category  $category
     * @return mixed
     */
    public function updateCategory(User $user, Category $category)
    {
        return $user->admin === User::USER_ADMIN;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Category  $category
     * @return mixed
     */
    public function destroyCategory(User $user, Category $category)
    {
        return $user->admin === User::USER_ADMIN;
    }

}
