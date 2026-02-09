<?php

namespace App\Http\Resources\Crm;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'title' => $this->title,
            'description' => $this->description,
            'priority' => $this->priority,
            'status' => $this->status,
            'deadline' => $this->deadline?->toDateTimeString(),
            'is_recurring' => $this->is_recurring,
            'recurrence_type' => $this->recurrence_type,
            'remind_before_minutes' => $this->remind_before_minutes,
            'remind_via' => $this->remind_via,
            'reminder_sent_at' => $this->reminder_sent_at?->toDateTimeString(),
            'completed_at' => $this->completed_at?->toDateTimeString(),
            'created_at' => $this->created_at?->toDateTimeString(),
            'user' => UserResource::make($this->whenLoaded('user')),
            'client' => ClientResource::make($this->whenLoaded('client'))
        ];
    }
}
