<?php

namespace App\Http\Requests\Catalog;

use Illuminate\Foundation\Http\FormRequest;

class FilterProductRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'search' =>['nullable','string','max:255'],
            'category_id' =>['nullable','integer','exists:categories,id'],
            'price_min' => ['nullable', 'numeric', 'min:0'],
            'price_max' => ['nullable', 'numeric', 'min:0', 'gte:price_min'],
        ];
    }
}
