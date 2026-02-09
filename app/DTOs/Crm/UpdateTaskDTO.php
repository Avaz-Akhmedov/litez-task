<?php

namespace App\DTOs\Crm;

use App\Enums\Crm\RecurrenceType;
use App\Enums\Crm\TaskPriority;
use App\Enums\Crm\TaskType;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

readonly class UpdateTaskDTO
{
    public function __construct(
        public ?TaskType $type = null,
        public ?string $title = null,
        public ?TaskPriority $priority = null,
        public ?Carbon $deadline = null,
        public ?int $clientId = null,
        public ?string $description = null,
        public ?bool $isRecurring = null,
        public ?RecurrenceType $recurrenceType = null,
        public ?int $remindBeforeMinutes = null,
        public ?string $remindVia = null,
    ) {
    }

    public static function fromRequest(FormRequest $request): self
    {
        return new self(
            type: $request->has('type') ? TaskType::from($request->validated('type')) : null,
            title: $request->validated('title'),
            priority: $request->has('priority') ? TaskPriority::from($request->validated('priority')) : null,
            deadline: $request->has('deadline') ? Carbon::parse($request->validated('deadline')) : null,
            clientId: $request->validated('client_id'),
            description: $request->validated('description'),
            isRecurring: $request->has('is_recurring') ? (bool) $request->validated('is_recurring') : null,
            recurrenceType: $request->has('recurrence_type')
                ? RecurrenceType::from($request->validated('recurrence_type'))
                : null,
            remindBeforeMinutes: $request->validated('remind_before_minutes'),
            remindVia: $request->validated('remind_via'),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'type' => $this->type?->value,
            'title' => $this->title,
            'priority' => $this->priority?->value,
            'deadline' => $this->deadline,
            'client_id' => $this->clientId,
            'description' => $this->description,
            'is_recurring' => $this->isRecurring,
            'recurrence_type' => $this->recurrenceType?->value,
            'remind_before_minutes' => $this->remindBeforeMinutes,
            'remind_via' => $this->remindVia,
        ], fn ($value) => !is_null($value));
    }
}
