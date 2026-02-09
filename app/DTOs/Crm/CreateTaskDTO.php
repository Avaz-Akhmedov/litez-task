<?php

namespace App\DTOs\Crm;

use App\Enums\Crm\RecurrenceType;
use App\Enums\Crm\TaskPriority;
use App\Enums\Crm\TaskType;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

readonly class CreateTaskDTO
{
    public function __construct(
        public TaskType $type,
        public string $title,
        public TaskPriority $priority,
        public Carbon $deadline,
        public ?int $clientId,
        public ?string $description,
        public ?bool $isRecurring,
        public ?RecurrenceType $recurrenceType,
        public ?int $remindBeforeMinutes,
        public ?string $remindVia,
    ) {
    }

    public static function fromRequest(FormRequest $request): self
    {
        return new self(
            type: TaskType::from($request->validated('type')),
            title: $request->validated('title'),
            priority: TaskPriority::from($request->validated('priority')),
            deadline: Carbon::parse($request->validated('deadline')),
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
        return [
            'type' => $this->type->value,
            'title' => $this->title,
            'priority' => $this->priority->value,
            'deadline' => $this->deadline,
            'client_id' => $this->clientId,
            'description' => $this->description,
            'is_recurring' => $this->isRecurring,
            'recurrence_type' => $this->recurrenceType?->value,
            'remind_before_minutes' => $this->remindBeforeMinutes,
            'remind_via' => $this->remindVia,
        ];
    }
}
