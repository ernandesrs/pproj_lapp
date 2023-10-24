<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TraitApiController;
use App\Http\Requests\Account\UserStoreRequest;
use App\Http\Requests\Account\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use TraitApiController;

    /**
     * Users list
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $users = (new \App\Filters\UserFilter($request))->filter();

        return $this->success([
            'users' => $this->resourceCollection(UserResource::class, $users)
        ]);
    }

    /**
     * Store
     *
     * @param UserStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserStoreRequest $request)
    {
        $this->authorize('create', User::class);

        $user = (new UserService)->register($request->validated());

        return $this->success([
            'user' => $this->resource(UserResource::class, $user)
        ]);
    }

    /**
     * Show
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        return $this->success([
            'user' => $this->resource(UserResource::class, $user)
        ]);
    }

    /**
     * Update
     *
     * @param UserUpdateRequest $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $this->authorize('update', $user);

        return $this->success([
            'user' => (new UserService)->update($user, $request->validated())
        ]);
    }

    /**
     * Destroy
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        (new UserService)->delete($user);

        return $this->success();
    }

    /**
     * Photo delete
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function photoDelete(User $user)
    {
        $this->authorize('update', $user);

        if (is_null($user->photo))
            return $this->fail();

        (new UserService)->photoDelete($user);
        return $this->success();
    }

    /**
     * Add role to user
     *
     * @param User $user
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function addRole(User $user, Role $role)
    {
        $this->authorize('updateRole', $user);

        if ($user->roles()->where('id', $role->id)->count() == 0) {
            $user->roles()->attach($role->id);
        }

        return $this->success();
    }

    /**
     * Remove role from user
     *
     * @param User $user
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeRole(User $user, Role $role)
    {
        $this->authorize('updateRole', $user);

        if ($user->roles()->where('id', $role->id)->count()) {
            $user->roles()->detach($role->id);
        }

        return $this->success();
    }
}