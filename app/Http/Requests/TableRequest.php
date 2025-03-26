<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TableRequest extends FormRequest
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
            'type_table_id' => 'required|numeric|exists:type_tables,id',
            'number'        => 'required|integer',
            'name'          => 'required|min:3|max:50|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u',
            'description'   => 'required|min:3|max:50|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u',
            'capacity'      => 'required|integer',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function messages(): array
    {
        return [
            'type_table_id.required' => 'Escribe tipo de mesa',
            'type_table_id.numeric' => 'El tipo de mesa debe ser un número',
            'type_table_id.exists' => 'El tipo de mesa no coincide con la base de datos',
            'name.required' => 'Escribe el nombre de la mesa',
            'name.min' => 'El nombre debe tener mínimo 3 caracteres',
            'name.max' => 'El nombre debe tener máximo 50 caracteres',
            'name.regex' => 'El nombre debe ser letras sin caracteres especiales',
            'description.required' => 'Escribe la descripción',
            'description.min' => 'La descripción mínimo 3 caracteres',
            'description.max' => 'La descripción debe tener máximo 50 caracteres',
            'description.regex' => 'La descripción debe ser letras sin caracteres especiales',
            'number.required' => 'Escribe el numero de mesa',
            'number.numeric' => 'El numero de mesa debe ser un número',
            'capacity.required' => 'Escribe la capacidad de mesa',
            'capacity.numeric' => 'La capacidad de mesa debe ser un número',
        ];
    }
}
