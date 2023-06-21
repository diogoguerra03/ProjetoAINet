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
        return [
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image_url' => 'sometimes|image|max:4096',
            // maxsize = 4Mb
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
            'category_id.exists' => 'A categoria selecionada não é válida.',
            'name.required' => 'O campo de nome é obrigatório.',
            'name.string' => 'O campo de nome deve ser uma string.',
            'name.max' => 'O campo de nome não pode exceder 255 caracteres.',
            'description.required' => 'O campo de descrição é obrigatório.',
            'description.string' => 'O campo de descrição deve ser uma string.',
            'description.max' => 'O campo de descrição não pode exceder 255 caracteres.',
            'image_url.image' => 'O ficheiro com a foto não é uma imagem',
            'image_url.size' => 'O tamanho do ficheiro com a foto tem que ser inferior a 4 Mb',
            'customer_id.exists' => 'O cliente selecionado não é válido.',
        ];
    }
}