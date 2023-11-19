<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $extras = [
            'photo_url' => $this->resource->photo ? \Storage::url($this->resource->photo) : null,
            'roles' => \App\Http\Resources\RoleResource::collection($this->resource->roles()->get())
        ];

        return array_merge(
            parent::toArray($request),
            $extras
        );
    }
}