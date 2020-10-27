<?php

namespace FreshinUp\ActivityApi\Resources;

use FreshinUp\FreshBusForms\Http\Resources\User\User;

class CustomerResource extends User
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'pbs_id' => $this->pbs_id
        ]);
    }
}
