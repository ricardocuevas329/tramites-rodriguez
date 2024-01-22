<?php

namespace App\Http\Requests\Mantenimiento\Nacionalidad;

use Illuminate\Foundation\Http\FormRequest;

class StoreNacionalidadRequest extends FormRequest
{
 
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            's_codigo_sbs' => 'required|max:3',
            's_gentilicio' => 'required|min:3|max:50',
            's_pais' => 'unique:nacionalidad,s_pais|required|max:50',
        ];
    }
}
