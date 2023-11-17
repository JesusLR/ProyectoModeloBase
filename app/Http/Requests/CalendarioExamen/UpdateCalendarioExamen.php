<?php

namespace App\Http\Requests\CalendarioExamen;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCalendarioExamen extends FormRequest
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
            'calexInicioParcial1' => 'nullable|date|required_with:calexFinParcial1|after_or_equal:perFechaInicial|before_or_equal:perFechaFinal',
            'calexInicioParcial2' => 'nullable|date|required_with:calexFinParcial2|after_or_equal:perFechaInicial|before_or_equal:perFechaFinal',
            'calexInicioParcial3' => 'nullable|date|required_with:calexFinParcial3|after_or_equal:perFechaInicial|before_or_equal:perFechaFinal',
            'calexInicioOrdinario' => 'nullable|date|required_with:calexFinOrdinario|after_or_equal:perFechaInicial|before_or_equal:perFechaFinal',
            'calexInicioExtraordinario' => 'nullable|date|required_with:calexFinExtraordinario|after_or_equal:perFechaInicial|before_or_equal:perFechaFinal',
            'calexFinParcial1' => 'nullable|date|after:calexInicioParcial1|after_or_equal:perFechaInicial|before_or_equal:perFechaFinal',
            'calexFinParcial2' => 'nullable|date|after:calexInicioParcial2|after_or_equal:perFechaInicial|before_or_equal:perFechaFinal',
            'calexFinParcial3' => 'nullable|date|after:calexInicioParcial3|after_or_equal:perFechaInicial|before_or_equal:perFechaFinal',
            'calexFinOrdinario' => 'nullable|date|after:calexInicioOrdinario|after_or_equal:perFechaInicial|before_or_equal:perFechaFinal',
            'calexFinExtraordinario' => 'nullable|date|after:calexInicioExtraordinario|after_or_equal:perFechaInicial|before_or_equal:perFechaFinal',
        ];
    }

    public function messages() {

        return [
            'calexInicioParcial1.required_with' => '1er Parcial. Si ingresa fecha final, debe especificar fecha inicial.',
            'calexInicioParcial2.required_with' => '2do Parcial. Si ingresa fecha final, debe especificar fecha inicial.',
            'calexInicioParcial3.required_with' => '3er Parcial. Si ingresa fecha final, debe especificar fecha inicial.',
            'calexInicioOrdinario.required_with' => 'Ordinario. Si ingresa Fin ordinario, debe especificar Inicio ordinario.',
            'calexInicioExtraordinario.required_with' => 'Extraordinario. Si ingresa Fin extraordinario, debe especificar Inicio extraordinario.',
            'after' => 'Las fechas finales deben ser posteriores a las fechas iniciales. Verifique sus fechas.',
            'after_or_equal' => 'Las fechas deben ser iguales o posteriores a la fecha inicial del semestre. Verifique sus fechas.',
            'before_or_equal' => 'Las fechas no deben ser posteriores a las fecha final del semestre. Verifique sus fechas.'
        ];
    }


}
