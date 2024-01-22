<?php

namespace App\Http\Requests\Entidad\Cliente;

use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            's_materno' => 'required|min:3|max:50',
            's_paterno' => 'required|min:3|max:50',
            's_nombres' => 'required|min:3|max:50',
            's_estado_civil' => 'required|min:3|max:20',
            's_direccion' => 'required|min:3|max:150',
            's_correo' => 'unique:cliente,s_correo|nullable|max:150',
            'id_tipo_documento' => 'required|min:3|max:5',
            's_num_doc' => 'required|min:3|max:30',
            's_localidad' => 'required|min:1|max:100',
            's_sexo' => 'required|min:1|max:1',
        ];
    }
}
