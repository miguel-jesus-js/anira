<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TypeTableRequest extends FormRequest
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
            'type_table' => 'required|min:3|max:50|regex:/^[\sA-Za-zÁÉÍÓÚáéíóúÑñ]{3,30}$/',
        ];
    }

    public function messages(): array
    {
        return [
            'type_table.required' => 'Escribe el tipo de mesa',
            'type_table.min' => 'El tipo de mesa debe tener mínimo 3 caracteres',
            'type_table.max' => 'El tipo de mesa debe tener máximo 30 caracteres',
            'type_table.regex' => 'El tipo de mesa debe ser letras sin caracteres especiales',
        ];
    }
}
