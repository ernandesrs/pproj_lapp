<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TraitApiController;
use App\Http\Requests\Account\ForgetRequest;
use Illuminate\Http\Request;

class ForgetController extends Controller
{
    use TraitApiController;

    /**
     * Forget password: send update password link
     *
     * @param ForgetRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forget(ForgetRequest $request)
    {
        $user = \App\Models\User::where('email', $request->get('email'))->first();

        $reset = \App\Models\Account\PasswordReset::where('email', $user->email);
        if ($reset->count()) {
            $reset->delete();
        }

        $reset = \App\Models\Account\PasswordReset::create([
            'email' => $user->email,
            'token' => \Illuminate\Support\Str::random(50)
        ]);

        event(new \App\Events\Account\ForgetPasswordEvent($user, $reset));

        return $this->success();
    }

    public function update()
    {

    }
}