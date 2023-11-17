<?php

namespace App\Http\Requests\Pago;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use Carbon\Carbon;

class StoreFichaGeneralRequest extends FormRequest
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
        $hoy  = Carbon::now('America/Merida');

        return [
            'aluClave' => 'required|exists:alumnos,aluClave',
            'cuoFecha' => 'required|date',
            'cuoAnio' => 'required',
            'cuoConcepto' => 'required',
            'importeNormal' => 'required',
            'cuoFechaVenc' => 'nullable|date|after_or_equal:'.$hoy->format('Y-m-d').'|before:2100-01-01',
            // 'banco' => ['required', Rule::in(['BBVA', 'HSBC'])],
        ];
    }

    public function messages()
    {
        return [
            'aluClave.required' => 'La clave de alumno es requerida.',
            'aluClave.exists' => 'Inserte una clave de alumno válida.',
            'cuoFecha.required' => 'La Fecha es requerida.',
            'cuoFecha.date' => 'El formato de fecha no es válido.',
            // 'cuoFecha.before_or_equal' => 'La fecha de ficha no debe ser mayor a la fecha de vencimiento.',
            'cuoAnio.required' => 'El año de inicio de curso es requerido.',
            'cuoConcepto.required' => 'El concepto de pago es requerido.',
            'importeNormal.required' => 'El importe es requerido.',
            'cuoFechaVenc.required' => 'La fecha de vencimiento es requerida.',
            'cuoFechaVenc.date' => 'El formato de fecha de vencimiento no es válido.',
            'cuoFechaVenc.after_or_equal' => 'La fecha de vencimiento no puede ser del tiempo pasado.',
            'cuoFechaVenc.before' => 'La fecha de vencimiento es excesivamente lejana, no debe ser mayor al año 2099.',
            // 'banco.required' => 'Es necesario seleccionar un banco.',
            // 'banco.in' => 'El banco seleccionado no es válido. Solo se permite BBVA y HSBC',
        ];
    }
}
