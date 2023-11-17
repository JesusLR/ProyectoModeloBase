<?php

namespace App\Http\Requests\AlumnoRestringido;

use Illuminate\Foundation\Http\FormRequest;

class StoreRestringido extends FormRequest
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
            'aluClave' => 'required',
            'lnNivel' => 'required',
        ];
    }

    public function messages() {

        return [
            'aluClave.required' => 'Se requiere la Clave de Pago',
            'lnNivel.required' => 'Requiere que especifique un Nivel de Bloqueo',
        ];
    }
}
