<?php

namespace App\Http\Requests\Revalidaciones;

use Illuminate\Foundation\Http\FormRequest;

use App\Http\Models\Materia;

class RevalidarRequest extends FormRequest
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
        $materia = Materia::findOrFail($this->materia_id);
        $optativa_rule = $materia->matClasificacion == 'O' ? 'required' : 'nullable';
        return [
            'histFechaExamen' => 'required|date',
            'histCalificacion' => 'required|integer|min:0|max:100',
            'optativa_id' => $optativa_rule,
        ];
    }

    public function messages()
    {
        return [
            'histFechaExamen.required' => 'La fecha es requerida.',
            'histFechaExamen.date' => 'El formato de fecha no es correcto',
            'histCalificacion.required' => 'Requerimos que especiffique una calificación.',
            'histCalificacion.integer' => 'La calificación debe ser un número entero.',
            'histCalificacion.min' => 'La calificación no debe ser menor a 0.',
            'histCalificacion.max' => 'La calificación no debe ser mayor a 100.',
            'optativa_id.required' => 'Es necesario que especifique una optativa.',
        ];
    }
}
