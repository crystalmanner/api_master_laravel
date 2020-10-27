<?php

namespace FreshinUp\ActivityApi\Resources;

use FreshinUp\ActivityApi\Models\Type;
use Illuminate\Http\Resources\Json\JsonResource;

class TypeResource extends JsonResource
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
        if (!is_a($resource, Type::class)) {
            $this->resource = Type::find($resource);
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
