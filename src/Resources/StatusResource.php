<?php

namespace FreshinUp\ActivityApi\Resources;

use FreshinUp\ActivityApi\Models\Status;
use Illuminate\Http\Resources\Json\JsonResource;

class StatusResource extends JsonResource
{
    /**
     * Create a new resource instance.
     *
     * @param mixed $resource
     * @return void
     */
    public function __construct($resource)
    {
        parent::__construct($resource);
        // somehow the resource comes sometimes in plain string of the id.
        // Maybe because of serialization and deserialization
        // The 3 lines belows as workaround
        if (!is_a($resource, Status::class)) {
            $this->resource = Status::find($resource);
        }
    }

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
