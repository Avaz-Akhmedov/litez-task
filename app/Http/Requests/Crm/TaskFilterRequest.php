<?php

namespace App\Http\Requests\Crm;

use App\Enums\Crm\TaskPriority;
use App\Enums\Crm\TaskStatus;
use App\Enums\Crm\TaskType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class TaskFilterRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'type' => ['nullable', 'string', new Enum(TaskType::class)],
            'priority' => ['nullable', 'string', new Enum(TaskPriority::class)],
            'status' => ['nullable', 'string', new Enum(TaskStatus::class)],
            'client_id' => ['nullable', 'integer', 'exists:clients,id'],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
        ];
    }
}
