<?php

namespace App\Http\Requests\UsuaGim;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUsuaGimRequest extends FormRequest
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
            'gimTipo' => 'required',
            'gimApellidoPaterno' => 'required',
            'gimNombre' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'gimTipo.required' => 'Debe especificar un tipo de usuario',
            'gimNombre.required' => 'Debe proporcionar el nombre del usuario',
            'gimApellidoPaterno.required' => 'Debe proporcionar almenos el apellido paterno del usuario',
        ];
    }

}
