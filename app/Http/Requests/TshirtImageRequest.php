<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TshirtImageRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $isCreating = $this->method() === 'POST';

        if ($isCreating) {
            $rules['image_url'] = 'required|image|max:4096';
        } else {
            $rules['image_url'] = 'sometimes|image|max:4096';
        }

        return [
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            // maxsize = 4Mb
            'image_url' => $rules['image_url'],
            'customer_id' => 'nullable|exists:users,id',
        ];

    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'category_id.exists' => 'The selected category does not exist.',
            'image_url.required' => 'The image is required.',
            'image_url.image' => 'The image must be an image.',
            'image_url.max' => 'The image must be less than 4Mb.',
            'name.required' => 'The name is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name must be less than 255 characters.',
            'description.required' => 'The description is required.',
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description must be less than 255 characters.',
            'customer_id.exists' => 'The selected customer does not exist.',
        ];
    }
}