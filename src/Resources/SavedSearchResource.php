<?php

namespace FreshinUp\ActivityApi\Resources;

use FreshinUp\ActivityApi\Models\Modifier;
use Illuminate\Http\Resources\Json\JsonResource;

class SavedSearchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @param mixed $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'filters' => json_decode($this->filters),
            'modifiers' => $this->modifiers(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
