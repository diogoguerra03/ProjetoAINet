<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ColorRequest extends FormRequest
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
            // code required
            'code' => 'required|string|max:6|unique:colors,code|min:6',
            // name required
            'name' => 'required|string|max:30',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ];
    }
}