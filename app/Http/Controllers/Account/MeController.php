<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TraitApiController;
use App\Http\Requests\Account\UpdatePasswordRequest;
use App\Http\Requests\Account\UserUpdateRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class MeController extends Controller
{
    use TraitApiController;

    /**
     * Me
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return $this->success([
            'me' => \Auth::user()
        ]);
    }

    /**
     * Update
     *
     * @param UserUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserUpdateRequest $request)
    {
        return $this->success([
            'me' => (new UserService)->update(\Auth::user(), $request->validated())
        ]);
    }

    /**
     * Update password
     *
     * @param UpdatePasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        (new UserService)->update(\Auth::user(), $request->validated());

        return $this->success();
    }
}