<?php

namespace App\Http\Requests\Catalog;

use App\Enums\Catalog\StockMovementReason;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class AdjustInventoryRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'quantity_change' => ['required','integer','not_in:0'],
            'reason' => ['required', new Enum(StockMovementReason::class)],
        ];
    }
}
