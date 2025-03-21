<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $rules = [
            'user.user_name' => 'required|min:10|max:20|unique:users,user_name',
            'user.password' => 'required|min:8',
            'user.password_repeat' => 'required|same:user.password',
            'people.first_name' => 'required|min:3|max:50|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u',
            'people.last_name' => 'required|min:3|max:50|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u',
            'people.email' => 'required|min:10|max:50|email|unique:people,email',
            'people.dni' => 'required|numeric|digits_between:10,20|unique:people,dni',
            'people.phone_number' => 'required|min:8|max:11|unique:people,phone_number',
        ];

        if ($this->get('type_entity') === 'employee') {
            $rules['type_employee_id'] = 'required|numeric|exists:type_employees,id';
        } else {
            $rules['type_customer_id'] = 'required|numeric|exists:type_customers,id';
        }
        return $rules;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function messages(): array
    {
        $messages = [
            'user.user_name.required' => 'El nombre de usuario es obligatorio.',
            'user.user_name.min' => 'El nombre de usuario debe tener al menos 10 caracteres.',
            'user.user_name.max' => 'El nombre de usuario debe tener máximo 20 caracteres.',
            'user.user_name.unique' => 'El nombre de usuario ya existe.',
            'user.password.required' => 'La contraseña es obligatorio.',
            'user.password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'user.password_repeat.required' => 'La confirmación de contraseña es obligatorio.',
            'user.password_repeat.same' => 'La contraseña no coincide.',
            'people.first_name.required' => 'Escribe tu nombre',
            'people.first_name.min' => 'El nombre debe tener mínimo 3 caracteres',
            'people.first_name.max' => 'El nombre debe tener máximo 50 caracteres',
            'people.first_name.regex' => 'El nombre debe ser letras sin caracteres especiales',
            'people.last_name.required' => 'Escribe tu apellido',
            'people.last_name.min' => 'El apellido debe tener mínimo 3 caracteres',
            'people.last_name.max' => 'El apellido debe tener máximo 50 caracteres',
            'people.last_name.regex' => 'El apellido debe ser letras sin caracteres especiales',
            'people.email.required' => 'Escribe tu correo',
            'people.email.min' => 'El correo debe tener mínimo 10 caracteres',
            'people.email.max' => 'El correo debe tener máximo 50 caracteres',
            'people.email.email' => 'El correo no es válido',
            'people.email.unique' => 'El correo ya existe',
            'people.dni.required' => 'El DNI es obligatorio.',
            'people.dni.numeric' => 'El DNI debe ser numérico.',
            'people.dni.digits_between' => 'El DNI debe tener entre 10 y 20 dígitos.',
            'people.dni.unique' => 'El DNI ya existe en la base de datos.',
            'people.phone_number.required' => 'Escribe tu número de teléfono',
            'people.phone_number.min' => 'El teléfono debe tener mínimo 8 caracteres',
            'people.phone_number.max' => 'El teléfono debe tener máximo 11 caracteres',
            'people.phone_number.unique' => 'El teléfono ya existe',
        ];

        if ($this->get('type_entity') === 'employee') {
            $messages['type_employee_id.required'] = 'Seleccione un tipo de empleado';
            $messages['type_employee_id.numeric'] = 'El tipo de empleado debe ser un número';
            $messages['type_employee_id.exists'] = 'El tipo de empleado no coincide con la base de datos';
        } else {
            $messages['type_customer_id.required'] = 'Seleccione un tipo de cliente';
            $messages['type_customer_id.numeric'] = 'El tipo de cliente debe ser un número';
            $messages['type_customer_id.exists'] = 'El tipo de cliente no coincide con la base de datos';
        }
        return $messages;
    }
}
