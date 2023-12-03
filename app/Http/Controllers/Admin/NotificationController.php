<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TraitApiController;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use TraitApiController;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->success([
            'notifications' => \Auth::user()->notifications,
            'unread_notifications' => \Auth::user()->unreadNotifications
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
