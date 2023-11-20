<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->permission("viewAny", User::class);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return $user->permission("view", $model::class);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->permission("create", User::class);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        // super user edit all
        if ($user->isSuperUser()) {
            return true;
        }

        // is admin, and admin not edit super user
        if ($model->isSuperUser()) {
            return false;
        }

        // is admin, and admin edit admin if has permission
        if ($model->isAdmin()) {
            return $user->permission('edit_admins', $model::class);
        }

        return $user->permission('update', $model::class);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        if ($user->id == $model->id) {
            return false;
        }

        // super user edit all
        if ($user->isSuperUser()) {
            return true;
        }

        // is admin, and admin not edit super user
        if ($model->isSuperUser()) {
            return false;
        }

        // is admin, and admin edit admin if has permission
        if ($model->isAdmin()) {
            return $user->permission('delete_admins', $model::class);
        }

        return $user->permission('delete', $model::class);
    }

    /**
     * Determine whether the user can update role the model.
     */
    public function updateRole(User $user): bool
    {
        if (\Auth::user()->id == $user->id) {
            return false;
        }

        return $user->isSuperUser();
    }
}
