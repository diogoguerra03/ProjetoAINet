<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Defina a autorização conforme suas necessidades.
        // Por exemplo, você pode verificar se o usuário atual tem permissão para atualizar o perfil.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                Rule::unique('users', 'name')->ignore($this->id),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->id),
            ],
            'photo_url' => 'sometimes|image|max:4096', // maxsize = 4Mb
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo de nome é obrigatório.',
            'name.string' => 'O campo de nome deve ser uma string.',
            'name.max' => 'O campo de nome não pode exceder 255 caracteres.',
            'photo_url.image' => 'O ficheiro com a foto não é uma imagem',
            'photo_url.size' => 'O tamanho do ficheiro com a foto tem que ser inferior a 4 Mb',
        ];
    }
}