<?php

namespace App\Policies;

use App\Photo;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PhotoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function storePhoto(User $user)
    {
        return $user->admin === User::USER_ADMIN;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Photo  $photo
     * @return mixed
     */
    public function updatePhoto(User $user, Photo $photo)
    {
        return $user->admin === User::USER_ADMIN;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Photo  $photo
     * @return mixed
     */
    public function destroyPhoto(User $user, Photo $photo)
    {
        return $user->admin === User::USER_ADMIN;
    }

}
