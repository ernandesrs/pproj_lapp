<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TraitApiController;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    use TraitApiController;

    /**
     * Index
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->success();
    }
}