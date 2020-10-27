<?php

namespace FreshinUp\ActivityApi\Resources;

use FreshinUp\ActivityApi\Models\ReminderUnit;
use Illuminate\Http\Resources\Json\JsonResource;

class ReminderUnityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
