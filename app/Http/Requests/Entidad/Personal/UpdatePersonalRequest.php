<?php

namespace App\Http\Requests\Entidad\Personal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePersonalRequest extends FormRequest
{
    

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            's_materno' => 'nullable|min:3|max:50',
            's_paterno' => 'required|min:3|max:50',
            's_nombres' => 'required|min:3|max:70',
            's_nombre_seg' => 'nullable|max:70',
            's_distrito' =>  'required|min:2|max:50',
            's_user' => [
                'required' , Rule::unique('personal', 's_user')->ignore($this->personal->s_codigo, 's_codigo') ,'max:20'
            ], 
            's_direccion' => 'required|min:1|max:100',
            's_mail' => [
                'required' , Rule::unique('personal', 's_mail')->ignore($this->personal->s_codigo, 's_codigo') ,'max:70'
            ], 
            'id_tipo_documento' => 'required|min:1|max:5',
            's_numero' => 'required|min:1|max:20',
            'roles' => 'array|min:1',
            'permissions' => 'array|min:1',
            's_pass' => 'nullable|min:3|max:250',
            's_sexo' => 'required|min:1|max:1',
            'estado_civil' => 'required',
        ];
    }
}
