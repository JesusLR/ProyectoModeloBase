<?php

namespace App\Http\Requests\Prefecteo;

use Illuminate\Foundation\Http\FormRequest;

class StorePrefecteoRequest extends FormRequest
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
            'ubicacion_id' => 'required',
            'departamento_id' => 'required',
            'periodo_id' => 'required',
            'prefFecha' => 'required|date',
        ];
    }

    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
    public function messages()
    {
        return [
            'ubicacion_id.required' => 'Debe especificar una ubicación',
            'departamento_id.required'  => 'Debe especicar un departamento.',
            'periodo_id.required' => 'Debe especificar un periodo',
            'prefFecha.required' => 'Debe especificar una fecha de revisión.',
            'prefFecha.date' => 'El formato de fecha no es válido.'
        ];
    }
}
