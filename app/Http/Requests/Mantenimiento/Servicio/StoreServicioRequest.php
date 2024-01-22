<?php

namespace App\Http\Requests\Mantenimiento\Servicio;

use Illuminate\Foundation\Http\FormRequest;

class StoreServicioRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            's_nombre' => 'unique:unidades,s_nombre|required|max:80',
            's_descripcion'=> 'nullable|max:100',
            's_generico'=> 'nullable|max:5',
            'i_formato'=> 'nullable|max:10|numeric',
            'i_rapidos'=> 'nullable|max:10|numeric',
        ];
    }
}
