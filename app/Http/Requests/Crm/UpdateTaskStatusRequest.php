<?php

namespace App\Http\Requests\Crm;

use App\Enums\Crm\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateTaskStatusRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'status' => ['required','string',new Enum(TaskStatus::class)]
        ];
    }
}
