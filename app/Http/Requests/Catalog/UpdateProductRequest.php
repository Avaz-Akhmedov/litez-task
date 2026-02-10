<?php

namespace App\Http\Requests\Catalog;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        $productId = $this->route('id');

        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'price' => ['sometimes', 'required', 'numeric', 'min:0'],
            'sku' => [
                'sometimes',
                'required',
                'string',
                Rule::unique('products', 'sku')->ignore($productId),
            ],
            'category_id' => ['sometimes', 'required', 'exists:categories,id', 'integer'],
            'is_published' => ['sometimes', 'boolean'],
            'attributes' => ['sometimes', 'array'],
            'attributes.*.name' => ['required', 'string'],
            'attributes.*.value' => ['required', 'string']
        ];
    }
}
