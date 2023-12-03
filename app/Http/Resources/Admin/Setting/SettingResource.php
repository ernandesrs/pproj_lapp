<?php

namespace App\Http\Resources\Admin\Setting;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_merge(
            parent::toArray($request),
            [
                'setting_errors' => $this->settingErrors()->get(),
                'email_senders' => \App\Http\Resources\Admin\Setting\EmailSenderResource::collection($this->emailSenders()->get()),
            ]
        );
    }
}
