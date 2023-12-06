<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
        // return parent::toArray($request);
        return [
            'id' => $this->resource->id,
            'type' => str_replace('\\', '_', $this->resource->type),
            'read_at' => $this->resource->read_at,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            'data' => array_merge($this->resource->data, [
            ])
        ];
    }
}
