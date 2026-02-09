<?php

namespace App\Http\Requests\Catalog;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' =>
                [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('categories')->where(function ($query) {
                        return $query->where('parent_id', $this->parent_id);
                    })
                ],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['boolean'],
            'parent_id' => ['nullable', 'exists:categories,id']
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->has('is_active') ? $this->is_active : true
        ]);
    }
}
