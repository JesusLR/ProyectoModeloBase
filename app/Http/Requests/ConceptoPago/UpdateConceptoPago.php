<?php

namespace App\Http\Requests\ConceptoPago;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ConceptoPago;

class UpdateConceptoPago extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'conpClave' => "required|max:99",
            'conpNombre' => 'required|max:50',
            'conpAbreviatura' => 'max:15'
        ];
    }

    public function messages() {

        return [
            //
            'conpClave.required' => 'Se requiere una Clave de concepto.',
            'conpClave.max' => 'la clave no debe ser mayor a 99.',
            'conpNombre.required' => 'Se requiere un nombre del concepto.',
            'conpNombre.max' => 'El nombre no debe exceder los 50 caracteres.',
            'conpAbreviatura.max' => 'La abreviatura no debe exeder de 15 caracteres.'
        ];
    }

}//StoreConceptoPago class.
