<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TraitApiController;
use App\Http\Requests\Admin\Setting\EmailSenderRequest;
use App\Http\Resources\Admin\Setting\EmailSenderResource;
use App\Models\Setting\EmailSender;
use App\Models\Setting\Setting;
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
        $this->authorize("viewAny", Setting::class);

        return $this->success([
            'email_senders' => $this->resourceCollection(
                EmailSenderResource::class,
                Setting::first()->emailSenders()->get()
            )
        ]);
    }

    /**
     * Store
     *
     * @param EmailSenderRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(EmailSenderRequest $request)
    {
        $this->authorize('create', Setting::class);

        return $this->success([
            'email_sender' => $this->resource(
                EmailSenderResource::class,
                Setting::first()->emailSenders()->create($request->validated())
            )
        ]);
    }

    /**
     * Show
     *
     * @param EmailSender $emailSender
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(EmailSender $emailSender)
    {
        $this->authorize('view', Setting::first());

        return $this->success([
            'email_sender' => $this->resource(EmailSenderResource::class, $emailSender)
        ]);
    }

    /**
     * Update
     *
     * @param EmailSenderRequest $request
     * @param EmailSender $emailSender
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(EmailSenderRequest $request, EmailSender $emailSender)
    {
        $this->authorize('update', Setting::first());

        $validated = $request->validated();
        if ($validated['default'] ?? false) {
            $default = Setting::first()->emailSenders(true);
            if ($default) {
                $default->default = false;
                $default->save();
            }
        }

        $emailSender->update($validated);

        return $this->success([
            'email_sender' => $emailSender->fresh()
        ]);
    }

    /**
     * Delete
     *
     * @param EmailSender $emailSender
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(EmailSender $emailSender)
    {
        $this->authorize('delete', Setting::first());

        $emailSender->delete();

        return $this->success();
    }
}
