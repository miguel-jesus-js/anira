<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'address' => 'required|min:3|max:255',
            'street' => 'required|min:3|max:150|regex:/^[\sA-Za-zÁÉÍÓÚáéíóúÑñ]{3,150}$/',
            'neighborhood' => 'required|min:3|max:150|regex:/^[\sA-Za-zÁÉÍÓÚáéíóúÑñ]{3,150}$/',
            'interior_number' => 'nullable|min:1|max:8|regex:/^[0-9]{1,5}$/',
            'outer_number' => 'nullable|min:1|max:8|regex:/^[0-9]{1,8}$/',
            'city' => 'required|min:3|max:50|regex:/^[\sA-Za-zÁÉÍÓÚáéíóúÑñ]{3,50}$/',
            'state' => 'required|min:3|max:50|regex:/^[\sA-Za-zÁÉÍÓÚáéíóúÑñ]{3,50}$/',
            'locality' =>'required|min:3|max:50|regex:/^[\sA-Za-zÁÉÍÓÚáéíóúÑñ]{3,50}$/',
            'cp' => 'required|min:1|max:8|regex:/^[0-9]{1,8}$/',
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
            'address.required' => 'Escribe alguna dirección',
            'address.min' => 'La dirección debe tener mínimo 3 caracteres',
            'address.max' => 'La dirección debe tener máximo 150 caracteres',
            'street.required' => 'Escribe alguna calle',
            'street.min' > 'La calle debe tener mínimo 3 caracteres',
            'street.max' => 'La calle debe tener máximo 150 caracteres',
            'street.regex' => 'La calle debe ser letras sin caracteres especiales',
            'neighborhood.required' => 'Escribe alguna colonia',
            'neighborhood.min' => 'La colonia debe tener mínimo 3 caracteres',
            'neighborhood.max' => 'La colonia debe tener máximo 150 caracteres',
            'neighborhood.regex' => 'La colonia debe ser letras sin caracteres especiales',
            'interior_number.min' => 'El número interior debe tener mínimo 1 caracter',
            'interior_number.max' => 'El número interior debe tener máximo 5 caracteres',
            'interior_number.regex' => 'El número interior no debe contener caracteres especiales',
            'outer_number.min' => 'El número exterior debe tener mínimo 1 caracter',
            'outer_number.max' => 'El número exterior debe tener máximo 5 caracteres',
            'outer_number.regex' => 'El número exterior no debe contener caracteres especiales',
            'city.required' => 'Escribe alguna ciudad',
            'city.min' => 'La ciudad debe tener mínimo 3 caracteres',
            'city.max' => 'La ciudad debe tener máximo 50 caracteres',
            'city.regex' => 'La ciudad debe ser letras sin caracteres especiales',
            'state.required' => 'Escribe algún estado',
            'state.min' => 'La estado debe tener mínimo 3 caracteres',
            'state.max' => 'La estado debe tener máximo 50 caracteres',
            'state.regex' => 'La estado debe ser letras sin caracteres especiales',
            'locality.required' => 'Escribe alguna localidad',
            'locality.min' => 'La localidad debe tener mínimo 3 caracteres',
            'locality.max' => 'La localidad debe tener máximo 50 caracteres',
            'locality.regex' => 'La localidad debe ser letras sin caracteres especiales',
            'cp.required' => 'Escribe algún código postal',
            'cp.min' => 'El código postal debe tener mínimo 1 carácter',
            'cp.max' => 'El código postal debe tener máximo 8 caracteres',
            'cp.regex' => 'El código postal debe ser numeros',
        ];
    }
}
