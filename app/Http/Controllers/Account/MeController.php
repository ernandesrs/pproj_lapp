<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TraitApiController;
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
}