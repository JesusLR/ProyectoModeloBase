<?php

namespace App\Http\Requests\Puesto;

use Illuminate\Foundation\Http\FormRequest;

class StorePuestoRequest extends FormRequest
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
            'puesNombre' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'puesNombre.required' => 'El nombre del Puesto es obligatorio.',
        ];
    }
}
