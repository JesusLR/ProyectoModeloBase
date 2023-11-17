<?php

namespace App\Http\Requests\Registro;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegistro extends FormRequest
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
            'departamento_id' => 'required',
            'regFechaInicioVigencia' => 'required|date',
            'regNombreResponsable' => 'required'
        ];
    }

    public function messages() {

        return [
            'departamento_id.required' => 'Se requiere especificar un departamento.',
            'regFechaInicioVigencia.required' => 'Se requiere especificar una fecha de inicio de vigencia',
            'regNombreResponsable' => 'Se requiere el nombre del Responsable',
            'regFechaInicioVigencia.date' => 'favor de verificar la fecha de inicio de vigencia'
        ];
    }






}
