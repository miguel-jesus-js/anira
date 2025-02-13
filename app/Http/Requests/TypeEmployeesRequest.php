<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TypeEmployeesRequest extends FormRequest
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
            'type_employee' => 'required|min:3|max:50|regex:/^[\sA-Za-zÁÉÍÓÚáéíóúÑñ]{3,30}$/',
        ];
    }

    public function messages(): array
    {
        return [
            'type_employee.required' => 'Escribe el tipo de empleado.',
            'type_employee.min' => 'El tipo de empleado debe tener mínimo 3 caracteres',
            'type_employee.max' => 'El tipo de empleado debe tener máximo 50 caracteres',
            'type_employee.regex' => 'El tipo de empleado debe ser letras sin caracteres especiales',
        ];
    }
}
