<?php

namespace FreshinUp\ActivityApi\Resources;

use FreshinUp\FreshBusForms\Http\Resources\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'status_name' => $this->status_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'text' => $this->text,
            'activity_uuid' => $this->activity_uuid
        ];
    }
}
