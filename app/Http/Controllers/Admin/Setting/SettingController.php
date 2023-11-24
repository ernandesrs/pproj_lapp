<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TraitApiController;
use App\Http\Resources\Admin\Setting\SettingResource;
use App\Models\Setting\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use TraitApiController;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->success([
            'setting' => $this->resource(SettingResource::class, Setting::first())
        ]);
    }
}
