<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PriceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'unit_price_catalog' => 'required|numeric|min:0|max:99',
            'unit_price_catalog_discount' => 'required|numeric|min:0|max:99',
            'unit_price_own' => 'required|numeric|min:0|max:99',
            'unit_price_own_discount' => 'required|numeric|min:0|max:99',
            'qty_discount' => 'required|numeric|min:0|max:99',
        ];
    }
}