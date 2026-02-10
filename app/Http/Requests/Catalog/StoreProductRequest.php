<?php

namespace App\Http\Requests\Catalog;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'sku' => ['required', 'string', 'unique:products,sku'],
            'category_id' => ['required', 'exists:categories,id','integer'],
            'is_published' => ['boolean'],
            'attributes' => ['array'],
            'attributes.*.name' => ['required', 'string'],
            'attributes.*.value' => ['required', 'string'],
        ];
    }
}
