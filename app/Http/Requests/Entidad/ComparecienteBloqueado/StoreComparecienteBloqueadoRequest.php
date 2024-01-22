<?php

namespace App\Http\Requests\Entidad\ComparecienteBloqueado;

use Illuminate\Foundation\Http\FormRequest;

class StoreComparecienteBloqueadoRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            's_referencia' => 'required|max:70',
            's_numero'=> 'required|min:3|max:70',
            's_condicion'=> 'required|max:10',
            's_observacion'=> 'required',
            's_ruta'=> 'required',
            'comparecientes' => 'array|required'
        ];
    }
}
