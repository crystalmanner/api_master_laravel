<?php

namespace FreshinUp\ActivityApi\Resources;

use FreshinUp\FreshBusForms\Http\Resources\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
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
            'scheduled_at' => $this->scheduled_at->format('Y-m-d H:i:s'),
            'status' => new StatusResource($this->whenLoaded('status')),
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'type' => new TypeResource($this->whenLoaded('type')),
            'type_id' => $this->type_id,
            'salesrep' => new User($this->whenLoaded('salesrep')),
            'notes' => NoteResource::collection($this->notes()->get()),
            'activity_reminder_unity' =>
                new ReminderUnityResource($this->whenLoaded('activityReminderUnity')),
            'activity_reminder_unity_id' => $this->activity_reminder_unity_id,
            'activity_reminder_quantity' => $this->activity_reminder_quantity,
            'has_activity_reminder' => $this->has_activity_reminder,
            'title' => $this->title,
            'deal_uuid' => $this->deals_deal_uuid,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
