<?php

namespace App\Http\Requests\Crm;

use App\Enums\Crm\RecurrenceType;
use App\Enums\Crm\TaskPriority;
use App\Enums\Crm\TaskType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreTaskRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', new Enum(TaskType::class)],
            'priority' => ['required', new Enum(TaskPriority::class)],
            'client_id' => ['nullable', 'exists:clients,id'],
            'deadline' => ['required', 'date'],
            'description' => ['nullable', 'string'],
            'is_recurring' => ['boolean'],
            'recurrence_type' => ['nullable', 'required_if:is_recurring,true', new Enum(RecurrenceType::class)],
            'remind_before_minutes' => ['nullable', 'integer', 'min:1'],
            'remind_via' => ['nullable', 'in:email,sms'],
        ];
    }
}
