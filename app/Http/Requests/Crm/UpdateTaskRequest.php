<?php

namespace App\Http\Requests\Crm;

use App\Enums\Crm\RecurrenceType;
use App\Enums\Crm\TaskPriority;
use App\Enums\Crm\TaskType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateTaskRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'type' => ['sometimes', 'string', new Enum(TaskType::class)],
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'priority' => ['sometimes', 'string', new Enum(TaskPriority::class)],
            'client_id' => ['nullable', 'integer', 'exists:clients,id'],
            'deadline' => ['sometimes', 'date'],

            'is_recurring' => ['boolean'],
            'recurrence_type' => [
                'nullable',
                'required_if:is_recurring,true',
                new Enum(RecurrenceType::class)
            ],

            'remind_before_minutes' => ['nullable', 'integer', 'min:1'],
            'remind_via' => ['nullable', 'string', 'in:email,sms'],
        ];
    }
}
