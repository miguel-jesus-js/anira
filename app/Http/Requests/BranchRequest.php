<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
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
            'address_id' => 'nullable|numeric|exists:addresses,id',
            'employee_id' => 'nullable|numeric|exists:employees,id',
            'name' => 'required|min:3|max:50|regex:/^[\sA-Za-zÁÉÍÓÚáéíóúÑñ]{3,30}$/',
            'email' => 'required|min:10|max:50|email|unique:branches,email,' . $this->id,
            'phone_number' => 'required|min:8|max:11|unique:branches,phone_number,' . $this->id,
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Escribe el nombre',
            'name.min' => 'El nombre tener mínimo 3 caracteres',
            'name.max' => 'El nombre debe tener máximo 30 caracteres',
            'name.regex' => 'El nombre debe ser letras sin caracteres especiales',
            'address_id.numeric' => 'La dirección debe ser un número',
            'address_id.exists' => 'La dirección no coincide con la base de datos',
            'employee_id.numeric' => 'El empleado debe ser un número',
            'employee_id.exists' => 'El empleado no coincide con la base de datos',
            'email.min' => 'El correo debe tener mínimo 10 caracteres',
            'email.max' => 'El correo debe tener máximo 50 caracteres',
            'email.email' => 'El correo no es válido',
            'email.unique' => 'El correo ya existe',
            'phone_number.required' => 'Escribe tu número de teléfono',
            'phone_number.min' => 'El teléfono debe tener mínimo 8 caracteres',
            'phone_number.max' => 'El teléfono debe tener máximo 11 caracteres',
            'phone_number.unique' => 'El teléfono ya existe',
        ];
    }
}
