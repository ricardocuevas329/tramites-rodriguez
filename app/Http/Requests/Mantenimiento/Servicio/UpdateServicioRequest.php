<?php

namespace App\Http\Requests\Mantenimiento\Servicio;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateServicioRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            's_nombre' => [
                'required' , Rule::unique('servicios', 's_nombre')->ignore($this->servicio->s_codigo, 's_codigo') ,'max:400'
            ],
            's_descripcion'=> 'nullable|max:400',
            's_generico'=> 'nullable|max:5',
            'i_formato' => 'nullable|max:10',
            'i_rapidos' => 'nullable|max:10'
        ];
    }
}
