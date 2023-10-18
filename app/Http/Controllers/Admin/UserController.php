<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TraitApiController;
use App\Http\Requests\Account\RegisterRequest;
use App\Http\Resources\UserResource;
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
        $users = (new \App\Filters\UserFilter($request))->filter();

        return $this->success([
            'users' => $this->resourceCollection(UserResource::class, $users)
        ]);
    }

    /**
     * Store
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RegisterRequest $request)
    {
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
        return $this->success([
            'user' => $this->resource(UserResource::class, $user)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}