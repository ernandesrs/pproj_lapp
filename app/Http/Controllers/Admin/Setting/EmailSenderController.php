<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TraitApiController;
use App\Http\Resources\Admin\Setting\EmailSenderResource;
use App\Models\Setting\EmailSender;
use Illuminate\Http\Request;

class EmailSenderController extends Controller
{
    use TraitApiController;

    /**
     * Get email senders
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->success([
            'email_senders' => $this->resourceCollection(
                EmailSenderResource::class,
                EmailSender::all()
            )
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
