<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'name' => 'required|string|max:255',
            'photo_url' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Apenas arquivos de imagem são permitidos, com tamanho máximo de 2MB
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
