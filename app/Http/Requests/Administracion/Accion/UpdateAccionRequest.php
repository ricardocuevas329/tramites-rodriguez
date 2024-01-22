<?php

namespace App\Http\Requests\Administracion\Accion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAccionRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */


    public function rules()
    {
        return [
            's_nombre' => [
                'required' , Rule::unique('acciones', 's_nombre')->ignore($this->action->i_codigo, 'i_codigo') ,'max:120'
            ],
            's_descripcion' => 'nullable|max:255',
            's_codper' => [
                'required' , Rule::unique('acciones', 's_codper')->ignore($this->action->i_codigo, 'i_codigo') ,'max:4'
            ],


        ];


    }

}
