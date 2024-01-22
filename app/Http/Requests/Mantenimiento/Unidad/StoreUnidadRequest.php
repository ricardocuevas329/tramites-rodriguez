<?php

namespace App\Http\Requests\Mantenimiento\Unidad;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnidadRequest extends FormRequest
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
            's_abrev'=> 'required|min:1|max:10',
            's_observacion'=> 'nullable|max:200',
        ];
    }
}
