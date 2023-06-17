<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();
        $paymentType = $this->input('default_payment_type');

        if ($paymentType === 'VISA' || $paymentType === 'MC') {
            $paymentRefRules[] = 'required_with:default_payment_type';
            $paymentRefRules[] = 'digits:16';
        } elseif ($paymentType === 'PAYPAL') {
            $paymentRefRules[] = 'required_with:default_payment_type';
            $paymentRefRules[] = 'email';
        } else {
            $paymentRefRules[] = 'nullable';
        }

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'min:3',
                Rule::unique('users', 'name')->ignore($user->id),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'nif' => [
                'nullable',
                'digits:9',
                Rule::unique('customers', 'nif')->ignore($user->id),
            ],
            'image' => 'sometimes|image|max:4096',
            // maxsize = 4Mb
            'default_payment_ref' => $paymentRefRules,
            'address' => 'nullable|string|max:255',
            // adicionado a regra para o campo 'address'
            'default_payment_type' => 'nullable|in:VISA,MC,PAYPAL',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name field must be a string.',
            'name.max' => 'The name field must be less than 255 characters.',
            'name.min' => 'The name field must be at least 3 characters.',
            'image.image' => 'The photo must be an image file.',
            'image.size' => 'The photo must be less than 4Mb.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email field must be a valid email address.',
            'nif.digits' => 'The NIF field must be a number with 9 digits.',
            'default_payment_ref.required_with' => 'The default payment reference field is required.',
            'default_payment_ref.digits' => 'The default payment reference field must be a number with 16 digits.',
            'default_payment_ref.email' => 'The default payment reference field must be a valid email address.',
            'address.string' => 'The address field must be a string.',
            'address.max' => 'The address field must be less than 255 characters.',
            'default_payment_type.in' => 'The default payment type field must be one of the following types: VISA, MC, PAYPAL.',
        ];
    }
}