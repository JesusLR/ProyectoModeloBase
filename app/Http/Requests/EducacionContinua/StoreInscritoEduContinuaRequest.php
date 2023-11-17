<?php

namespace App\Http\Requests\EducacionContinua;

use Illuminate\Foundation\Http\FormRequest;

class StoreInscritoEduContinuaRequest extends FormRequest
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
            'alumno_id' => 'required|exists:alumnos,id',
            'educacioncontinua_id' => 'required|exists:educacioncontinua,id',
            'iecGrupo' => 'nullable|max:3',
            'iecFechaRegistro' => 'required|date',
            'iecImporteInscripcion' => 'nullable',
            'iecFechaProcesoRegistro' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'alumno_id.required' => 'Es necesario proporcionar un alumno.',
            'educacioncontinua_id.required' => 'Es necesario elegir un Programa de Educación Continua.',
            'iecGrupo.max' => 'El campo de grupo es requerido.',
            'iecFechaRegistro.required' => 'La fecha de registro es requerida',
            'iecFechaProcesoRegistro.required' => 'La fecha de proceso es requerida.',
        ];
    }
}
