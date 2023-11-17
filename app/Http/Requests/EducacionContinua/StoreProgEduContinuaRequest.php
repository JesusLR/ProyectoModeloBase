<?php

namespace App\Http\Requests\EducacionContinua;

use Illuminate\Foundation\Http\FormRequest;

class StoreProgEduContinuaRequest extends FormRequest
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
            'ubicacion_id'              => 'required|exists:ubicacion,id',
            'escuela_id'                => 'required|exists:escuelas,id',
            'periodo_id'                => 'required|exists:periodos,id',
            'tipoprograma_id'           => 'required|exists:tiposprograma,id',
            'ecClave'                   => 'required|max:15',
            'ecNombre'                  => 'required|max:255',
            'ecFechaRegistro'           => 'required|date',
            'ecCoordinador_empleado_id' => 'required|exists:empleados,id',
            'ecEstado'                  => 'required',

            'ecInstructor1_empleado_id' => 'nullable|exists:empleados,id',
            'ecInstructor2_empleado_id' => 'nullable|exists:empleados,id',
            'ecImporteInscripcion'      => 'nullable',
            'ecVencimientoInscripcion'  => 'nullable|date',
            'ecImportePago1'            => 'nullable',
            'ecVencimientoPago1'        => 'nullable|date',
            'ecImportePago2'            => 'nullable',
            'ecVencimientoPago2'        => 'nullable|date',
            'ecImportePago3'            => 'nullable',
            'ecVencimientoPago3'        => 'nullable|date',
            'ecImportePago4'            => 'nullable',
            'ecVencimientoPago4'        => 'nullable|date',
            'ecImportePago5'            => 'nullable',
            'ecVencimientoPago5'        => 'nullable|date',
            'ecImportePago6'            => 'nullable',
            'ecVencimientoPago6'        => 'nullable|date',
            'ecImportePago7'            => 'nullable',
            'ecVencimientoPago7'        => 'nullable|date',
            'ecImportePago8'            => 'nullable',
            'ecVencimientoPago8'        => 'nullable|date',
        ];
    }

    public function messages()
    {
        return [
            'ubicacion_id.required'              => 'Es necesario proporcionar una ubicacion.',
            'escuela_id.required'                => 'Es necesario proporcionar una escuela.',
            'periodo_id.required'                => 'Es necesario proporcionar un periodo.',
            'tipoprograma_id.required'           => 'Es necesario proporcionar un tipo.',
            'ecClave.required'                   => 'Es necesario proporcionar una clave.',
            'ecNombre.required'                  => 'Es necesario proporcionar un nombre.',
            'ecFechaRegistro.required'           => 'Es necesario proporcionar una fecha de registro.',
            'ecCoordinador_empleado_id.required' => 'Es necesario elegir un coordinador.',
            'ecEstado.required'                  => 'Es necesario proporcionar un estado de carrera',

            'ubicacion_id.exists'              => 'La ubicacion proporcionada no es válido.',
            'escuela_id.exists'                => 'La escuela proporcionada no es válido.',
            'periodo_id.exists'                => 'El periodo proporcionado no es válido.',
            'tipoprograma_id.exists'           => 'El tipo de programa proporcionado no es válido.',
            'ecCoordinador_empleado_id.exists' => 'El empleado elegido no es válido.',

            'ecClave.max'  => 'La clave no debe exceder de 15 caracteres.',
            'ecNombre.max' => 'El nombre no debe exceder de 255 caracteres.',
        ];
    }
}
