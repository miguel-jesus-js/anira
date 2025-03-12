<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;


class TypeCustomersRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'type_customer' => 'required|min:3|max:50|regex:/^[\sA-Za-zÁÉÍÓÚáéíóúÑñ]{3,30}$/',
        ];
    }

    public function messages(): array
    {
        return [
            'type_customer.required' => 'Escribe el tipo de cliente.',
            'type_customer.min' => 'El tipo de cliente debe tener mínimo 3 caracteres',
            'type_customer.max' => 'El tipo de cliente debe tener máximo 50 caracteres',
            'type_customer.regex' => 'El tipo de cliente debe ser letras sin caracteres especiales',
        ];
    }
}
